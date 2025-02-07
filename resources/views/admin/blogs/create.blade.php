@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">Create Post</span>
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

        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Slug (Optional)</label>
                <input type="text" name="slug" class="form-control">
                <small class="form-text text-muted">Leave this empty if you want it to be auto-generated from the title.</small>
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label>Image (Optional)</label>
                <input type="file" name="image" class="form-control">
                <small class="form-text text-muted">Select an image to upload (optional).</small>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button class="btn btn-success">Save</button>
        </form>
@endsection
