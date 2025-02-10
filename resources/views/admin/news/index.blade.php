@extends('admin.layouts.app')

@section('content')

<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-tachometer-fast-alt"></i>
            <span class="text">News List</span>
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
    <h1>News List</h1>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Add News</a>
    <table class="table">
        <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($news as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->status ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
