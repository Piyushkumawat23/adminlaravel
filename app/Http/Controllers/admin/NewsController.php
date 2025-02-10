<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;  

use App\Models\News;

class NewsController extends Controller {



    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }


    public function index() {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create() {
        $news = new News(); // Empty news object
        return view('admin.news.create', compact('news'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->status = $request->status ?? 0;

        if ($request->hasFile('image')) {
            // Get the uploaded image
            $image = $request->file('image');
            // Generate a unique name for the image
            $imageName = time() . '_' . $image->getClientOriginalName();
            // Define the folder path
            $imagePath = 'news_images/' . $imageName;
            // Move the image to the public/news_images folder
            $image->move(public_path('news_images'), $imageName);
            // Save the image path in the database
            $news->image = $imagePath;
        }
    
        $news->status = $request->status ?? 0;
        $news->save();
    
        return redirect()->route('admin.news.index')->with('success', 'News added successfully!');
    }
    

    public function edit($id) {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id) {
        $news = News::findOrFail($id);
        
        $news->title = $request->title;
        $news->content = $request->content;
        $news->status = $request->status; // Update status from dropdown
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'news_images/' . $imageName;
            $image->move(public_path('news_images'), $imageName);
    
            if ($news->image && file_exists(public_path($news->image))) {
                unlink(public_path($news->image));
            }
    
            $news->image = $imagePath;
        }
    
        $news->save();
    
        return redirect()->route('admin.news.index')->with('success', 'News updated successfully!');
    }
    
    

    public function destroy($id) {
        $news = News::findOrFail($id);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully!');
    }
}

