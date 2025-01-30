@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold text-primary">Users</h2>

    <!-- Flash Message Section -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Users List -->
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Users List</h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Profile Photo</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->profile_photo)
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" width="50" height="50" alt="Profile Photo">
                                        @else
                                            No Photo
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Add your action buttons (edit, delete, etc.) here -->
                                        <a href="#" class="btn btn-info btn-sm">View</a>
                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
