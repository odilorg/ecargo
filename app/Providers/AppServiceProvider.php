<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
        $this->app->singleton(
            RegistrationResponse::class,
            \App\Http\Responses\RegisterResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
