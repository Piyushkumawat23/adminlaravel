<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PageController extends Controller
{
    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }

    public function index()
    {
        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

//     public function store(Request $request)
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'slug' => 'required|string|max:255|unique:pages,slug',
//         'status' => 'required|in:active,inactive',
//         'content' => 'required|string',
//     ]);

//     Page::create($request->all());

//     return redirect()->route('pages.index')->with('success', 'Page created successfully.');
// }



public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:pages,slug',
        'status' => 'required|in:active,inactive',
        'content' => 'required|string',
    ]);

    // Store the page in the database
    $page = Page::create([
        'title' => $request->title,
        'slug' => $request->slug,
        'status' => $request->status,
        'content' => $request->content,
    ]);

    // Create a Blade file for this page in resources/views/user/
    $viewContent = "<h1>{$request->title}</h1><p>{$request->content}</p>"; // Customize content as needed

    // Define the file path for the new view
    $viewFilePath = resource_path("views/user/{$page->title}.blade.php");

    // Write content to the view file
    File::put($viewFilePath, $viewContent);

    return redirect()->route('pages.index')->with('success', 'Page created successfully.');
}


    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'status' => 'required|in:active,inactive',
            'content' => 'required|string',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'status' => $request->status,
            'content' => $request->content,
        ]);

        // Redirect back to the edit page with a success message
        return redirect()->route('pages.edit', $page->id)->with('success', 'Page updated successfully.');
    }
    
    // public function destroy($id)
    // {
    //     $page = Page::findOrFail($id);
    //     $page->delete();

    //     return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    // }


    public function destroy($id)
{
    $page = Page::findOrFail($id);

    // Delete the corresponding Blade file from resources/views/user/
    $viewFilePath = resource_path("views/user/{$page->title}.blade.php");

    if (File::exists($viewFilePath)) {
        File::delete($viewFilePath); // Delete the file
    }

    // Delete the page record from the database
    $page->delete();

    return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
}

}
