@extends('admin.layouts.app')

@section('content')
<div class="dash-content">
    <div class="title">
        <i class="uil uil-edit"></i>
        <span class="text">Edit Subscriber</span>
    </div>

    <div class="container">
        <form action="{{ route('newsletter.update', $subscriber->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="{{ $subscriber->email }}" required>
            </div>
            
            <div class="mb-3">
                <label>Status:</label>
                <select name="status" class="form-control" required>
                    <option value="subscribed" {{ $subscriber->status == 'subscribed' ? 'selected' : '' }}>Subscribed</option>
                    <option value="unsubscribed" {{ $subscriber->status == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
