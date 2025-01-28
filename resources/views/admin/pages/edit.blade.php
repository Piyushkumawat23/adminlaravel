@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-edit-alt"></i>
                <span class="text">Edit Page</span>
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

        <div class="activity">
            <form action="{{ route('pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ $page->title }}" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control" value="{{ $page->slug }}" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" class="form-control" required>{{ $page->content }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="active" {{ $page->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $page->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Page</button>
            </form>
        </div>
    </div>

   
@endsection
