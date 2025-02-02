@extends('admin.layouts.app')

@section('content')
    <h2>Slider Settings</h2>
    <form action="{{ route('admin.slider.settings.update') }}" method="POST">
        @csrf

        <label>Autoplay:</label>
        <select name="autoplay">
            <option value="1" {{ $settings->autoplay ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$settings->autoplay ? 'selected' : '' }}>No</option>
        </select>

        <label>Autoplay Speed (ms):</label>
        <input type="number" name="autoplay_speed" value="{{ $settings->autoplay_speed }}" required>

        <label>Transition Speed (ms):</label>
        <input type="number" name="transition_speed" value="{{ $settings->transition_speed }}" required>

        <label>Loop:</label>
        <select name="loop">
            <option value="1" {{ $settings->loop ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$settings->loop ? 'selected' : '' }}>No</option>
        </select>

        <label>Show Arrows:</label>
        <select name="show_arrows">
            <option value="1" {{ $settings->show_arrows ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$settings->show_arrows ? 'selected' : '' }}>No</option>
        </select>

        <label>Show Dots:</label>
        <select name="show_dots">
            <option value="1" {{ $settings->show_dots ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ !$settings->show_dots ? 'selected' : '' }}>No</option>
        </select>

        <button type="submit">Save Settings</button>
    </form>
@endsection
