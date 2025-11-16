@extends('chatapp.layouts.app')

@section('content')
    <main class="main-content">
        <div class="wrapper" style="max-width: 450px; margin: 40px auto;">
            <section class="form login">
                <header>Realtime Chat App</header>

                {{-- Error-text div ko JS ke liye rakhein --}}
                <div class="error-text" style="display: none;"></div> 

                {{-- Form action ko 'data-action' mein daala hai --}}
                <form action="#" data-action="{{ route('chatapp.login.authenticate') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <div class="field input">
                        <label>Email Address</label>
                        <input type="text" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Enter your password" required>
                        <i class="fas fa-eye"></i>
                    </div>
                    
                    <div class="field button">
                        <input type="submit" name="submit" value="Continue to Chat">
                    </div>
                </form>
                <div class="link">Not yet signed up? <a href="{{ route('chatapp.register') }}">Signup now</a></div>
            </section>
        </div>
    </main>

    {{-- Password show/hide script --}}
    <script src="{{ asset('assets/js/chatapp/pass-show-hide.js') }}"></script>

    {{-- Hamari nayi optimized JS file --}}
    <script src="{{ asset('assets/js/chatapp/auth.js') }}" defer></script>
@endsection