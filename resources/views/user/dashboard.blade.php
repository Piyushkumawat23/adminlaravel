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
                                <form action="{{ route('post.like', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="like">👍{{ $post->likes }} Like</button>
                                    {{-- <span>{{ $post->likes }} Likes</span>  --}}
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
@endsection
