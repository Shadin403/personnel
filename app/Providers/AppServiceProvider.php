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

        // Define Gate for Soldier Management (View-Only Admins vs Clerical Entry)
        \Illuminate\Support\Facades\Gate::define('manage-soldiers', function ($user) {
            $type = strtoupper($user->user_type ?? '');
            // Admins are now VIEW ONLY; Clerical roles (SOLDIER, etc.) can Manage
            return !in_array($type, ['CO', '2IC', 'ADJT', 'COY COMD', 'COY CLK']);
        });
    }
}
