<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Log add karein

Broadcast::channel('chat.{userId}', function ($user, $userId) {
    
    // Logs check karne ke liye (storage/logs/laravel.log mein dikhega)
    Log::info("Channel Check: Trying to auth user via Session. Session ID: " . Session::get('unique_id') . " | Channel ID: " . $userId);

    if (! Session::has('unique_id')) {
        return false; 
    }

    return (string) Session::get('unique_id') === (string) $userId;
});