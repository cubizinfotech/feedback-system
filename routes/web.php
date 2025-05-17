<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Public routes
Route::get('/feedback/{customerId}/{rating}', [FeedbackController::class, 'showFeedbackForm'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Customers
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers', 'index')->name('customers.index');
        Route::get('/customers/data', 'getCustomers')->name('customers.data');
        Route::post('/customers', 'store')->name('customers.store');
        Route::put('/customers/{customer}', 'update')->name('customers.update');
        Route::delete('/customers/{customer}', 'destroy')->name('customers.destroy');
        Route::post('/customers/{customer}/send-feedback', 'sendFeedbackMail')->name('customers.send-feedback');
    });

    // Feedbacks
    Route::controller(FeedbackController::class)->group(function () {
        Route::get('/feedbacks', 'index')->name('feedbacks.index');
        Route::get('/feedbacks/data', 'getFeedbacks')->name('feedbacks.data');
    });
});

require __DIR__.'/auth.php';
