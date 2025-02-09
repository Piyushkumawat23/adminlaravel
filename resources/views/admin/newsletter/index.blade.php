@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">Newsletter Subscribers</span>
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
           

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('newsletter.show') }}" class="btn btn-primary">Send Newsletter</a>

            <form action="{{ route('newsletter.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                </div>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>

            <hr>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscribers as $subscriber)
                        <tr>
                            <td>{{ $subscriber->id }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>{{ $subscriber->status }}</td>
                            <td>
                                <a href="{{ route('newsletter.edit', $subscriber->id) }}" class="btn btn-info">Edit</a>
                                {{-- <a href="{{ route('newsletter.unsubscribe', $subscriber->id) }}" class="btn btn-warning">Unsubscribe</a> --}}
                                <a href="{{ route('newsletter.delete', $subscriber->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $subscribers->links() }}
        </div>
    </div>
    @endsection
