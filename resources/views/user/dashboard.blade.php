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

                    @foreach ($posts as $post)
    <div class="post">
        @if ($post->image)
            <img src="{{ asset('/' . $post->image) }}" class="d-block w-50" alt="Post Image">
        @else
            <img src="{{ asset('posts/default_image.jpg') }}" class="d-block w-50" alt="Default Image">
        @endif
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->content }}</p>
        <div class="post-actions">
            <form action="{{ route('post.like', $post->id) }}" method="POST" class="like-form" id="like-form-{{ $post->id }}">
                @csrf
                <button type="submit" class="like-btn" data-post-id="{{ $post->id }}">
                    👍 <span class="like-count">{{ $post->likes }}</span> Like
                </button>
            </form>
            <span class="comment">💬 Comment</span>
        </div>
    </div>
@endforeach





                    <!-- Add more posts dynamically -->
                </div>
            </div>
        </section>
    </main>

    <script>
$(document).ready(function() {
    // When the like button is clicked
    $('body').on('submit', '.like-form', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        let form = $(this);
        let postId = form.find('.like-btn').data('post-id');
        let likeCountElement = form.find('.like-count');

        $.ajax({
            url: form.attr('action'),  // The URL from the form action (route to like)
            type: 'POST',
            data: form.serialize(),    // Send the form data (with CSRF token)
            success: function(response) {
                if (response.success) {
                    // Update the like count dynamically
                    likeCountElement.text(response.likes);
                }
            },
            error: function() {
                alert('Error liking the post');
            }
        });
    });
});


    </script>
@endsection
