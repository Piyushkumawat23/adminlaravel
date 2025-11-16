<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Realtime Chat App</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/user_style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chatapp/style.css') }}">




    <style>
        /* Unread Message Badge Style */
        .users-list a {
            position: relative;
            /* Badge ko position karne ke liye */
        }

        .unread-badge {
            position: absolute;
            top: 80%;
            right: 15px;
            /* Status dot ke paas */
            transform: translateY(-50%);
            background-color: #33a396;
            /* Green color */
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 50%;
            line-height: 1;
        }

        /* Status dot ko thoda side mein karein */
        .users-list a .status-dot {
            right: 35px;
            /* Badge ke liye jagah banayein */
        }
    </style>



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

        {{-- <nav class="navbar">
            <ul>
                @if (isset($navPages) && $navPages->isNotEmpty())
                    @foreach ($navPages as $page)
                        <li><a href="{{ url('account/' . $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                @else
                    <li>No pages available</li>
                @endif
            </ul>
        </nav> --}}

        <nav class="navbar">
            <ul class="menu-content">
                @foreach ($navMenus as $menu)
                    <li class="level-1 {{ $menu->children->count() > 0 ? 'parent' : '' }}">
                        <a href="{{ $menu->url ?? url('account/' . $menu->slug) }}">
                            <span>{{ $menu->title }}</span>
                        </a>

                        @if ($menu->children->count())
                            <div class="submenu">
                                <ul>
                                    @foreach ($menu->children as $child)
                                        <li><a
                                                href="{{ $child->url ?? url('account/' . $child->slug) }}">{{ $child->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
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


    {{-- @if (isset($sliders) && $sliders->count() > 0)
        <div id="slider" class="carousel slide"
            data-bs-ride="{{ optional($settings)->autoplay ? 'carousel' : 'false' }}"
            data-bs-interval="{{ optional($settings)->autoplay ? optional($settings)->speed : 'false' }}"
            data-bs-wrap="{{ optional($settings)->loop ? 'true' : 'false' }}">
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
    @endif --}}


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



    @if (session('refresh_page'))
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



        document.addEventListener("DOMContentLoaded", () => {

            // 1. CSRF Token ko ek baar meta tag se lein
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            /**
             * Yeh ek reusable function hai jo AJAX request bhejta hai.
             * Yeh form (signup ya login) aur error box ko as input leta hai.
             */
            async function handleFormSubmit(formElement, errorTextElement) {
                // Form ke data-action attribute se URL prapt karein
                const actionUrl = formElement.dataset.action;
                const formData = new FormData(formElement);

                try {
                    const response = await fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    // Server se mila response (JSON mein)
                    const data = await response.json();

                    // Agar response OK nahi hai (jaise 422, 500)
                    if (!response.ok) {
                        let errorMsg = "An unknown error occurred.";
                        if (data.errors) {
                            // Yeh 422 Validation Error hai (Register se)
                            errorMsg = Object.values(data.errors).map(e => e[0]).join('<br>');
                        } else if (data.message) {
                            // Yeh 422/500 Error hai (Login ya 500)
                            errorMsg = data.message;
                        }
                        errorTextElement.style.display = 'block';
                        errorTextElement.innerHTML = errorMsg;
                    } else {
                        // Success (200)
                        if (data.status === 'success' && data.redirect_url) {
                            // Success, naye URL par redirect karein
                            window.location.href = data.redirect_url;
                        } else {
                            errorTextElement.style.display = 'block';
                            errorTextElement.textContent = "Success, but no redirect URL provided.";
                        }
                    }
                } catch (error) {
                    // Network error ya JSON parse error (e.g., 500 HTML response)
                    console.error('Fetch Error:', error);
                    errorTextElement.style.display = 'block';
                    errorTextElement.textContent = 'A server error occurred. Please try again.';
                }
            }

            // --- Signup Form ke liye Setup ---
            const signupForm = document.querySelector(".signup form");
            if (signupForm) {
                const continueBtn = signupForm.querySelector(".button input");
                const errorText = signupForm.querySelector(".error-text");

                signupForm.onsubmit = (e) => e.preventDefault(); // Page reload na ho

                // Button click par hamara naya function call karein
                continueBtn.onclick = () => {
                    handleFormSubmit(signupForm, errorText);
                };
            }

            // --- Login Form ke liye Setup ---
            const loginForm = document.querySelector(".login form");
            if (loginForm) {
                const continueBtn = loginForm.querySelector(".button input");
                const errorText = loginForm.querySelector(".error-text");

                loginForm.onsubmit = (e) => e.preventDefault(); // Page reload na ho

                // Button click par wahi naya function call karein
                continueBtn.onclick = () => {
                    handleFormSubmit(loginForm, errorText);
                };
            }
        });
    </script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>

</body>

</html>
