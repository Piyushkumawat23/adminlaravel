<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</title>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/user_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/css-cce8d2e1b33b9fe6.css') }}" >
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    



    <style>
        #slider {
            height: 570px;
            /* Set the desired height for the carousel */
            overflow: hidden;
            /* Hide any overflow from images */
        }

        #slider .carousel-inner {
            height: 100%;
            /* Ensure the inner container matches the outer container height */
        }

        #slider .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
            /* Scale the image to cover the container without distortion */
        }
    </style>


    <meta name="next-head-count" content="3">
    <link href="https://fonts.bunny.net/css?family=noto-sans:400,500,700,800" rel="stylesheet">
    <link rel="preload" href="/_next/static/css/cce8d2e1b33b9fe6.css" as="style">
    <link rel="stylesheet" href="css/css-cce8d2e1b33b9fe6.css" data-n-g=""><noscript data-n-css=""></noscript>
    <script defer nomodule="" src="js/chunks-polyfills-c67a75d1b6f99dc8.js"></script>
    <script src="js/chunks-webpack-59c5c889f52620d6.js" defer></script>
    <script src="js/chunks-framework-3b5a00d5d7e8d93b.js" defer></script>
    <script src="js/chunks-main-b482fffd82fa7e1c.js" defer></script>
    <script src="js/pages-_app-d62242ea68854d10.js" defer></script>
    <script src="js/chunks-664-860d4fb5fc32e7d0.js" defer></script>
    <script src="js/chunks-717-5890caa929a07934.js" defer></script>
    <script src="js/chunks-459-411cfee40d0d723d.js" defer></script>
    <script src="js/chunks-794-a2e99bbe22b785a3.js" defer></script>
    <script src="js/chunks-83-9473c413a19f4cb9.js" defer></script>
    <script src="js/pages-index-db79887f9e0a976b.js" defer></script>
    <script src="js/170HKlN7eVGQQICJ9nAxb-_buildManifest.js" defer></script>
    <script src="js/170HKlN7eVGQQICJ9nAxb-_ssgManifest.js" defer></script>
</head>

<body class="bg-light">
    <header class="header">
        <div class="logo">

            {{-- <img src="{{ asset('images/logo.png') }} " alt="Profile"> --}}
            @if (isset($websiteSetting->site_logo) && $websiteSetting->site_logo)
                <img src="{{ asset($websiteSetting->site_logo) }}" alt="Site Logo" class="img-thumbnail" width="60px">
            @else
                <p>No site logo uploaded.</p>
            @endif
            <span>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</span>
        </div>

        <nav class="navbar">
            <ul>
                @if (isset($navPages) && $navPages->isNotEmpty())
                    @foreach ($navPages as $page)
                        <li><a href="{{ url('account/' . $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                @else
                    <li>No pages available</li>
                @endif
            </ul>
        </nav>




        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
            <ul class="navbar-nav justify-content-end flex-grow-1">
                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hello, {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('account.logout') }}">Logout</a>
                            </li>
                        </ul>
                    @endauth
        
                    @guest
                        <a href="{{ route('account.register') }}" class="btn btn-primary">Signup</a>
                        <a href="{{ route('account.login') }}" class="btn btn-primary">Login</a>
                    @endguest
                </li>
            </ul>
            <button class="theme-toggle" id="themeToggle">🌙</button>
        </div>
        
    </header>

    {{-- slider code   --}}

    
@if(isset($sliders) && $sliders->count() > 0)
<div id="slider" 
    class="carousel slide" 
    data-bs-ride="{{ optional($settings)->autoplay ? 'carousel' : 'false' }}" 
    data-bs-interval="{{ optional($settings)->autoplay ? optional($settings)->speed : 'false' }}" 
    data-bs-wrap="{{ optional($settings)->loop ? 'true' : 'false' }}"
>
    <div class="carousel-inner">
        @foreach ($sliders as $key => $slider)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('/' . $slider->image) }}" class="d-block w-100" alt="Slider Image">
                <div class="carousel-caption">
                    <h5>{{ $slider->title }}</h5>
                    <p>{{ $slider->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#slider" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#slider" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
@endif


    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <div>
                <p>&copy; 2025 Community Hub. All rights reserved.</p>
            </div>
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
            <div class="newsletter">
                
                <form action="{{ route('newsletter.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <p>Subscribe to our newsletter:</p>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </footer>



    @if(session('refresh_page'))
    <script>
        setTimeout(function() {
            location.reload();
        }, 1000); // 1-second delay before refresh
    </script>
@endif




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const themeToggle = document.getElementById('themeToggle');

        // Check for saved theme preference
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            themeToggle.textContent = '☀️';
        }

        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            themeToggle.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';

            // Save theme preference
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        });



        document.querySelectorAll('.comment').forEach(button => {
            button.addEventListener('click', () => {
                alert('Comment functionality coming soon!');
            });
        });





        
    </script>
</body>

</html>
