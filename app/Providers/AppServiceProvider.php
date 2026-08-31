<?php

namespace App\Providers;

use App\Mail\Transport\EmailJsTransport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (str_starts_with(config('app.url'), 'https://')) {
            URL ::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('emailjs', function (array $config) {
            return new EmailJsTransport(
                serviceId: $config['service_id'],
                templateId: $config['template_id'],
                publicKey: $config['public_key'],
                privateKey: $config['private_key'],
            );
        });
    }
}
