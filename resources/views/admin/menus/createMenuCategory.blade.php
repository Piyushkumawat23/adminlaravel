@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <span class="text">Create Menu Category</span>
        </div>
    </div>

    <form action="{{ route('admin.menus.storeMenuCategory') }}" method="POST">
        @csrf
    
        <div class="form-group">
            <label for="menu_id">Menu ID:</label>
            <input type="number" id="menu_id" name="menu_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="menu_name">Menu Name:</label>
            <input type="text" id="menu_name" name="menu_name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Menu Category</button>
    </form>
</div>
@endsection
