<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;  // Import the WebsiteSetting model
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;
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


    WebsiteSetting::updateOrCreate(['id' => 1], $data);

    return redirect()->route('admin.settings')->with('success', 'Settings saved successfully.');
}


public function updateLogo(Request $request)
{
    $request->validate([
        'siteLogo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $settings = WebsiteSetting::first();

    if (!$settings) {
        return redirect()->back()->with('error', 'Settings not found.');
    }

    // Log request data for debugging
    \Log::info('Logo Upload Request:', $request->all());

    try {
        // Upload logo
        $logo = $request->file('siteLogo');
        $logoName = time() . '_' . $logo->getClientOriginalName();
        $logoPath = 'logos/' . $logoName;
        $logo->move(public_path('logos'), $logoName);

        // Delete old logo
        if ($settings->site_logo) {
            $oldLogoPath = public_path($settings->site_logo);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }

        // Save new logo path
        $settings->site_logo = $logoPath;
        $settings->save();

        return redirect()->back()->with('success', 'Logo updated successfully.');
    } catch (\Exception $e) {
        \Log::error('Error updating logo: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update logo.');
    }
}


 // Handle deleting the website logo
 public function deleteLogo()
 {
     $settings = WebsiteSetting::first();
 
     if ($settings && $settings->site_logo) {
         $logoPath = public_path($settings->site_logo);
         if (file_exists($logoPath)) {
             unlink($logoPath); // Delete the file
         }
 
         $settings->update(['site_logo' => null]); // Remove logo path from the database
     }
 
     return redirect()->route('admin.settings')->with('success', 'Logo deleted successfully.');
 }


    // Display the profile page
    // public function profile()
    // {
    //     $websiteSetting = WebsiteSetting::first();
    //     return view('admin.profile',compact('websiteSetting') );
    // }

    public function profile()
    {
        $admin = Auth::guard('admin')->user(); // Fetch the currently authenticated admin user
        return view('admin.profile', compact('admin'));
    }


    /**
 * Handle updating the admin profile.
 */


 public function updateProfileDetails(Request $request)
{
    $admin = Auth::guard('admin')->user(); // Fetch the currently authenticated admin user

    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $admin->id, // Ensure unique email, but allow the current user's email
    ]);

    // Update the admin user information
    $admin->name = $request->name;
    $admin->email = $request->email;

    // Save the updated profile data
    $admin->save();

    // Redirect back to the profile page with success message
    return redirect()->route('admin.profile')->with('success', 'Profile details updated successfully.');
}


public function updateProfilePhoto(Request $request)
{
    $admin = Auth::guard('admin')->user(); // Fetch the currently authenticated admin user

    // Validate the incoming request
    $request->validate([
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // If a new profile photo is uploaded, handle the upload
    if ($request->hasFile('profile_photo')) {
        // Store the new profile photo
        $photo = $request->file('profile_photo');
        $photoName = time() . '_' . $photo->getClientOriginalName();
        $photoPath = 'profile_photos/' . $photoName;
        $photo->move(public_path('profile_photos'), $photoName);

        // If the admin already has a profile photo, delete the old one
        if ($admin->profile_photo) {
            $oldPhotoPath = public_path($admin->profile_photo);
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        // Save the new profile photo path
        $admin->profile_photo = $photoPath;
    }

    // Save the updated profile data
    $admin->save();

    // Redirect back to the profile page with success message
    return redirect()->route('admin.profile')->with('success', 'Profile photo updated successfully.');
}




public function deleteAvatar()
{
    $admin = Auth::guard('admin')->user();

    if ($admin && $admin->profile_photo) {
        $photoPath = public_path($admin->profile_photo);
        if (file_exists($photoPath)) {
            unlink($photoPath); // Delete the file
        }

        // Remove the profile photo path from the database
        $admin->update(['profile_photo' => null]);
    }

    return redirect()->route('admin.profile')->with('success', 'Profile photo deleted successfully.');
}

 

}


