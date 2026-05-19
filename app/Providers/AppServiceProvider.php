<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gerbang keamanan untuk Super Admin (Kampus)
        Gate::define('is_super_admin', function (User $user) {
            return $user->role === 'super_admin';
        });

        // Gerbang keamanan untuk Admin UKM (Ketua)
        Gate::define('is_admin', function (User $user) {
            return $user->role === 'admin_ukm';
        });
    }
}