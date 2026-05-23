<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\View\Composers\NotificationComposer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Attach ke semua component layout navbar
        View::composer('components.layouts.navbar', NotificationComposer::class);
    }
}