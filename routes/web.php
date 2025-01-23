<?php

use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'account'], function () {


    Route::group(['middleware' => 'guest'], function () {

        Route::get('login', [LoginController::class, 'index'])->name('account.login');
        Route::get('register', [LoginController::class, 'register'])->name('account.register');
        Route::post('process-Register', [LoginController::class, 'processRegister'])->name('account.processRegister');
        Route::post('authenticate', [LoginController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function () {

        Route::get('logout', [LoginController::class, 'logout'])->name('account.logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
    });


});

Route::group(['prefix' => 'admin'], function () {


    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');

        
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
        Route::get('settings', [AdminDashboardController::class, 'settings'])->name('admin.settings');
        Route::get('profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
        Route::post('saveSettings', [AdminDashboardController::class, 'saveSettings'])->name('admin.settings.save');
        Route::delete('deleteLogo', [AdminDashboardController::class, 'deleteLogo'])->name('admin.settings.deleteLogo');
        Route::post('updateLogo', [AdminDashboardController::class, 'updateLogo'])->name('admin.settings.updateLogo');

        
    });


});
