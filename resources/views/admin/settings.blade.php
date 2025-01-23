@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="overview">
        <div class="title">
            <i class="uil uil-setting"></i>
            <span class="text">Website Settings</span>
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
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="label">Website Configuration</h4>
            </div>
            <div class="card mb-5">
                <div class="card-body">
                    <!-- Settings Form -->
                    <form action="{{ route('admin.settings.save') }}" method="POST" id="settingsForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-12 mb-3">
                                <label for="siteName">Website Name</label>
                                <input type="text" id="siteName" name="siteName" class="form-control" value="{{ $settings->site_name ?? '' }}" placeholder="Enter website name" required disabled>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <label for="siteURL">Website URL</label>
                                <input type="url" id="siteURL" name="siteURL" class="form-control" value="{{ $settings->site_url ?? '' }}" placeholder="https://example.com" required disabled>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="contactEmail">Contact Email</label>
                                <input type="email" id="contactEmail" name="contactEmail" class="form-control" value="{{ $settings->contact_email ?? '' }}" placeholder="admin@example.com" required disabled>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="supportEmail">Support Email</label>
                                <input type="email" id="supportEmail" name="supportEmail" class="form-control" value="{{ $settings->support_email ?? '' }}" placeholder="support@example.com" disabled>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="phoneNumber">Contact Number</label>
                                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" value="{{ $settings->phone_number ?? '' }}" placeholder="123-456-7890" disabled>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="address">Office Address</label>
                                <textarea id="address" name="address" class="form-control" placeholder="Enter office address" rows="3" disabled>{{ $settings->address ?? '' }}</textarea>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <label for="footerText">Footer Text</label>
                                <textarea id="footerText" name="footerText" class="form-control" placeholder="Enter footer text" rows="3" disabled>{{ $settings->footer_text ?? '' }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Buttons in one row -->
                        <div class="row d-flex justify-content-between">
                            <div class="col-auto">
                                <button type="button" class="btn btn-secondary" id="editButton">Edit</button>
                                <button type="submit" class="btn btn-primary" id="saveButton" disabled>Save Settings</button>
                            </div>
                        </div>
                    </form>

                    <!-- Logo Upload and Delete -->
                    {{-- <div class="col-sm-12 mb-3">
                        <label for="siteLogo">Website Logo</label>
                        <input type="file" id="siteLogo" name="siteLogo" class="form-control" {{ $settings->site_logo ? '' : 'disabled' }}>
                        <button type="button" id="editLogoButton" class="btn btn-secondary mt-2" {{ $settings->site_logo ? '' : 'disabled' }}>Edit Logo</button>
                        @if($settings->site_logo)
                            <div class="mt-3">
                                <img src="{{ asset($settings->site_logo) }}" alt="Website Logo" width="100">
                                <!-- Separate Delete Logo Form -->
                                <form action="{{ route('admin.settings.deleteLogo') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-2">
                                        Delete Logo
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div> --}}


                    <div class="col-sm-12 mb-3">
                        <label for="siteLogo">Website Logo</label>
                        <input type="file" id="siteLogo" name="siteLogo" class="form-control" disabled>
                        <button type="button" id="editLogoButton" class="btn btn-secondary mt-2">Edit Logo</button>
                        @if($settings->site_logo)
                            <div class="mt-3">
                                <img src="{{ asset($settings->site_logo) }}" alt="Website Logo" width="100">
                                <!-- Separate Delete Logo Form -->
                                <form action="{{ route('admin.settings.deleteLogo') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-2">
                                        Delete Logo
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButton = document.getElementById('editButton');
        const saveButton = document.getElementById('saveButton');
        const formElements = document.querySelectorAll('#settingsForm input, #settingsForm textarea');
        const logoInput = document.getElementById('siteLogo');
        const editLogoButton = document.getElementById('editLogoButton');
        const originalValues = {};

        // Save original values for reset
        formElements.forEach(element => {
            originalValues[element.name] = element.value;
        });

        editButton.addEventListener('click', function() {
            const isEditing = saveButton.disabled === false;

            if (isEditing) {
                // Cancel edit: Reset values and disable fields
                formElements.forEach(element => {
                    element.disabled = true;
                    element.value = originalValues[element.name];
                });
                logoInput.disabled = true;
                editLogoButton.disabled = true;
                editButton.textContent = 'Edit';
                saveButton.disabled = true;
            } else {
                // Enable editing
                formElements.forEach(element => {
                    element.disabled = false;
                });
                logoInput.disabled = false;
                editLogoButton.disabled = false;
                editButton.textContent = 'Cancel Edit';
                saveButton.disabled = false;
            }
        });

        // Enable logo editing when the Edit Logo button is clicked
        editLogoButton.addEventListener('click', function() {
            logoInput.disabled = false;
            editLogoButton.textContent = 'Cancel Edit Logo';
        });
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const editButton = document.getElementById('editButton');
    const saveButton = document.getElementById('saveButton');
    const formElements = document.querySelectorAll('#settingsForm input, #settingsForm textarea');
    const logoInput = document.getElementById('siteLogo');
    const editLogoButton = document.getElementById('editLogoButton');

    let isEditing = false; // Tracks form editing state
    let isLogoEditing = false; // Tracks logo editing state

    // Save original values for reset
    const originalValues = Array.from(formElements).reduce((acc, element) => {
        acc[element.name] = element.value;
        return acc;
    }, {});

    // Function to toggle form editing
    function toggleEdit() {
        isEditing = !isEditing;
        formElements.forEach(element => (element.disabled = !isEditing));
        logoInput.disabled = !isEditing && !isLogoEditing;
        saveButton.disabled = !isEditing;
        editButton.textContent = isEditing ? 'Cancel Edit' : 'Edit';

        // Reset form if editing is canceled
        if (!isEditing) {
            formElements.forEach(element => (element.value = originalValues[element.name]));
            logoInput.value = ''; // Clear logo input
            isLogoEditing = false;
            editLogoButton.textContent = 'Edit Logo';
        }
    }

    // Function to toggle logo editing
    function toggleLogoEdit() {
        if (!isEditing) return; // Only allow logo editing if form is in edit mode

        isLogoEditing = !isLogoEditing;
        logoInput.disabled = !isLogoEditing;
        editLogoButton.textContent = isLogoEditing ? 'Cancel Edit Logo' : 'Edit Logo';

        // Reset logo input if canceled
        if (!isLogoEditing) {
            logoInput.value = '';
        }
    }

    // Event listeners
    editButton.addEventListener('click', toggleEdit);
    editLogoButton.addEventListener('click', toggleLogoEdit);
});

</script>

@endsection
