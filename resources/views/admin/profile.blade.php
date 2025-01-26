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
                <form id="settingsForm" action="{{ route('admin.profile.updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6 mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $admin->name) }}" disabled required>
                    
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" disabled required>
                    </div>

                    <div class="mb-3">
                        <label for="avatar">Profile Photo</label>
                        <input type="file" id="avatar" name="profile_photo" class="form-control" disabled>
                    </div>
                    <div class="avatar-holder mb-3">
                        @if ($admin->profile_photo)
                            <img src="{{ asset($admin->profile_photo) }}" alt="User Avatar" class="img-thumbnail" width="100px">
                            <div class="modal-footer">
                               
                            </div>
                        @else
                            <p>No avatar uploaded.</p>
                        @endif
                    </div>
                    
                    <!-- Add the delete profile photo button here -->
                    <button type="button" class="btn btn-danger" id="deleteProfilePhotoButton">Delete Profile Photo</button>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" id="editSettingsButton">Edit</button>
                        <button type="submit" class="btn btn-primary" id="saveSettingsButton" disabled>Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    const editSettingsButton = document.getElementById('editSettingsButton');
    const saveSettingsButton = document.getElementById('saveSettingsButton');
    const settingsFormElements = document.querySelectorAll('#settingsForm input');
    const deleteProfilePhotoButton = document.getElementById('deleteProfilePhotoButton');
    const avatarHolder = document.querySelector('.avatar-holder');
    const flashMessageContainer = document.querySelector('.flash-message');

    if (deleteProfilePhotoButton) {
        deleteProfilePhotoButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete the profile photo?')) {
                fetch('{{ route('admin.profile.deleteAvatar') }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        location.reloq();

                    } else {
                        alert('Failed to delete the profile photo.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the profile photo.');
                });
            }
        });
    }

    // Toggle edit mode for settings form
    editSettingsButton.addEventListener('click', function () {
        const isEditing = saveSettingsButton.disabled;
        
        // Enable/Disable input fields based on edit mode
        settingsFormElements.forEach(el => el.disabled = !isEditing);
        saveSettingsButton.disabled = isEditing;
        editSettingsButton.textContent = isEditing ? 'Cancel Edit' : 'Edit';
        
        // Enable/Disable 'Save' button when email or name field changes
        settingsFormElements.forEach(input => {
            input.addEventListener('input', () => {
                const isModified = [...settingsFormElements].some(el => el.value !== el.defaultValue);
                saveSettingsButton.disabled = !isModified;
            });
        });
    });
});

</script>

@endsection
