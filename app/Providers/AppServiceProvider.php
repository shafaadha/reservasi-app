<?php

namespace App\Providers;

use App\Models\User;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\PaymentServiceInterface;
use App\Services\Contracts\ReservationServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\RoomUnitServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\PaymentService;
use App\Services\ReservationService;
use App\Services\RoomService;
use App\Services\RoomUnitService;
use App\Services\UserService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
        $this->app->bind(
            ReservationServiceInterface::class,
            ReservationService::class
        );

        $this->app->bind(
            RoomServiceInterface::class,
            RoomService::class
        );

        $this->app->bind(
            PaymentServiceInterface::class,
            PaymentService::class
        );

        $this->app->bind(
            RoomUnitServiceInterface::class,
            RoomUnitService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('confirm-res', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
