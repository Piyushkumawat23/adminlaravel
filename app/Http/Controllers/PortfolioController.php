<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Post;
use App\Models\MenuCategory;
use App\Models\Menu;
use App\Models\User;
use App\Models\PostLike;
use App\Models\BlogLike;
use App\Models\PostComment;
use App\Models\BlogComment;
use App\Models\Slider;
use App\Models\SliderSetting;

class PortfolioController extends Controller
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

    public function index()
    {
        $this->shareNavPages(); 
        $websiteSetting = WebsiteSetting::first(); // Fetch website settings
        $settings = SliderSetting::first();
        $menuCategories = MenuCategory::with(['menus' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();
        return view('web2.portfolio.index', compact('menuCategories','websiteSetting','settings'));
    }

    public function about()
    {
        return view('user.portfolio.about');
    }

    public function projects()
    {
        return view('user.portfolio.projects');
    }

    public function contact()
    {
        return view('user.portfolio.contact');
    }
}
