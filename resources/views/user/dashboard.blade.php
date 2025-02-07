@extends('user.layouts.app')

@section('content')
    <div class="banner">
        Welcome to the Community Hub
    </div>

    <main class="main-content">
        <section id="posts" class="posts">
            <div class="container">
                <h2>Community Posts</h2>
                <div class="post-list" id="post-list">
                    @foreach ($posts as $post)
                    <div class="post" data-post-id="{{ $post->id }}">
                        @if ($post->image)
                            <img src="{{ asset('/' . $post->image) }}" class="d-block w-50" alt="Post Image">
                        @else
                            <img src="{{ asset('posts/default_image.jpg') }}" class="d-block w-50" alt="Default Image">
                        @endif
                
                        <h3>{{ $post->title }}</h3>
                        <p>{{ strip_tags($post->content) }}</p>
                
                        <!-- Like Form -->
                        <form method="POST" action="{{ route('post.like', $post->id) }}" class="like-form">
                            @csrf
                            <button type="submit" class="like-btn">
                                @php
                                    // Check if the user has already liked the post
                                    $hasLiked = $post->likes()->where('user_id', auth()->id())->exists();
                                @endphp
                        
                                @if($hasLiked)
                                    👎 Unlike
                                @else
                                    👍 Like
                                @endif
                        
                                <!-- Display total number of likes -->
                                <span class="like-count">{{ $post->likes()->count() }} Likes</span>
                            </button>
                        </form>
                        
                        
                        
                        
                
                        <!-- Show Comments -->
                        <div class="comments">
                            <span class="comment-toggle">💬 Comment</span>
                
                            <div class="comment-box" style="display: none;">
                                <!-- Comment Form -->
                                <form method="POST" action="{{ route('posts.comment', $post->id) }}" class="comment-form">
                                    @csrf
                                    <input type="text" name="comment" placeholder="Write a comment..." required>
                                    <button type="submit">Post</button>
                                </form>
                
                                @foreach ($post->comments as $comment)
                                    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                
                </div>
            </div>
            
        </section>


            <section id="blogs" class="blogs">


            <div class="container">
                <h2>Community blogs</h2>
                <div class="post-list" id="post-list">
                    @foreach ($blogs as $blog)
                    <div class="post" data-blog-id="{{ $blog->id }}">
                        @if ($blog->image)
                            <img src="{{ asset('/' . $blog->image) }}" class="d-block w-50" alt="blogs Image">
                        @else
                            <img src="{{ asset('Blogs/default_image.jpg') }}" class="d-block w-50" alt="Default Image">
                        @endif
                    
                        <h3>{{ $blog->title }}</h3>
                        <p>{{ strip_tags($blog->content) }}</p>
                    
                        <!-- Like Form -->
                        <form method="POST" action="{{ route('blogs.like', $blog->id) }}" class="like-form">
                            @csrf
                            <button type="submit" class="like-btn">
                                @php
                                    // Check if the user has already liked the blog
                                    $hasLiked = $blog->likes()->where('user_id', auth()->id())->exists();
                                @endphp
                    
                                @if($hasLiked)
                                    👎 Unlike
                                @else
                                    👍 Like
                                @endif
                    
                                <!-- Display total number of likes -->
                                <span class="like-count">{{ $blog->likes()->count() }} Likes</span>
                            </button>
                        </form>
                    
                        <!-- Show Comments -->
                        <div class="comments">
                            <span class="comment-toggle">💬 Comment</span>
                    
                            <div class="comment-box" style="display: none;">
                                <!-- Comment Form -->
                                <form method="POST" action="{{ route('blogs.comment', $blog->id) }}" class="comment-form">
                                    @csrf
                                    <input type="text" name="comment" placeholder="Write a comment..." required>
                                    <button type="submit">Post</button>
                                </form>
                    
                                @foreach ($blog->comments as $comment)
                                    <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                @endforeach
                
                </div>
            </div>
        </section>
    </main>



     <!-- JavaScript for Showing Comment Box -->
     <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".comment-toggle").forEach(button => {
                button.addEventListener("click", function () {
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
