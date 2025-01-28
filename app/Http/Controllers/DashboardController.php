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

    
    // public function showPage()
    // {
    //     $websiteSetting = WebsiteSetting::first(); 
    //     $page = Page::first(); 

    //     return view('user.post', compact('websiteSetting', 'page'));
    // }

    public function showPage($slug)
{
    $websiteSetting = WebsiteSetting::first(); // Fetch website settings
    $page = Page::where('slug', $slug)->first(); // Fetch the page based on the slug

    if (!$page) {
        // If the page is not found, return a 404 response or redirect to another page
        abort(404, 'Page not found.');
    }

    return view('user.post', compact('websiteSetting', 'page'));
}



    




    
    
    
    
}
