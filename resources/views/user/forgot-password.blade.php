{{-- @extends('user.layouts.app') --}}

<div class="container">
    <h1>Forgot Password</h1>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Send Reset Link</button>
    </form>
    
</div>
