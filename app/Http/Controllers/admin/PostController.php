<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\PostLike;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\WebsiteSetting;  


class PostController extends Controller
{


    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }
    // Show all posts
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    // Show create form
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    // Store post
    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'title' => 'required|unique:posts',
            'slug' => 'nullable|unique:posts', // Allow null, but if provided, it must be unique
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Generate slug if not provided
        $slug = $request->slug ?: Str::slug($request->title);

        // Initialize the post
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->status = $request->status ?? 1; // Default to active if not provided

        // Handle image upload
        if ($request->hasFile('image')) {
            // Get the uploaded image
            $image = $request->file('image');
            // Generate a new name for the image
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Define the folder path
            $imagePath = 'posts/' . $slug . '/' . $imageName;
            // Move the image to the public posts folder
            $image->move(public_path('posts/' . $slug), $imageName);
            // Store the image path in the database
            $post->image = $imagePath;
        }

        // Save the post
        $post->save();

        // Redirect with success message
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    
    


    // public function like($id)
    // {
    //     $post = Post::findOrFail($id);
    //     $post->likes += 1; // Increment the like count
    //     $post->save();

    //     return redirect()->back()->with('success', 'Post liked!');
    // }

    // Show edit form
   
    

    // Update post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:posts,title,' . $id,
            'slug' => 'required|unique:posts,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    // Delete post
    public function destroy($id)
    {
        Post::destroy($id);
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }



    public function updateStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->status = $request->status;
        $post->save();
        return response()->json(['success' => 'Status updated successfully!']);
    }
}
