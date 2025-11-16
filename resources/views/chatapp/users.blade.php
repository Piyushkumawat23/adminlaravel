@extends('chatapp.layouts.app')

@section('content')
    <main class="main-content">
        <div class="wrapper" style="max-width: 450px; margin: 40px auto;">
            <section class="users">
                <header>
                    <div class="content">
                        @if(isset($user))
                            {{-- 💡 FIX: Maine image path ko 'Images' se 'images' kar diya hai --}}
                            <img src="{{ asset('images/chatapp_profiles/' . $user->img) }}" alt="Profile Pic">
                            <div class="details">
                                <span>{{ $user->fname . " " . $user->lname }}</span>
                                <p>{{ $user->status }}</p>
                            </div>
                        @else
                            <p>User not found.</p>
                        @endif
                    </div>
                    {{-- Aapke layout mein pehle se logout hai, aap yahaan bhi daal sakte hain --}}
                    <a href="{{ route('chatapp.logout') }}" class="logout">Logout</a>
                </header>
                <div class="search">
                    <span class="text">Select an user to start chat</span>
                    <input type="text" placeholder="Enter name to search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    {{-- Yeh div ab niche diye gaye script se load hoga --}}
                </div>
            </section>
        </div>
    </main>

    {{-- 💡 IMPORTANT: Humne 'users.js' file ki jagah script ko yahaan daal diya hai --}}
    <script>
        const searchBar = document.querySelector(".search input"),
        searchIcon = document.querySelector(".search button"),
        usersList = document.querySelector(".users-list");
        
        // CSRF Token ko meta tag se lein (yeh aapke app.blade.php mein hona chahiye)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        searchIcon.onclick = () => {
            searchBar.classList.toggle("show");
            searchIcon.classList.toggle("active");
            searchBar.focus();
            if (searchBar.classList.contains("active")) {
                searchBar.value = "";
                searchBar.classList.remove("active");
            }
        }

        searchBar.onkeyup = () => {
            let searchTerm = searchBar.value;
            if (searchTerm != "") {
                searchBar.classList.add("active");
            } else {
                searchBar.classList.remove("active");
            }
            
            let xhr = new XMLHttpRequest();
            // 1. URL ko naye Laravel route se badlein
            xhr.open("POST", "{{ route('chatapp.users.search') }}", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        usersList.innerHTML = data;
                    }
                }
            }
            // 2. CSRF Token ko header mein bhejein
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            // 3. Form data ki tarah bhejein
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("searchTerm=" + searchTerm);
        }

        // Users list ko har 500ms mein refresh karein
        setInterval(() => {
            let xhr = new XMLHttpRequest();
            // 4. URL ko naye Laravel route se badlein
            xhr.open("GET", "{{ route('chatapp.users.get') }}", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        if (!searchBar.classList.contains("active")) { // Agar user search nahi kar raha hai
                            usersList.innerHTML = data;
                        }
                    }
                }
            }
            xhr.send();
        }, 500); // 500ms
    </script>
@endsection