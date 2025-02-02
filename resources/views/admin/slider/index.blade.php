@extends('admin.layouts.app')

@section('content')
<div class="dash-content">

    <div class="container mt-4">
        <div class="overview">
            <div class="title">
                <i class="uil uil-user"></i>
                <span class="text">Slider Settings</span>
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
   

   

    <form action="{{ route('admin.slider.settings.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="autoplay">Autoplay</label>
            <select name="autoplay" id="autoplay" class="form-control">
                <option value="1" {{ optional($settings)->autoplay ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ optional($settings)->autoplay === 0 ? 'selected' : '' }}>No</option>
            </select>
            
        </div>

        <div class="form-group">
            <label for="speed">Speed (ms)</label>
            {{-- <input type="number" name="speed" id="speed" class="form-control" value="{{ $settings->speed }}"> --}}
            <input type="number" name="speed" id="speed" class="form-control" value="{{ optional($settings)->speed ?? 3000 }}">

        </div>

        <div class="form-group">
            <label for="loop">Loop</label>
            <select name="loop" id="loop" class="form-control">
                <option value="1" {{ optional($settings)->loop ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ optional($settings)->loop === 0 ? 'selected' : '' }}>No</option>
            </select>
            
        </div>

        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection
