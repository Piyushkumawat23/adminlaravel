@extends('admin.layouts.app')

<style>
    /* Custom styles for the toggle switch */

    

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .menu-card {
        border: 1px solid var(--border-color);
        padding: 15px;
        border-radius: 5px;
        background: var(--card-bg);
    }

    .menu-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-warning {
        text-decoration: none;
        padding: 5px 10px;
        color: #fff;
        background-color: #ffc107;
        border-radius: 3px;
    }

    /* Custom Toggle Styles */
    
    .switch {
        position: relative;
        display: inline-block;
        width: 57px;
        height: 20px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    
    .slider:before {
        position: absolute;
        content: "";
        height: 12px;
        width: 17px;
        left: 8px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
    }
    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    /* Rounded slider */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-plus-circle"></i>
                <span class="text">Menu Management</span>
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

        <!-- Add Menu Button -->
        <a href="{{ route('admin.menus.createMenuCategory') }}" class="btn btn-primary">Add New Menu</a>

        <div class="menu-grid">
            @foreach ($menuCategories as $category)
                <div class="menu-card">
                    <div class="menu-header">
                        <h4>{{ $category->menu_name }}</h4>
                        <a href="{{ route('admin.menus.show', $category->id) }}" class="btn btn-warning">Show Menus</a>
                    </div>
        
                    <label class="switch">
                        <input type="checkbox" name="status" value="active"
                               {{ $category->status == 'active' ? 'checked' : '' }} 
                               data-id="{{ $category->id }}" onchange="updateStatus(this)">
                        <span class="slider round"></span>
                    </label>
        
                    <div>
                        <!-- Edit Button -->
                        <a href="{{ route('admin.menus.edit', $category->id) }}" class="btn btn-info">Edit</a>
                        <!-- Delete Button -->
                        <form action="{{ route('admin.menus.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>
                    </div>
        
                    @foreach ($category->menus as $menu)
                        <p><strong>Menu Title:</strong> {{ $menu->title }}</p>
                        <p><strong>Slug:</strong> {{ $menu->slug }}</p>
                        <p><strong>Parent:</strong> {{ $menu->parent_id == 0 ? 'Main Menu' : 'Submenu' }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
        
    </div>
@endsection

<script>
    function updateStatus(element) {
        const categoryId = element.getAttribute('data-id');
        const status = element.checked ? 'active' : 'inactive';

        // AJAX request to update the status
        fetch(`/admin/menus/update-status/${categoryId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully.');
                // Refresh the page after alert
                location.reload();
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
</script>


