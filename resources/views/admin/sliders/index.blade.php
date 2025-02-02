@extends('admin.layouts.app')
@section('content')
    <div class="dash-content">
        <!-- Overview Section -->
        <div class="overview mb-4">
            <div class="title d-flex align-items-center">
                <i class="uil uil-plus-circle"></i>
                <span class="text ms-2">Slider List</span>
            </div>
        </div>

        <!-- Flash Message Section -->
        @if (session('success'))
            <div class="flash-message mb-4">
                <div class="flash-message-content alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Action Button for Add New Slider -->
        <div class="overview mb-4">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">Add New Slider</a>
            </div>
        </div>

        <!-- Sliders Grid Section -->
        <div class="row">
            @foreach ($sliders as $slider)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Image Wrapper -->
                        <div class="card-img-wrapper">
                            <img src="{{ asset('/'.$slider->image) }}" class="card-img-top">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $slider->title }}</h5>
                            <p class="card-text">{{ $slider->description }}</p>
                            <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" style="display:inline;" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
