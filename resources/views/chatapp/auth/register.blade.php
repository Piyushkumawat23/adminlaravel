@extends('chatapp.layouts.app')

@section('content')
    <main class="main-content">
        <div class="wrapper" style="max-width: 450px; margin: 40px auto;">
            <section class="form signup">
                <header>Realtime Chat App</header>

                {{-- Error-text div ko JS ke liye rakhein --}}
                <div class="error-text" style="display: none;"></div> 

                {{-- Form action ko 'data-action' mein daala hai --}}
                <form action="#" data-action="{{ route('chatapp.register.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    
                    <div class="name-details">
                        <div class="field input">
                            <label>First Name</label>
                            <input type="text" name="fname" placeholder="First name" value="{{ old('fname') }}" required>
                        </div>
                        <div class="field input">
                            <label>Last Name</label>
                            <input type="text" name="lname" placeholder="Last name" value="{{ old('lname') }}" required>
                        </div>
                    </div>
                    <div class="field input">
                        <label>Email Address</label>
                        <input type="text" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter new password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="field image">
                        <label>Select Image</label>
                        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                    </div>
                    <div class="field button">
                        <input type="submit" name="submit" value="Continue to Chat">
                    </div>
                </form>
                <div class="link">Already signed up? <a href="{{ route('chatapp.login') }}">Login now</a></div>
            </section>
        </div>
    </main>

    {{-- Password show/hide script --}}
    <script src="{{ asset('assets/js/chatapp/pass-show-hide.js') }}"></script>
    
    {{-- Hamari nayi optimized JS file --}}
    <script src="{{ asset('assets/js/chatapp/auth.js') }}" defer></script>

@endsection