@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">{{ $category->menu_name }} (Menu)</span>
            </div>
        </div>
        <a href="{{ route('admin.menus.createMenu') }}" class="btn btn-primary">Add New Menu</a>

        <!-- Display Menus of the Selected Category -->
        <div class="activity">
            <table class="table">
                <thead>
                    <tr>
                        <th>Menu ID</th>
                        {{-- <th>Menu Name</th> --}}
                        <th>Title</th>
                        <th>Slug</th>
                        <th>URL</th>
                        <th>Parent</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->menus as $menu)
                        <tr>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $menu->slug }}</td>
                            <td>{{ $menu->url }}</td>
                            <td>{{ $menu->parent_id == 0 ? 'Main Menu' : 'Submenu' }}</td>
                            <td>{{ $menu->order }}</td>
                            <td>{{ $menu->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-warning">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this menu?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
