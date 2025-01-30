@extends('admin.layouts.app')

@section('content')
<div class="dash-content">


    <div class="container mt-4">

    
        <div class="overview">
            <div class="title">
                <i class="uil uil-user"></i>
                <span class="text">Edit User</span>
            </div>
        </div>
   

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="profile_photo">Profile Photo</label>
            <input type="file" class="form-control" id="profile_photo" name="profile_photo">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>

    <br><br>
    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Back to Users List</a>
</div>
@endsection
