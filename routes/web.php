<?php

use App\Http\Controllers\DisclaimerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ConsultController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::resource('disclaimer', DisclaimerController::class)->only(['index', 'store']);

Route::middleware(\App\Http\Middleware\DisclaimerMiddleware::class)
    ->resource('consult', ConsultController::class)->parameters(['consult' => 'sku']);

Route::resource('contacts', ContactController::class);
