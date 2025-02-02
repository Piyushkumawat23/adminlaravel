@extends('user.layouts.app')

@section('content')
    <div class="container">
        <h2>Available Menus</h2>
        <div class="menu-grid">
            @foreach ($menuCategories as $category)
                <div class="menu-card">
                    <h4>{{ $category->menu_name }}</h4>
                    <ul>
                        @foreach ($category->menus as $menu)
                            <li><a href="{{ $menu->url ?? '#' }}">{{ $menu->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection
