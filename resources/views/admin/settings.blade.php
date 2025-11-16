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
    @if (session('success'))
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
                        <!-- Website Settings Form -->
                        <form action="{{ route('admin.settings.save') }}" method="POST" id="settingsForm"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-12 mb-3">
                                    <label for="siteName">Website Name</label>
                                    <input type="text" id="siteName" name="siteName" class="form-control"
                                        value="{{ $settings->site_name ?? '' }}" placeholder="Enter website name" required>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <label for="siteURL">Website URL</label>
                                    <input type="url" id="siteURL" name="siteURL" class="form-control"
                                        value="{{ $settings->site_url ?? '' }}" placeholder="https://example.com" required>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="contactEmail">Contact Email</label>
                                    <input type="email" id="contactEmail" name="contactEmail" class="form-control"
                                        value="{{ $settings->contact_email ?? '' }}" placeholder="admin@example.com"
                                        required>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="supportEmail">Support Email</label>
                                    <input type="email" id="supportEmail" name="supportEmail" class="form-control"
                                        value="{{ $settings->support_email ?? '' }}" placeholder="support@example.com">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="phoneNumber">Contact Number</label>
                                    <input type="text" id="phoneNumber" name="phoneNumber" class="form-control"
                                        value="{{ $settings->phone_number ?? '' }}" placeholder="123-456-7890">
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="address">Office Address</label>
                                    <textarea id="address" name="address" class="form-control" placeholder="Enter office address" rows="3">{{ $settings->address ?? '' }}</textarea>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <label for="footerText">Footer Text</label>
                                    <textarea id="footerText" name="footerText" class="form-control" placeholder="Enter footer text" rows="3">{{ $settings->footer_text ?? '' }}</textarea>
                                </div>
                                
                                <div class="col-sm-12 mb-3">
                                    <label for="active_theme">Select Theme</label>
                                    <select name="active_theme" id="active_theme" class="form-control">
                                        <option value="frontend" {{ $settings->active_theme == 'frontend' ? 'selected' : '' }}>Frontend</option>
                                        <option value="user" {{ $settings->active_theme == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="chatapp" {{ $settings->active_theme == 'chatapp' ? 'selected' : '' }}>chatapp</option>
                                    </select>
                                </div>
                                
                            </div>


                            <div class="col-auto">
                                <label class="col-sm-12 mb-3" for="siteLogo">Website Logo</label>
                                <input type="file" id="siteLogo" name="siteLogo" class="form-control">

                                @if ($settings && $settings->site_logo)
                                    <div class="modal-footer">
                                        <img src="{{ asset($settings->site_logo) }}" alt="Website Logo" width="100">

                                        

                                    </div>
                                @else
                                    <p>No logo uploaded.</p>
                                @endif



                            </div>

                            <!-- Buttons for Website Settings -->
                            <div class="row d-flex justify-content-between">
                                <div class="col-auto">

                                    <button type="submit" class="btn btn-primary">Update</button>

                                        <button type="submit" class="btn btn-danger" id="deleteLogoButton">Delete
                                            Logo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Cache DOM elements
            const deleteLogoButton = document.getElementById('deleteLogoButton');
            const settingsFormElements = document.querySelectorAll('#settingsForm input, #settingsForm textarea');
            const logoInput = document.getElementById('siteLogo');
            const originalValues = {};

            // Save original values for settings form reset
            settingsFormElements.forEach(element => {
                originalValues[element.name] = element.value;
            });

            // Delete Logo Functionality
            if (deleteLogoButton) {
                deleteLogoButton.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete the logo?')) {
                        fetch('{{ route('admin.settings.deleteLogo') }}', {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert(data.message);
                                    location.reload(); // Reload page to reflect changes
                                } else {
                                    alert('Failed to delete the logo.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while deleting the logo.');
                            });
                    }
                });
            }


        });
    </script>
@endsection
