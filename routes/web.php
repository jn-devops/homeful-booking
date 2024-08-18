<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', [\App\Http\Controllers\LoanCalculatorController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/client-information', \App\Livewire\ClientInformationSheet::class)->name('client-information');

Route::get('/proceed', function () {
    return Inertia::render('Proceed');
});

Route::get('/details', function () {
    return Inertia::render('Details');
});

Route::get('/payments', function () {
    return Inertia::render('PaymentDetails');
});

Route::get('/creditdetails', function () {
    return Inertia::render('CreditCard');
});

require __DIR__.'/auth.php';
