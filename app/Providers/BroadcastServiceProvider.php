<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // -------------------------------------------------------
        // YEH LINE CHANGE KARNI HAI
        // 'middleware' => ['web'] add karna zaroori hai
        // Taki channels.php me Session access ho sake
        // -------------------------------------------------------
        
        Broadcast::routes(['middleware' => ['web']]);

        require base_path('routes/channels.php');
    }
}