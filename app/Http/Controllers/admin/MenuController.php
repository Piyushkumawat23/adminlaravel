<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class MenuController extends Controller
{


    // MenuCategory
    public function index()
    {
        $menuCategories = MenuCategory::with('menus')->get();
        return view('admin.menus.index', compact('menuCategories'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $category = MenuCategory::find($id);
    
        if ($category) {
            $category->status = $request->status;
            $category->save();
    
            // Set flash message for success
            session()->flash('success', 'Status updated successfully!');
    
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!'
            ]);
        }
    
        session()->flash('error', 'Failed to update status.');
    
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status.'
        ]);
    }


        public function createMenuCategory()
            {
                return view('admin.menus.createMenuCategory');
            }

            public function storeMenuCategory(Request $request)
            {
                $request->validate([
                    'menu_id' => 'required|integer|unique:menu_categories,menu_id',
                    'menu_name' => 'required|string|max:255',
                ]);
            
                MenuCategory::create([
                    'menu_id' => $request->menu_id,
                    'menu_name' => $request->menu_name,
                    'status' => 1, // Default active
                ]);
            
                return redirect()->route('admin.menus.index')->with('success', 'Menu Category added successfully.');
            }



        public function editMenuCategory($id)
        {
            $menu = Menu::findOrFail($id);
            return view('admin.menus.edit', compact('menu'));
        }
            
            public function updateMenuCategory(Request $request, $id)
            {
                $request->validate([
                    'title' => 'required|string|max:255',
                    'slug' => 'required|string|max:255',
                    'url' => 'nullable|string|max:255',
                    'order' => 'required|integer',
                    'status' => 'required|boolean',
                ]);
    
                $menu = Menu::findOrFail($id);
                $menu->update([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'url' => $request->url,
                    'order' => $request->order,
                    'status' => $request->status,
                ]);
    
                return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
            }
    
        
    
    
    
            public function destroyMenuCategory($id)
            {
                $category = MenuCategory::findOrFail($id);
                $category->delete(); // Deleting the category
                return redirect()->route('admin.menus.index')->with('success', 'Menu Category deleted successfully.');
            }
        
            
            


        // Menus-----

        public function showMenu($id)
        {
            $category = MenuCategory::with('menus')->findOrFail($id);
            return view('admin.menus.show_menu', compact('category'));
        }


        public function createMenu()
        {
            $categories = MenuCategory::all();
            return view('admin.menus.createMenu', compact('categories'));
        }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'menu_category_id' => 'required|exists:menu_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'integer',
            'order' => 'integer',
            'status' => 'boolean',
        ]);

        Menu::create([
            'menu_category_id' => $request->menu_category_id,
            'title' => $request->title,
            'slug' => $request->slug,
            'url' => $request->url,
            'parent_id' => $request->parent_id ?? 0,
            'order' => $request->order ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu added successfully.');
    }



    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }
        
        public function update(Request $request, $id)
        {
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'url' => 'nullable|string|max:255',
                'order' => 'required|integer',
                'status' => 'required|boolean',
            ]);

            $menu = Menu::findOrFail($id);
            $menu->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'url' => $request->url,
                'order' => $request->order,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
        }

    



        public function destroy($id)
        {
            $category = MenuCategory::findOrFail($id);
            $category->delete(); // Deleting the category
            return redirect()->route('admin.menus.index')->with('success', 'Menu Category deleted successfully.');
        }
        

}
