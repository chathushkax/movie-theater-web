<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/showtimes/{movie}', [ShowtimeController::class, 'index'])->name('showtimes.index');
Route::get('/getMovies', [MovieController::class, 'addMoviesToDatabase']);
Route::get('/search', [MovieController::class, 'search'])->name('search');

// Authentication routes
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/confirm/{id}', [AdminController::class, 'confirm'])->name('admin.bookings.confirm');
    Route::post('/admin/cancel/{id}', [AdminController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::put('bookings/{booking}', [AdminController::class, 'modify'])->name('admin.bookings.modify');
    Route::post('movies/store', [AdminController::class, 'storeMovie'])->name('admin.movies.store');
    Route::get('/add/movies', [AdminController::class, 'addMovie'])->name('admin.movies.create');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/staff', function () {
        // Staff routes
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/bookings/{showtime}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking-process/{id}', [BookingController::class, 'bookingSeats'])->name('bookings.bookingSeats');
    Route::post('/book-tickets', [BookingController::class, 'bookTickets']);
    Route::get('/get-showtime-details/{showtime_id}', [BookingController::class, 'getShowtimeDetails']);
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/chat/messages', [QuestionController::class, 'index']);
    Route::post('/chat/messages', [QuestionController::class, 'store']);
});


