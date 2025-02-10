@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-edit"></i>
            <span class="text">Edit News</span>
        </div>
    </div>

    @if (session('success'))
        <div class="flash-message">
            <div class="flash-message-content">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <h1>Edit News</h1>

    <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ $news->title }}" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required>{{ $news->content }}</textarea>
        </div>

        <div>
            <label>Status:</label>
            <select name="status" required>
                <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $news->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label>Current Image:</label>
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" width="150" alt="News Image">
            @else
                <p>No Image Available</p>
            @endif
        </div>

        <div>
            <label for="image">Upload New Image:</label>
            <input type="file" id="image" name="image">
        </div>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
