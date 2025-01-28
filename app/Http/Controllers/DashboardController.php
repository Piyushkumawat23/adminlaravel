<?php

namespace App\Http\Controllers;
use App\Models\WebsiteSetting;
use App\Models\Page;
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
       
        return view('user.dashboard', compact('websiteSetting'));
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
    



    




    
    
    
    
}
