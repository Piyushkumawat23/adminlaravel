<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:categories,name',
             'description' => 'nullable',
         ]);
 
         Category::create([
             'name' => $request->name,
             'slug' => Str::slug($request->name),
             'description' => $request->description,
             'status' => $request->status ?? 1
         ]);
 
         return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $category = Category::findOrFail($id); // ID से कैटेगरी प्राप्त करें
    return view('admin.categories.edit', compact('category')); // View में `$category` पास करें
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id); // ID से Category प्राप्त करें

        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
            'description' => 'nullable',
            'status' => 'required|in:0,1',  // Add validation for status
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status ?? 1  // Default to 1 (Active) if no status is passed
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = Category::findOrFail($id); 
    $category->delete(); 

    return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
}



    public function updateStatus(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->status = $request->status;
        $category->save();

        return response()->json(['success' => 'Status updated successfully!']);
    }

}
