<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Dashboard Panel' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/admin_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <style>
        .cke_notification {
            display: none !important;
        }

        .dark .form-group .cke_inner {
            background-color: #2c2c2c !important;
            /* Dark background for editor */
            color: #e0e0e0;
            /* Light text */
        }

        .dark .cke_inner {
            background-color: #2c2c2c !important;
            /* Dark background for editor */
            color: #e0e0e0;
            /* Light text */
        }

        .dark .cke_inner textarea,
        .dark .cke_inner input {
            background-color: #2c2c2c !important;
            /* Dark background for inputs */
            color: #e0e0e0;
            /* Light text for inputs */
            border-color: #444;
            /* Darker borders */
        }
    </style>
</head>

<body>
    <nav>

        <div class="logo-name">
            <div class="logo-image">
                <a href="">
                    {{-- <img src="{{ asset('images/logo.png') }} " alt="Profile"> --}}
                    @if (isset($websiteSetting->site_logo) && $websiteSetting->site_logo)
                        <img src="{{ asset($websiteSetting->site_logo) }}" alt="Site Logo" class="img-thumbnail"
                            width="20">
                    @else
                        <p>No site logo uploaded.</p>
                    @endif
                </a>
            </div>
        </div>
        <div class="logo-name">
            <a target="_blank" href="{{ $websiteSetting->site_url ?? 'Laravel 11 Multi Auth' }}">
                <span>{{ $websiteSetting->site_name ?? 'WEBSIT' }}</span>
            </a>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="{{ route('admin.dashboard') }}">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
                    </a></li>
                {{-- <li><a href="#">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Content</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>--}}
                <li><a href="{{ route('admin.users.index')}}">
                        <i class="uil uil-user"></i>
                        <span class="link-name">users</span>
                    </a></li>
                <li><a href="{{ route('admin.smtp') }}">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">SMTP</span>
                    </a></li> 
                <li><a href="{{ route('pages.index') }}">
                        <i class="uil uil-tachometer-fast-alt"></i>
                        <span class="link-name">pages</span>
                    </a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="{{ route('admin.settings') }}">
                        <i class="uil uil-setting"></i>
                        <span class="link-name">Settings</span>
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
                <li><a href="{{ route('admin.logout') }}">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>


            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">

           
            
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                <div class="d-flex justify-content-around align-items-center align-items-stretch ml-3  ">
                    <div class="aiz-topbar-item">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-soft-success btn-sm d-flex align-items-center" target="_blank"
                                href="{{ $websiteSetting->site_url ?? 'Laravel 11 Multi Auth' }}">
                                <i class="las la-hdd fs-20"></i>
                                <span class="fw-500 ml-1 mr-0 d-none d-md-block">Browse Website</span>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- <div class="d-flex justify-content-around align-items-left align-items-stretch ml-3  ">
                    <div class="aiz-topbar-item">
                        <div class="d-flex align-items-center" title="Clear Cache">
                            <a class="btn btn-icon btn-soft-danger btn-circle btn-light" href="https://bautlr.com/admin/clear-cache">
                                <i class="las la-hdd fs-20"></i>
                            </a>
                        </div>
                    </div>
                </div> --}}


               
            </div>
            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>

            <div class="logo-name">
                <span class="logo_name">Hello, {{ Auth::guard('admin')->user()->name }}</span>
            </div>
            <div>
                <a href="{{ route('admin.profile') }}" class="profile-container">
                    @if (Auth::guard('admin')->user()->profile_photo)
                        <div class="profile-wrapper">
                            <img src="{{ asset(Auth::guard('admin')->user()->profile_photo) }}" alt="Profile Photo"
                                class="img-thumbnail mb-2" width="100">
                            <div class="hover-overlay">
                                Edit
                            </div>
                        </div>
                    @else
                        <p>profile edit...</p>
                    @endif
                </a>
            </div>


            
           
        </div>
        <div class="container">
            @yield('content')
        </div>
    </section>

    
</body>
<script src="{{ asset('assets/js/admin_script.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content', {
        removePlugins: 'notification',
    });
</script>

</html>
