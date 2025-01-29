@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>SMTP Settings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.smtp.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Mailer</label>
            <input type="text" name="mailer" value="{{ $smtp->mailer ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Host</label>
            <input type="text" name="host" value="{{ $smtp->host ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Port</label>
            <input type="number" name="port" value="{{ $smtp->port ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{ $smtp->username ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="{{ $smtp->password ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>Encryption</label>
            <input type="text" name="encryption" value="{{ $smtp->encryption ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>From Address</label>
            <input type="email" name="from_address" value="{{ $smtp->from_address ?? '' }}" class="form-control">
        </div>

        <div class="form-group">
            <label>From Name</label>
            <input type="text" name="from_name" value="{{ $smtp->from_name ?? '' }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
