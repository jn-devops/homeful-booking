<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProceedController;
use App\Http\Controllers\ClientInformationController;
use App\Http\Controllers\PaymentChoicesController;
use App\Http\Controllers\KWYCController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    echo "Go to <a href='/proceed/JN-AGM-HLDUS-GRN'>proceed</a>"; 
});

// Route::middleware('auth', 'verified')->group(function (){
// });
// Route::get('/dashboard', [\App\Http\Controllers\LoanCalculatorController::class, 'dashboard'])->name('dashboard');
Route::get('/loan-calculation', [\App\Http\Controllers\LoanCalculatorController::class, 'calculate_loan'])->name('calculate.loan');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/proceed/{sku}', [ProceedController::class, 'index'])->name('proceed'); // Step 1

Route::get('/kwyc-verify', [KWYCController::class, 'index'])->name('kwyc.verify'); // Step 2

Route::get('/client-info', [ClientInformationController::class, 'index'])->name('client.info'); // Step 3

Route::get('/payment-choices', [PaymentChoicesController::class, 'index'])->name('payment.choices'); // Step 3
Route::get('/payment-choices/credit-debit-card', [PaymentChoicesController::class, 'credit_debit_card_payment'])->name('payment.card'); 

Route::get('/details', function () {
    return Inertia::render('Details');
});

Route::get('/payments', function () {
    return Inertia::render('PaymentDetails');
});

Route::get('/creditdetails', function () {
    return Inertia::render('CreditCard');
});

Route::get('/paymentsuccessful', function () {
    return Inertia::render('PaymentSuccessful');
});

Route::get('/test', [\App\Http\Controllers\LoanCalculatorController::class, 'test'])->name('test');

//
//Route::get('/client-information', \App\Livewire\ClientInformationSheet::class)->name('client-information');

Route::get('/client-information', [\App\Http\Controllers\ClientInformationController::class, 'show'])->name('client-information.show');
Route::post('/client-information/store', [\App\Http\Controllers\ClientInformationController::class, 'store'])->name('client-information.store');


require __DIR__.'/auth.php';
