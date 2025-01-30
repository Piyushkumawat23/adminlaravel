@extends('admin.layouts.app')

@section('content')
<div class="dash-content">


    <div class="container mt-4">

    
        <div class="overview">
            <div class="title">
                <i class="uil uil-user"></i>
                <span class="text">User Details</span>
            </div>
        </div>
  
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Profile Photo:</strong></p>
    @if ($user->profile_photo)
        <img src="{{ asset('profile_photo/' . $user->profile_photo) }}" width="100" height="100" alt="Profile Photo">
    @else
        No Photo
    @endif
    <br><br>
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back to Users List</a>
</div>
@endsection
