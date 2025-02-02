<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderSetting;

class SliderSettingController extends Controller
{
    public function index()
    {
        $settings = SliderSetting::first(); // स्लाइडर सेटिंग्स को लोड करें
        return view('admin.slider.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'autoplay' => 'required|boolean',
            'speed' => 'required|integer|min:100',
            'loop' => 'required|boolean',
        ]);

        $settings = SliderSetting::first();
        if (!$settings) {
            $settings = new SliderSetting();
        }

        $settings->autoplay = $request->autoplay;
        $settings->speed = $request->speed;
        $settings->loop = $request->loop;
        $settings->save();

        return redirect()->route('admin.slider.settings')->with('success', 'Slider settings updated successfully.');
    }
}
