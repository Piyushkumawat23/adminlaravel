@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <span class="text">Create Menu</span>
        </div>
    </div>

    <form action="{{ route('admin.menus.storeMenu') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="menu_category_id">Menu Category:</label>
            <select id="menu_category_id" name="menu_category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $selectedCategoryId ? 'selected' : '' }}>
                        {{ $category->menu_name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" id="slug" name="slug" class="form-control" required>
        </div>
    
        <button type="submit" class="btn btn-primary">Create Menu</button>
    </form>
    
</div>
@endsection
