@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">Create Page</span>
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
            <form action="{{ route('pages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug:</label>
                    <input type="text" id="slug" name="slug" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" class="form-control" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create Page</button>
            </form>
        </div>
    </div>
@endsection
