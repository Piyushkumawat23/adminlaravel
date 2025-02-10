@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-user"></i>
                <span class="text">Users</span>
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
        
        <div class="activity">
            

            <div class="activity-data">
                <!-- Users Data Section -->
                <div class="data sr-number">
                    <span class="data-title">Sr. No.</span>
                    @foreach ($users as $index => $user)
                        <span class="data-list">{{ $index + 1 }}</span>
                    @endforeach
                </div>

                <div class="data names">
                    <span class="data-title">Name</span>
                    @foreach ($users as $user)
                        <span class="data-list">{{ $user->name }}</span>
                    @endforeach
                </div>

                <div class="data email">
                    <span class="data-title">Email</span>
                    @foreach ($users as $user)
                        <span class="data-list">{{ $user->email }}</span>
                    @endforeach
                </div>

                <div class="data status">
                    <span class="data-title">Profile Photo</span>
                    @foreach ($users as $user)
                        <span class="data-list">
                            @if ($user->profile_photo)
                                <img src="{{ asset('/' . $user->profile_photo) }}" width="30" height="30" alt="Profile Photo">
                            @else
                                No Photo
                            @endif
                        </span>
                    @endforeach
                </div>

                <div class="data actions">
                    <span class="data-title">Actions</span>
                    @foreach ($users as $user)
                        <span class="data-list">
                            <a href="{{ route('admin.users.show', $user->id) }}">View</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    
@endsection
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this user? This action cannot be undone.");
    }
</script>