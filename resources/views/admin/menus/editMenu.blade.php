@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-pen"></i>
                <span class="text">Edit Menu</span>
            </div>
        </div>

        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')
        

            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ $menu->title }}" required>
            </div>

            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" name="slug" class="form-control" value="{{ $menu->slug }}" required>
            </div>

            <div class="form-group">
                <label for="url">URL:</label>
                <input type="text" id="url" name="url" class="form-control" value="{{ $menu->url }}">
            </div>

            <div class="form-group">
                <label for="order">Order:</label>
                <input type="number" id="order" name="order" class="form-control" value="{{ $menu->order }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="1" {{ $menu->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$menu->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Menu</button>
        </form>
    </div>
@endsection
