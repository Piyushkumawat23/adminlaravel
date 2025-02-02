@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">Slider List</span>
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


   
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add New Slider</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $slider)
                <tr>
                    <td>{{ $slider->title }}</td>
                    <td><img src="{{ asset('storage/'.$slider->image) }}" width="100"></td>
                    <td>{{ $slider->description }}</td>
                    <td>
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
