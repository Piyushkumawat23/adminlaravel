@extends('admin.layouts.app')

@section('content')

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Add News</span>
        </div>
    </div>
    
    <!-- Flash Message Section -->
    @if (session('success'))
    <div class="flash-message">
        <div class="flash-message-content">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <h1>Add News</h1>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter title" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" placeholder="Enter content" required></textarea>
        </div>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="1" {{ isset($news) && $news->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ isset($news) && $news->status == 0 ? 'selected' : 'selected' }}>Inactive</option>
            </select>
            
        </div>
        
        <div>
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image">
        </div>

        <button type="submit">Save</button>
    </form>

</div>
@endsection
