@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Edit Category</span>
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
    <h2>Edit Category</h2>
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>


        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
