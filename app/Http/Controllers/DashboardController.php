<?php

namespace App\Http\Controllers;
use App\Models\WebsiteSetting;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $websiteSetting = WebsiteSetting::first();
        return view('user.dashboard', compact('websiteSetting'));
    }
}
