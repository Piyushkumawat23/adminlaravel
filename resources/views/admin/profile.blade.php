@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-setting"></i>
            <span class="text">Profile Page</span>
        </div>
    </div>
</div>

<!-- Flash Message Section -->
@if(session('success'))
    <div class="flash-message">
        <div class="flash-message-content">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="row">
    <div class="col-lg-4 mb-5">
        <!-- Name and Email Update Form -->
        <div class="card">
            <div class="card-header">
                <h4 class="label">Profile Settings</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.updateDetails') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>

        <!-- Profile Photo Update Form -->
        <div class="card">
            <div class="card-header">
                <h4 class="label">Profile Image</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.updatePhoto') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar">Profile Photo</label>
                        <input type="file" id="avatar" name="profile_photo" class="form-control">
                    </div>

                    <div class="avatar-holder mb-3">
                        @if ($admin->profile_photo)
                            <img src="{{ asset($admin->profile_photo) }}" alt="User Avatar" class="img-thumbnail">
                            <button type="button" class="btn btn-danger mt-2" data-toggle="modal" data-target="#deleteAvatarModal">Delete Avatar</button>
                        @else
                            <p>No avatar uploaded.</p>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Avatar Modal -->
<div class="modal fade" id="deleteAvatarModal" tabindex="-1" role="dialog" aria-labelledby="deleteAvatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                        <div class="modal-footer">
                <form action="{{ route('admin.profile.deleteAvatar') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Avatar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
