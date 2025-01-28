@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">PAGES</span>
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
            <div class="title">
                <i class="uil uil-clock-three"></i>
                <a href="{{ route('pages.create') }}" class=" mb-1">Create New Page</a>
            </div>

            {{-- <a href="{{ route('pages.create') }}" class="btn btn-primary mb-3">Create New Page</a> --}}

            
            
            <div class="activity-data">
                <div class="data sr-number">
                    <span class="data-title">Sr. No.</span>
                    @foreach ($pages as $index => $page)
                        <span class="data-list">{{ $index + 1 }}</span>
                    @endforeach
                </div>

                <div class="data names">
                    <span class="data-title">Title</span>
                    @foreach ($pages as $page)
                        <span class="data-list">{{ $page->title }}</span>
                    @endforeach
                </div>

                <div class="data email">
                    <span class="data-title">Slug</span>
                    @foreach ($pages as $page)
                        <span class="data-list">{{ $page->slug }}</span>
                    @endforeach
                </div>

                <div class="data status">
                    <span class="data-title">Status</span>
                    @foreach ($pages as $page)
                        <span class="data-list">{{ $page->status }}</span>
                    @endforeach
                </div>
                <div class="data actions">
                    <span class="data-title">Actions</span>
                    @foreach ($pages as $page)
                        <span class="data-list">
                            <a href="{{ route('pages.edit', $page->id) }}">Edit</a>
                            <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                            
                                <label>
                                    <input type="checkbox" name="delete_file" value="1">
                                    Delete File
                                </label>
                            
                                <button type="submit">Delete</button>
                            </form>
                            
                        </span>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>

   
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this page? This action cannot be undone.");
    }
    </script>
@endsection

