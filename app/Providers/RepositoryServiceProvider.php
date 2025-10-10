<?php

namespace App\Providers;

use App\Models\Gym;
use App\Models\User;
use App\Repositories\gym\GymRepository;
use App\Repositories\gym\GymRepositoryInterface;
use App\Repositories\gym_member\GymMemberRepository;
use App\Repositories\gym_member\GymMemberRepositoryInterface;
use App\Repositories\gym_member\health\GymMemberHealthRepository;
use App\Repositories\gym_member\Health\GymMemberHealthRepositoryInterface;
use App\Repositories\user\UserRepository;
use App\Repositories\user\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GymRepositoryInterface::class, GymRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(GymMemberRepositoryInterface::class, GymMemberRepository::class);
        $this->app->bind(GymMemberHealthRepositoryInterface::class, GymMemberHealthRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
