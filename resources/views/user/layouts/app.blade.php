<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</title>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/user_style.css') }}">
</head>
<body class="bg-light">
    <header class="header">
        <div class="logo">
           
            {{-- <img src="{{ asset('images/logo.png') }} " alt="Profile"> --}}
            @if (isset($websiteSetting->site_logo) && $websiteSetting->site_logo)
            <img src="{{ asset($websiteSetting->site_logo) }}" alt="Site Logo" class="img-thumbnail"
              width="60px"  >
        @else
            <p>No site logo uploaded.</p>
        @endif
            <span>{{ $websiteSetting->site_name ?? 'Laravel 11 Multi Auth' }}</span>
        </div>
        <nav class="navbar">
            <ul>
                @if($navPages->isEmpty())
                    <li>No pages available</li>
                @else
                    @foreach ($navPages as $page)
                        <li><a href="{{ url('account/' . $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                @endif
            </ul>
        </nav>
        
        <div class="profile">
            <img src="{{ asset('images/profile.jpg') }}" alt="Profile">
            <ul class="navbar-nav justify-content-end flex-grow-1">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#!" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Hello, {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu border-0 shadow bsb-zoomIn" aria-labelledby="accountDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('account.logout') }}">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <button class="theme-toggle" id="themeToggle">🌙</button>
        </div>
    </header>

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
                <p>Subscribe to our newsletter:</p>
                <input type="email" placeholder="Enter your email">
                <button>Subscribe</button>
            </div>
        </div>
    </footer>

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


        document.querySelectorAll('.like').forEach(button => {
            button.addEventListener('click', () => {
                alert('You liked this post!');
            });
        });

        document.querySelectorAll('.comment').forEach(button => {
            button.addEventListener('click', () => {
                alert('Comment functionality coming soon!');
            });
        });
    </script>
</body>
</html>
