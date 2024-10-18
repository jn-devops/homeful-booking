<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProceedController;
use App\Http\Controllers\ClientInformationController;
use App\Http\Controllers\FilePondController;
use App\Http\Controllers\GetQualifiedController;
use App\Http\Controllers\PaymentChoicesController;
use App\Http\Controllers\KWYCController;
use App\Http\Controllers\BookingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    echo "Go to <a href='/proceed/JN-AGM-HLDUS-GRN'>proceed</a>";
//});

// Route::middleware('auth', 'verified')->group(function (){
// });
// Route::get('/dashboard', [\App\Http\Controllers\LoanCalculatorController::class, 'dashboard'])->name('dashboard');
Route::get('/loan-calculation', [\App\Http\Controllers\LoanCalculatorController::class, 'calculate_loan'])->name('calculate.loan');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//
//// Initial page to show before entry point
//Route::get('/welcome/{sku}/{code}', [BookingController::class, 'index'])->name('initial.entry.point');


// Consult / SKU / Optional Promo(Affiliate) or Seller Code
Route::get('/consult/{sku}/{code}', [BookingController::class, 'index']);

Route::get('/proceed/{reference_code}', [BookingController::class, 'step_one'])->name('proceed'); // Step 1

Route::get('/kwyc-verify/{sku}/{code}', [BookingController::class, 'step_two'])->name('kwyc.verify'); // Step 2

// Route::get('/client-info/{kwyc_code}', [ClientInformationController::class, 'show'])->name('client.info'); // Step 3

Route::get('/payment-choices/{kwyc_code}', [BookingController::class, 'step_four'])->name('payment.choices'); // Step 4
Route::get('/payment-choices/credit-debit-card/{kwyc_code}', [BookingController::class, 'credit_debit_card_payment'])->name('payment.card');


Route::get('/payment-choices/wallet/pay/{kwyc_code}', [BookingController::class, 'digitalWalletPayment'])->name('payment.digitalWalletPayment');
Route::get('/payment-choices/qr/pay/{kwyc_code}', [BookingController::class, 'qrPayment'])->name('payment.qrPayment');
Route::get('/payment-choices/card/pay/{kwyc_code}', [BookingController::class, 'cardPayment'])->name('payment.cardPayment');


Route::get('/get-qualified/{kwyc_code}', [BookingController::class, 'step_five'])->name('get.qualified'); // Step 5

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

Route::post('/file-pond/upload', [FilePondController::class, 'upload']);
Route::delete('/file-pond/revert', [FilePondController::class, 'revert']);

Route::get('/client-info/{kwyc_code}', [BookingController::class, 'step_three'])->name('client-information.clienInfoLanding');
Route::get('/client-information/{kwyc_code}', [BookingController::class, 'client_info_show'])->name('client-information.show');
Route::post('/client-information/store/{kwyc_code}', [BookingController::class, 'client_info_store'])->name('client-information.store');

Route::get('/kwyc/signup/{sku}/{code}', [BookingController::class, 'sign_up'])->name('client-information.clienInfoLanding');


require __DIR__.'/auth.php';
