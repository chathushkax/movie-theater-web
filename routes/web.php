<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/showtimes/{movie}', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/getMovies', [MovieController::class, 'addMoviesToDatabase']);
Route::get('/search', [MovieController::class, 'search'])->name('search');


// Authentication routes
Auth::routes();

// Routes that require authentication
Route::middleware(['auth'])->group(function () {
    Route::post('/bookings/{showtime}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking-process', [BookingController::class, 'bookingSeats'])->name('bookings.bookingSeats');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

// Admin routes that require both authentication and admin role
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/confirm/{id}', [AdminController::class, 'confirm'])->name('admin.confirm');
    Route::post('/admin/cancel/{id}', [AdminController::class, 'cancel'])->name('admin.cancel');
});
