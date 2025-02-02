<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'nullable|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        'description' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        // Get the uploaded image
        $image = $request->file('image');
        // Generate a new name for the image
        $imageName = time() . '_' . $image->getClientOriginalName();
        // Define the folder path
        $imagePath = 'sliders/' . $imageName;
        // Move the image to the public sliders folder
        $image->move(public_path('/sliders'), $imageName);
    }

    Slider::create([
        'title' => $request->title,
        'image' => $imagePath,  // Save the image path in the database
        'description' => $request->description,
    ]);

    return redirect()->route('admin.sliders.index')->with('success', 'Slider added successfully.');
}


    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'description' => 'nullable|string',
        ]);
    
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($slider->image) {
                $oldImagePath = public_path('/' . $slider->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Delete the old image
                }
            }
    
            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'sliders/' . $imageName;
            $image->move(public_path('/sliders'), $imageName);
    
            $slider->image = $imagePath; // Save new image path
        }
    
        // Update other fields
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->save();
    
        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }
    

    public function destroy($id)
    {
        Slider::destroy($id);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }
}
