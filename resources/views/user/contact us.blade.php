@extends('user.layouts.app')

@section('content')
<div class="page-content">
    
    <h1>{{ $page->title }}</h1>
    <div>{!! $page->content !!}</div>
   
@endsection