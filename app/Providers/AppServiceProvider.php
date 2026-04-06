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

        // Define Gate for Soldier Management (Admins can manage, SNK/Soldiers are restricted)
        \Illuminate\Support\Facades\Gate::define('manage-soldiers', function ($user) {
            $userType = '';
            
            if ($user instanceof \App\Models\Soldier) {
                $userType = strtoupper($user->user_type ?? '');
            } elseif ($user instanceof \App\Models\User) {
                // If user is linked to a soldier, check that type, otherwise check user table type
                if ($user->soldier_id) {
                    $userType = strtoupper($user->soldier->user_type ?? '');
                } else {
                    $userType = strtoupper($user->user_type ?? '');
                }
            }

            return $userType !== 'SNK' && !empty($userType);
        });
    }
}
