@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center font-weight-bold text-primary">SMTP Settings</h2>

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
        <!-- Left Column: SMTP Settings Form -->
        <div class="col-md-7">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">SMTP Configuration</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.smtp.update') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Mailer</label>
                                    <input type="text" name="mailer" value="{{ $smtp->mailer ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Host</label>
                                    <input type="text" name="host" value="{{ $smtp->host ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Port</label>
                                    <input type="number" name="port" value="{{ $smtp->port ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Username</label>
                                    <input type="text" name="username" value="{{ $smtp->username ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">App Password</label>
                                    <input type="password" name="password" value="{{ $smtp->password ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Encryption</label>
                                    <select name="encryption" class="form-control shadow-sm rounded">
                                        <option value="tls" {{ ($smtp->encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ ($smtp->encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">From Address</label>
                                    <input type="email" name="from_address" value="{{ $smtp->from_address ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">From Name</label>
                                    <input type="text" name="from_name" value="{{ $smtp->from_name ?? '' }}" class="form-control shadow-sm rounded" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3 shadow-sm font-weight-bold">Save Configuration</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Test SMTP Configuration Form and Instructions -->
        <div class="col-md-5">
            <div class="row">
                <!-- Test SMTP Configuration Form (Top) -->
                <div class="col-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Test SMTP Configuration</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.smtp.test') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold">Test Email Address</label>
                                    <input type="email" name="test_email" class="form-control shadow-sm rounded" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-block shadow-sm font-weight-bold">Send Test Email</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Instructions for SMTP Configuration (Bottom) -->
                <div class="col-12 mt-3">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 text-danger">Instructions</h5>
                        </div>
                        <div class="card-body p-3">
                            <p class="text-danger font-weight-bold">⚠ Please be careful when configuring SMTP. Incorrect settings may cause issues in order processing, user registration, and newsletters.</p>
                            
                            <h6 class="text-secondary">For Non-SSL</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Use <strong>sendmail</strong> for Mail Driver if SMTP fails.</li>
                                <li class="list-group-item">Set Mail Host as per your mail client manual settings.</li>
                                <li class="list-group-item">Use Mail Port <strong>587</strong>.</li>
                                <li class="list-group-item">Set Encryption as <strong>ssl</strong> if <strong>tls</strong> fails.</li>
                            </ul>

                            <h6 class="text-secondary mt-3">For SSL</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Use <strong>sendmail</strong> if SMTP settings fail.</li>
                                <li class="list-group-item">Set Mail Host correctly as per manual settings.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
