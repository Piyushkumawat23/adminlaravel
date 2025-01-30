<?php

use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Models\Page;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\Admin\UserController;




// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    if (auth()->check()) {
        // User is authenticated, redirect to the dashboard
        return redirect()->route('account.dashboard');
    }
    // User is not authenticated, redirect to the login page
    return redirect()->route('account.login');
});
Route::get('/account/', function () {
    if (auth()->check()) {
        // User is authenticated, redirect to the dashboard
        return redirect()->route('account.dashboard');
    }
    // User is not authenticated, redirect to the login page
    return redirect()->route('account.login');
});




Route::group(['prefix' => 'account'], function () {


    Route::group(['middleware' => 'guest'], function () {

        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-Register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
            // Forgot Password Form
        Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
        // Send Reset Link
        Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
        // Reset Password Form
        Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
        // Handle Reset Password
        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
    
    });
    Route::group(['middleware' => 'auth'], function () {

        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');

     
        
       // Dynamic slug route
       Route::get('{slug}', [DashboardController::class, 'showPage'])->name('account.page');


    });

});

Route::group(['prefix' => 'admin'], function () {


    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');

        
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
        Route::get('profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
        
        Route::post('profile/updateProfile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.updateProfile');
        
        Route::delete('profile/deleteAvatar', [AdminDashboardController::class, 'deleteAvatar'])->name('admin.profile.deleteAvatar');



        Route::post('saveSettingsAndLogo', [AdminDashboardController::class, 'saveSettingsAndLogo'])->name('admin.settings.save');
        Route::delete('deleteLogo', [AdminDashboardController::class, 'deleteLogo'])->name('admin.settings.deleteLogo');
        
        

        
        Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
        Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{id}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

        Route::get('/smtp-settings', [AdminDashboardController::class, 'smtpSettings'])->name('admin.smtp');
        Route::post('/smtp-update-settings', [AdminDashboardController::class, 'updateSmtpSettings'])->name('admin.smtp.update');
        Route::post('/smtp/test', [AdminDashboardController::class, 'testSmtp'])->name('admin.smtp.test');

        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');


    });


});
