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
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SliderSettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\NewsletterController;




// Route::get('/', function () {
//     return view('user.dashboard');
// });

Route::get('/', [DashboardController::class, 'index'])->name('account.dashboard');


// Route::get('/', function () {
//     if (auth()->check()) {
//         return redirect()->route('account.dashboard');
//     }
//     return redirect()->route('account.login');
// });
// Route::get('/account/', function () {
//     if (auth()->check()) {
//         return redirect()->route('account.dashboard');
//     }
//     return redirect()->route('account.login');
// });




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


        Route::get('menus', [DashboardController::class, 'showActiveMenus'])->name('account.showActiveMenus');
        Route::get('slider', [DashboardController::class, 'showActiveSlider'])->name('account.showActiveSlider');

        Route::post('post/{id}/like', [DashboardController::class, 'likePost'])->name('post.like');
        Route::post('/posts/{id}/comment', [DashboardController::class, 'commentPost'])->name('posts.comment');

        Route::post('blogs/{id}/like', [DashboardController::class, 'likeblog'])->name('blogs.like');
        Route::post('/blogs/{id}/comment', [DashboardController::class, 'commentblog'])->name('blogs.comment');
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

        // View a user's
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');

        // View a user's details
        Route::get('users/{id}', [UserController::class, 'show'])->name('admin.users.show');

        // Edit a user's details
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');

        // Delete a user
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');




        // Menu  Categories Routes 
        Route::get('menus/Category/create', [MenuController::class, 'createMenuCategory'])->name('admin.menus.createMenuCategory');
        // In web.php
        Route::post('menus/storeMenuCategory', [MenuController::class, 'storeMenuCategory'])->name('admin.menus.storeMenuCategory');
        Route::get('/menus/edit-category/{id}', [MenuController::class, 'editMenuCategory'])->name('admin.menus.editCategory');
        Route::put('/menus/update-category/{id}', [MenuController::class, 'updateMenuCategory'])->name('admin.menus.updateCategory');

        Route::delete('menus/category/{id}', [MenuController::class, 'destroyMenuCategory'])->name('admin.menus.category.destroy');

        Route::post('/menus/update-status/{id}', [MenuController::class, 'updateStatus'])->name('admin.menus.updateStatus');




        // Menu  Routes      
        Route::get('menus', [MenuController::class, 'index'])->name('admin.menus.index');
        Route::get('menus/create', [MenuController::class, 'createMenu'])->name('admin.menus.createMenu');
        Route::post('menus/store', [MenuController::class, 'storeMenu'])->name('admin.menus.storeMenu');
        Route::get('menus/{id}/edit', [MenuController::class, 'edit'])->name('admin.menus.edit');
        Route::put('menus/{id}', [MenuController::class, 'update'])->name('admin.menus.update'); // 
        Route::delete('menus/{id}', [MenuController::class, 'destroy'])->name('admin.menus.destroy');

        Route::get('menus/{id}', [MenuController::class, 'showMenu'])->name('admin.menus.show');



        //Slider Routes
        Route::get('/sliders', [SliderController::class, 'index'])->name('admin.sliders.index');
        Route::get('/sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create');
        Route::post('/sliders/store', [SliderController::class, 'store'])->name('admin.sliders.store');
        Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('admin.sliders.edit');
        Route::put('/sliders/{id}', [SliderController::class, 'update'])->name('admin.sliders.update');
        Route::delete('/sliders/{id}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');

        Route::get('/slider-settings', [SliderSettingController::class, 'index'])->name('admin.slider.settings');
        Route::post('/slider-settings/update', [SliderSettingController::class, 'update'])->name('admin.slider.settings.update');


        Route::get('/Category', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');


        // Post routes
        Route::get('posts', [PostController::class, 'index'])->name('admin.posts.index');
        Route::get('posts/create', [PostController::class, 'create'])->name('admin.posts.create');
        Route::post('posts/store', [PostController::class, 'store'])->name('admin.posts.store');
        Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('posts/{id}', [PostController::class, 'update'])->name('admin.posts.update');
        Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('admin.posts.destroy');


        // Blog routes
        Route::get('blogs', [BlogsController::class, 'index'])->name('admin.blogs.index');
        Route::get('blogs/create', [BlogsController::class, 'create'])->name('admin.blogs.create');
        Route::post('blogs', [BlogsController::class, 'store'])->name('admin.blogs.store');
        Route::get('blogs/{id}/edit', [BlogsController::class, 'edit'])->name('admin.blogs.edit');
        Route::put('blogs/{id}', [BlogsController::class, 'update'])->name('admin.blogs.update');
        Route::delete('blogs/{id}', [BlogsController::class, 'destroy'])->name('admin.blogs.destroy');
        Route::post('blogs/{id}/status', [BlogsController::class, 'updateStatus'])->name('admin.blogs.status');



        Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletter.index');
        Route::post('/newsletters/store', [NewsletterController::class, 'store'])->name('newsletter.store');
        Route::get('/newsletters/unsubscribe/{id}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
        Route::get('/admin/newsletter/{id}/edit', [NewsletterController::class, 'edit'])->name('newsletter.edit');
        Route::post('/admin/newsletter/{id}/update', [NewsletterController::class, 'update'])->name('newsletter.update');

        Route::get('/newsletters/delete/{id}', [NewsletterController::class, 'destroy'])->name('newsletter.delete');
        Route::get('/newsletters-show', [NewsletterController::class, 'showindex'])->name('newsletter.show');
        Route::post('/send-newsletter', [NewsletterController::class, 'sendNewsletter'])->name('admin.send.newsletter');

    });
});
