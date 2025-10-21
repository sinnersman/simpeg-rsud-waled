<?php

namespace App\Providers;

use App\Models\Pegawai;
use App\Models\User;
use App\Observers\PegawaiObserver;
use App\Observers\UserObserver;
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
        Pegawai::observe(PegawaiObserver::class);
        User::observe(UserObserver::class);
    }
}
