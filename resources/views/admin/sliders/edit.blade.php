@extends('admin.layouts.app')

@section('content')
    <h1>Edit Slider</h1>

    <form action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Title:</label>
        <input type="text" name="title" value="{{ $slider->title }}" required>

        <label>Description:</label>
        <textarea name="description">{{ $slider->description }}</textarea>

        <label>Current Image:</label>
        <img src="{{ asset('storage/'.$slider->image) }}" width="100">

        <label>New Image:</label>
        <input type="file" name="image">

        <button type="submit">Update</button>
    </form>
@endsection
