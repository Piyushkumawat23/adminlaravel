<?php

namespace App\Http\Controllers;
use App\Models\WebsiteSetting;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Post;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Models\User;
use App\Models\PostLike;
use App\Models\BlogLike;
use App\Models\PostComment;
use App\Models\BlogComment;
use App\Models\Slider;
use App\Models\SliderSetting;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function __construct()
    {
        // Share published pages across all views
        $this->shareNavPages();
    }

   
  

    public function index(){
        $this->shareNavPages(); 

        $websiteSetting = WebsiteSetting::first();
        $sliders = Slider::where('status', 1)->get();
        $posts = Post::where('status', 1)->get();
        $blogs = Blog::where('status', 1)->get();
        $settings = SliderSetting::first();
        $slides = Slider::where('status', 1)->get(); // Active slides fetch karna
         $navPages = Page::where('status', 'active')->get();
        return view('user.dashboard', compact('websiteSetting','sliders','settings', 'slides', 'posts','blogs','navPages'));
    }

    private function shareNavPages()
    {
        $navPages = Page::where('status', 'active')->get();
        // print_r($navPages);
        view()->share('navPages', $navPages);
    }


    public function showPage($slug)
    {
        $websiteSetting = WebsiteSetting::first(); // Fetch website settings
        $sliders = Slider::where('status', 1)->get();
        $settings = SliderSetting::first();


        $page = Page::where('slug', $slug)->first(); // Fetch the page based on the slug
    
        if (!$page) {
            abort(404, 'Page not found.'); // Handle missing pages
        }
    
        // Determine the Blade template to load
        $viewName = 'user.' . $slug;
    
        // Check if the view exists
        if (!view()->exists($viewName)) {
            abort(404, 'Page template not found.');
        }
    
        return view($viewName, compact('websiteSetting', 'page','sliders','settings'));
    }
    



    public function showActiveMenus()
{
    $websiteSetting = WebsiteSetting::first(); // Fetch website settings
    $settings = SliderSetting::first();
    $menuCategories = MenuCategory::with(['menus' => function ($query) {
        $query->where('status', 1);
    }])->where('status', 1)->get();

    return view('user.menus', compact('menuCategories','websiteSetting','settings'));
}

    


public function likePost(Request $request, $id)
{
    $user = auth()->user();
    if (!$user) {
        return back()->with('error', 'User not authenticated');
    }

    $post = Post::find($id);
    if (!$post) {
        return back()->with('error', 'Post not found');
    }

    // Check if already liked
    $like = PostLike::where('post_id', $post->id)
                    ->where('user_id', $user->id)
                    ->first();

    if ($like) {
        $like->delete(); // Unlike
        $post->decrement('likes');
        return back()->with('success', 'Post unliked');
    }

    // Like the post
    PostLike::firstOrCreate([
        'post_id' => $post->id,
        'user_id' => $user->id
    ]);

    $post->increment('likes');

    return back()->with('success', 'Post liked');
}






public function commentPost(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string'
    ]);

    $user = auth()->user();
    $post = Post::findOrFail($id);

    PostComment::create([
        'post_id' => $post->id,
        'user_id' => $user->id,
        'comment' => $request->comment
    ]);

    return redirect()->back();  // Redirect back to the post page
}



public function likeblog(Request $request, $id)
{
    $user = auth()->user();
    if (!$user) {
        return back()->with('error', 'User not authenticated');
    }

    $blogs = Blog::find($id);
    if (!$blogs) {
        return back()->with('error', 'Blog not found');
    }

    // Check if already liked
    $like = BlogLike::where('blog_id', $blogs->id)
                    ->where('user_id', $user->id) 
                    ->first();

    if ($like) {
        $like->delete(); // Unlike
        $blogs->decrement('likes');
        return back()->with('success', 'Blog unliked');
    }

    // Like the blog
    BlogLike::firstOrCreate([
        'blog_id' => $blogs->id,
        'user_id' => $user->id 
    ]);

    $blogs->increment('likes');

    return back()->with('success', 'Blog liked');
}

public function commentblog(Request $request, $id)
{

    $request->validate([
        'comment' => 'required|string'
    ]);

    $user = auth()->user();
    $blogs = blog::findOrFail($id);

    BlogComment::create([
        'blog_id' => $blogs->id,
        'user_id' => $user->id,
        'comment' => $request->comment
    ]);

    return redirect()->back();  // Redirect back to the Blog page
}

    
}
