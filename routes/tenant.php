<?php

declare(strict_types=1);

use App\Http\Controllers\admin\GymController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\tenant\DashboardController;
use App\Http\Controllers\tenant\GymMemberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
        // return Inertia::render('welcome');
    });

        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');

        Route::post('register', [RegisteredUserController::class, 'store'])
            ->name('register.store');

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->name('login.store');


        Route::get('/', function () {
            return Inertia::render('welcome');
        })->name('home');

        Route::middleware(['auth', 'verified'])->group(function () {
            Route::get('admin/dashboard', function () {
                if(auth()->user()->role == "tenant") {
                    abort(401);
                }
                return Inertia::render('admin/dashboard');
            })->name('dashboard');
        });

        Route::middleware('auth')->group(function () {
            // admin routes
            Route::resource('/admin/gym', GymController::class);

            // tenant routes
            Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

            Route::resource('/tenant/gym_members', GymMemberController::class);
            Route::get('/tenant/gym_members/add_health/{id}', [GymMemberController::class, 'add_health'])->name('tenant.gym_members.add_health');
            Route::post('/tenant/gym_members/store_health/{id}', [GymMemberController::class, 'store_health'])->name('tenant.gym_members.store_health');
        });
   
});
