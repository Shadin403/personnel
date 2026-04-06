<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Register .tpl extension for Blade templates
        \Illuminate\Support\Facades\View::addExtension('tpl', 'blade');

        // Define Gate for Soldier Management (Admins vs View-Only Jco/OR)
        \Illuminate\Support\Facades\Gate::define('manage-soldiers', function ($user) {
            return $user->user_type !== 'Jco/OR';
        });
    }
}
