@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-setting"></i>
            <span class="text">Settings Page</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 mb-5">
        <div class="card">
            <div class="card-header">
                <h4 class="label">Profile Settings</h4>
            </div>

            <div class="card-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row d-flex">
                        <!-- User Info Section -->
                        <div class="col-md-8 order-2 order-md-1">
                            <div class="mb-3">
                                <label for="userName">Username</label>
                                <input type="text" id="userName" name="userName" class="form-control" placeholder="Username" required>
                            </div>

                            <div class="mb-4">
                                <label for="biography">Biography</label>
                                <textarea id="biography" name="biography" class="form-control" placeholder="Share something here..." required></textarea>
                            </div>
                            <div class="avatar-holder mb-3">
                                <div class="img-as-background">
                                    <img src="/images/logo.png" alt="User Avatar">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="button" id="uploadButton" class="btn btn-secondary">
                                    <span class="material-icons">cloud_upload</span> Upload
                                </button>
                            </div>

                            <small>Choose an image no larger than 3MB</small>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
    </div>
</div>
@endsection
