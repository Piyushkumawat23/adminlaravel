{{-- @extends('user.layouts.app')

@section('content')
    <div class="page-content">

    <h1>{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>


@endsection --}}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $page->title }}</title>
</head>
<body>
    <h1>{{ $page->title }}</h1>
    <p><strong>Content:</strong> {{ $page->content }}</p>
    <p><strong>Status:</strong> {{ $page->status ? 'Active' : 'Inactive' }}</p>
</body>
</html>

