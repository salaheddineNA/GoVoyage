<?php

use App\Http\Controllers\FlightController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[FlightController::class,'home'])->name('home');

Route::get('/special-offer',[FlightController::class,'offer'])->name('offer');

Route::get('/support',[FlightController::class,'supportpage'])->name('support');

Route::post('/contact',[FlightController::class,'contactSubmit'])->name('contact.submit');

// User authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

// Booking routes
Route::get('/bookings/create/{flightId}', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings/store/{flightId}', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/confirmation/{bookingId}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
Route::get('/bookings/download/{bookingId}', [BookingController::class, 'download'])->name('bookings.download');
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
Route::post('/bookings/{bookingId}/cancel', [BookingController::class, 'userCancelBooking'])->name('bookings.user.cancel');

Route::get('/admin',[FlightController::class,'admin'])->name('admin');
Route::get('/admin/statistics',[FlightController::class,'statistics'])->name('admin.statistics');

Route::get('/flights', [FlightController::class, 'index'])->name('flight');

Route::get('/flights/{id}/edit', [FlightController::class, 'edit'])->name('flights.edit');
Route::put('/flights/{id}', [FlightController::class, 'update'])->name('flights.update');
Route::delete('/flights/{id}', [FlightController::class, 'destroy'])->name('flights.destroy');

// Admin authentication routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected admin routes
Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [FlightController::class, 'dashboard'])->name('dashboard');
    
    // Contact management routes
    Route::get('/admin/contacts', [FlightController::class, 'contacts'])->name('admin.contacts');
    Route::post('/admin/contact/{id}/read', [FlightController::class, 'markContactAsRead'])->name('admin.contact.read');
    Route::post('/admin/contact/{id}/resolved', [FlightController::class, 'markContactAsResolved'])->name('admin.contact.resolved');
    Route::delete('/admin/contact/{id}', [FlightController::class, 'deleteContact'])->name('admin.contact.delete');
    
    // Admin bookings routes
    Route::get('/admin/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings');
    Route::post('/admin/bookings/{bookingId}/confirm', [BookingController::class, 'confirmBooking'])->name('admin.bookings.confirm');
    Route::post('/admin/bookings/{bookingId}/cancel', [BookingController::class, 'cancelBooking'])->name('admin.bookings.cancel');
    Route::get('/admin/bookings/{bookingId}', [BookingController::class, 'showBooking'])->name('admin.bookings.show');
    
    // Admin flights routes
    Route::get('/admin/flights', [FlightController::class, 'adminFlights'])->name('admin.flights');
    Route::get('/admin/flights/create', [FlightController::class, 'adminCreateFlight'])->name('admin.flights.create');
    
    Route::post('/storeticket', [FlightController::class, 'store'])->name('flights.store');
    
    // Admin profile management
    Route::get('/admin/profile', [AdminAuthController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminAuthController::class, 'updateProfile'])->name('admin.profile.update');
    Route::post('/admin/add', [AdminAuthController::class, 'addAdmin'])->name('admin.add');
    Route::delete('/admin/{id}', [AdminAuthController::class, 'deleteAdmin'])->name('admin.delete');
});
