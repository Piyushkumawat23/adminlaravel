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
        // Database se page fetch karo
        $page = Page::where('slug', $slug)->firstOrFail();
    
        // View par page data bhejo
        return view('user.post', compact('page'));
    }
    




    
    
    
    
}
