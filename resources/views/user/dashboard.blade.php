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
                
                    @foreach($posts as $post)
                        <div class="post">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image">
                            @else
                                <img src="default_image.jpg" alt="Default Image">
                            @endif
                            <h3>{{ $post->title }}</h3>
                            <p>{{ $post->content }}</p>
                            <div class="post-actions">
                                <span class="like">👍 Like</span>
                                <span class="comment">💬 Comment</span>
                            </div>
                        </div>
                    @endforeach
                
                
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
