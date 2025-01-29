<?php

namespace App\Providers;
use App\Models\SmtpSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    $smtp = SmtpSetting::first();

    if ($smtp) {
        Config::set('mail.mailer', $smtp->mailer);
        Config::set('mail.host', $smtp->host);
        Config::set('mail.port', $smtp->port);
        Config::set('mail.username', $smtp->username);
        Config::set('mail.password', $smtp->password);
        Config::set('mail.encryption', $smtp->encryption);
        Config::set('mail.from.address', $smtp->from_address);
        Config::set('mail.from.name', $smtp->from_name);
    }
}
}