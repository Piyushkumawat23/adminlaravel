@extends('admin.layouts.app')

@section('content')

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">Add Category</span>
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
    <h2>Add Category</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
    </form>
@endsection
