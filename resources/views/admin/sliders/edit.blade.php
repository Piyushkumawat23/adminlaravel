@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Slider</h1>
        
        <!-- Flash Message for Success -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" value="{{ $slider->title }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ $slider->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image:</label>
                <div>
                    <img src="{{ asset('/'.$slider->image) }}" width="150" class="img-fluid">
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">New Image (Optional):</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update Slider</button>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
    </div>
@endsection
