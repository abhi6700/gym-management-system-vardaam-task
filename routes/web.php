<?php

use App\Http\Controllers\admin\GymController;
use App\Http\Controllers\tenant\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('admin/dashboard', function () {
        return Inertia::render('admin/dashboard');
    })->name('dashboard');
});

Route::resource('/admin/gym', GymController::class);

Route::get('/tenant/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
