@extends('user.layouts.app')

@section('content')







<div class="banner">
    Welcome to the Community Hub
</div>

<main class="main-content">
    <section id="posts" class="posts">
        <div class="container">
            <h2>Community Posts</h2>
            <div class="post-list">
                <div class="post">
                    <img src="post1.jpg" alt="Post Image">
                    <h3>Post Title 1</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur euismod.</p>
                    <div class="post-actions">
                        <span class="like">👍 Like</span>
                        <span class="comment">💬 Comment</span>
                        
                    </div>
                </div>
                <div class="post">
                    <img src="post2.jpg" alt="Post Image">
                    <h3>Post Title 2</h3>
                    <p>Vivamus ac ligula euismod, laoreet nunc in, tincidunt eros.</p>
                    <div class="post-actions">
                        <span class="like">👍 Like</span>
                        <span class="comment">💬 Comment</span>
                    </div>
                </div>
                <!-- Add more posts dynamically -->
            </div>
        </div>
    </section>
</main>
@endsection
