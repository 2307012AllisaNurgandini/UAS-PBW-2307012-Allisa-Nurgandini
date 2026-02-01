<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share data setting ke semua view
        View::share('setting', Setting::first());
    }
}
