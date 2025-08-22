<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| This file defines all the application routes for web requests.
| Routes are grouped and protected using middleware where necessary.
|--------------------------------------------------------------------------
*/

// 🔹 Default route redirects to login page
Route::get('/', function () {
    return redirect()->route('login');
});

/* ===========================
   USER REGISTRATION ROUTES
=========================== */
Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

/* ===========================
   LOGIN & LOGOUT ROUTES
=========================== */
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/* ===========================
   DASHBOARD ROUTE (Protected)
=========================== */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

/* ===========================
   PROTECTED ROUTES
=========================== */
Route::middleware('auth')->group(function () {

    // 🔹 Customer Routes
    Route::resource('customers', CustomerController::class)->except(['show']);

    // 🔹 Room Routes
    Route::resource('rooms', RoomController::class)->except(['show']);

    // 🔹 Booking Routes (Include show route so "View" button works)
    Route::resource('bookings', BookingController::class);

    // 🔹 Extra delete routes for uploaded ID files
    Route::delete('/bookings/{booking}/delete-front/{index}', [BookingController::class, 'deleteFront'])
        ->name('bookings.deleteFront');
    Route::delete('/bookings/{booking}/delete-back/{index}', [BookingController::class, 'deleteBack'])
        ->name('bookings.deleteBack');

});
