@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">Send Newsletter</span>
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

<div class="container">
    <h2>Send Newsletter</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.send.newsletter') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Subject:</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Message:</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Newsletter</button>
    </form>
    
</div>
@endsection
