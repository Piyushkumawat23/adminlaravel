<?php

namespace App\Http\Controllers;
use App\Models\WebsiteSetting;
use App\Models\Page;
use App\Models\MenuCategory;
use App\Models\Slider;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Share published pages across all views
        $this->shareNavPages();
    }

   
    private function shareNavPages()
    {
        $navPages = Page::where('status', 'active')->get();
        // print_r($navPages);
        view()->share('navPages', $navPages);
    }

    public function index(){
        $websiteSetting = WebsiteSetting::first();
        $sliders = Slider::where('status', 1)->get();
        return view('user.dashboard', compact('websiteSetting','sliders'));
    }


    public function showPage($slug)
    {
        $websiteSetting = WebsiteSetting::first(); // Fetch website settings
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
    
        return view($viewName, compact('websiteSetting', 'page'));
    }
    



    public function showActiveMenus()
{
    $websiteSetting = WebsiteSetting::first(); // Fetch website settings

    $menuCategories = MenuCategory::with(['menus' => function ($query) {
        $query->where('status', 1);
    }])->where('status', 1)->get();

    return view('user.menus', compact('menuCategories','websiteSetting'));
}

    

    
}
