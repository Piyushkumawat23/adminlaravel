@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-pen"></i>
                <span class="text">Edit Menu Category</span>
            </div>
        </div>

        <form action="{{ route('admin.menus.updateCategory', $menuCategory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="menu_id">Menu ID:</label>
                <input type="number" id="menu_id" name="menu_id" class="form-control" value="{{ $menuCategory->menu_id }}" required>
            </div>

            <div class="form-group">
                <label for="menu_name">Menu Name:</label>
                <input type="text" id="menu_name" name="menu_name" class="form-control" value="{{ $menuCategory->menu_name }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="1" {{ $menuCategory->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$menuCategory->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Menu Category</button>
        </form>
    </div>
@endsection
