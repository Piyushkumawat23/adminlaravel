<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;  // Import the WebsiteSetting model
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $websiteSetting = WebsiteSetting::first();
        view()->share('websiteSetting', $websiteSetting);
    }

    // Display the dashboard
    public function index()
    {
       
        return view('admin.dashboard');
    }

    // Display the website settings page
    public function settings()
    {
        // Retrieve the existing website settings or create a new record
        $settings = WebsiteSetting::first();
        return view('admin.settings', compact('settings'));
    }

    // Handle saving or updating the website settings
    public function saveSettings(Request $request)
{
    $request->validate([
        'siteName' => 'required|string|max:255',
        'siteURL' => 'required|url|max:255',
        'contactEmail' => 'required|email|max:255',
        'supportEmail' => 'nullable|email|max:255',
        'phoneNumber' => 'nullable|string|max:50',
        'address' => 'nullable|string',
        'footerText' => 'nullable|string',
        'siteLogo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validation for image
    ]);

    $data = [
        'site_name' => $request->siteName,
        'site_url' => $request->siteURL,
        'contact_email' => $request->contactEmail,
        'support_email' => $request->supportEmail,
        'phone_number' => $request->phoneNumber,
        'address' => $request->address,
        'footer_text' => $request->footerText,
    ];

    // Handle logo upload
    if ($request->hasFile('siteLogo')) {
        // Save the logo in the public/logos folder
        $logo = $request->file('siteLogo');
        $logoName = time() . '_' . $logo->getClientOriginalName();
        $logo->move(public_path('logos'), $logoName);

        // Save the logo path in the database
        $data['site_logo'] = 'logos/' . $logoName;
    }

    WebsiteSetting::updateOrCreate(['id' => 1], $data);

    return redirect()->route('admin.settings')->with('success', 'Settings saved successfully.');
}

public function updateLogo(Request $request)
{
    $request->validate([
        'siteLogo' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Validate image
    ]);

    try {
        $settings = WebsiteSetting::first();

        if (!$settings) {
            return redirect()->back()->with('error', 'Settings not found.');
        }

        // Upload new logo
        $logo = $request->file('siteLogo');
        $logoName = time() . '_' . $logo->getClientOriginalName();
        $logoPath = 'logos/' . $logoName;
        $logo->move(public_path('logos'), $logoName);

        // Delete the old logo if exists
        if ($settings->site_logo) {
            $oldLogoPath = public_path($settings->site_logo);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }

        // Update settings with new logo path
        $settings->update(['site_logo' => $logoPath]);

        return redirect()->back()->with('success', 'Logo updated successfully.');
    } catch (\Exception $e) {
        \Log::error('Error updating logo: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while updating the logo.');
    }
}

 // Handle deleting the website logo
 public function deleteLogo(Request $request)
{
    try {
        // Retrieve the settings
        $settings = WebsiteSetting::first();

        if ($settings && $settings->site_logo) {
            // Delete the logo file from the storage
            $logoPath = public_path($settings->site_logo);
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }

            // Remove the logo path from the database
            $settings->update(['site_logo' => null]);

            return redirect()->back()->with('success', 'Logo deleted successfully.');
        }

        return redirect()->back()->with('error', 'No logo found to delete.');
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error deleting logo: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the logo.');
    }
}

// public function deleteLogo(Request $request)
// {
//     $settings = WebsiteSetting::first();

//     if ($settings->site_logo && file_exists(public_path($settings->site_logo))) {
//         unlink(public_path($settings->site_logo)); // Delete logo file
//     }

//     // Remove logo path from the database
//     $settings->update(['site_logo' => null]);

//     return redirect()->route('admin.settings')->with('success', 'Logo deleted successfully.');
// }

    // Display the profile page
    public function profile()
    {
        $websiteSetting = WebsiteSetting::first();
        return view('admin.profile',compact('websiteSetting') );
    }
}


