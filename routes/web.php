<?php

use App\Http\Controllers\admin\GymController;
use App\Http\Controllers\tenant\DashboardController;
use App\Http\Controllers\tenant\GymMemberController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::resource('/admin/gym', GymController::class);

Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');


Route::resource('/tenant/gym_members', GymMemberController::class);
Route::get('/tenant/gym_members/add_health/{id}', [GymMemberController::class, 'add_health'])->name('tenant.gym_members.add_health');
Route::post('/tenant/gym_members/store_health/{id}', [GymMemberController::class, 'store_health'])->name('tenant.gym_members.store_health');



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
