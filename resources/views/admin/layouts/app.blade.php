<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Dashboard Panel' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

</head>
<body>
    <nav>
        
        <div class="logo-name">
            <div class="logo-image">
                <a href="">
                    <img src="{{ asset('images/logo.png') }} " alt="Profile">
                </a>
            </div>
       
            <div class="logo-name">
                <a href="">
                    <span>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</span>
                </a>
            </div>
        </div>
        <div class="logo-name">
            <span class="logo_name">Hello, {{ Auth::guard('admin')->user()->name }}</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Analytics</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Like</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Comment</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="{{ route('admin.settings') }}">
                        <i class="uil uil-setting"></i>
                        <span class="link-name">Settings</span>
                </a></li>
                <li><a href="{{ route('admin.logout') }}">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
    
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
           <a href="{{ route('admin.profile') }}">
               <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
            </a> 
    
        </div>
        <div class="container">
            @yield('content')
        </div>
    </section>
</body>
<script src="{{ asset('assets/js/admin_script.js') }}"></script>
</html>
