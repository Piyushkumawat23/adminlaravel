@extends('chatapp.layouts.app')

@section('content')
    {{-- <div class="banner">
        Welcome to the Community Hub
    </div> --}}

    <main class="main-content">
        <div class="wrapper" style="max-width: 450px; margin: 40px auto;"> {{-- Style ko CSS file mein move karein --}}
            <a href="{{ route('chatapp.register') }}">register</a>
            
            
            <section class="users">
                <header>
                    <div class="content">
                        {{-- Controller se $user variable aayega --}}
                        @if(isset($user))
                            <img src="{{ asset('images/' . $user->img) }}" alt="Profile Pic">
                            <div class="details">
                                <span>{{ $user->fname . " " . $user->lname }}</span>
                                <p>{{ $user->status }}</p>
                            </div>
                        @else
                            <p>User not found.</p>
                        @endif
                    </div>
                    {{-- Logout link aapke layout mein pehle se hai, isliye yahaan se hata diya --}}
                    {{-- <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a> --}}
                </header>
                <div class="search">
                    <span class="text">Select an user to start chat</span>
                    <input type="text" placeholder="Enter name to search...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    {{-- User list yahaan AJAX se load hogi (aapke users.js ke according) --}}
                </div>
            </section>
        </div>
    </main>

    {{-- Page-specific script --}}
        <script src="{{ asset('assets/js/chatapp/users.js') }}"></script>



    <!-- JavaScript for Showing Comment Box -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".comment-toggle").forEach(button => {
                button.addEventListener("click", function() {
                    let commentBox = this.nextElementSibling;
                    if (commentBox.style.display === "none" || commentBox.style.display === "") {
                        commentBox.style.display = "block";
                    } else {
                        commentBox.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection
