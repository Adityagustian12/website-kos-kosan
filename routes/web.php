<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes (No Authentication Required)
Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/rooms/{room}', [PublicController::class, 'roomDetail'])->name('public.room.detail');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('refresh.csrf');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Storage file access route
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $mimeType = mime_content_type($filePath);
    
    return response()->file($filePath, [
        'Content-Type' => $mimeType,
    ]);
})->where('path', '.*')->name('storage.file');

// Protected Routes (Authentication Required)
Route::middleware('auth')->group(function () {
    
    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    // Booking Routes (for authenticated users)
    Route::get('/rooms/{room}/booking', [PublicController::class, 'showBookingForm'])->name('booking.form');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/payment-proof', [BookingController::class, 'uploadPaymentProof'])->name('bookings.payment-proof');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // Seeker Routes
    Route::middleware('role:seeker')->prefix('seeker')->name('seeker.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Seeker\DashboardController::class, 'index'])->name('dashboard');
    });

    // Tenant Routes
    Route::middleware('role:tenant')->prefix('tenant')->name('tenant.')->group(function () {
        Route::get('/dashboard', [TenantDashboardController::class, 'index'])->name('dashboard');
        
        // Bills Management
        Route::get('/bills', [TenantDashboardController::class, 'bills'])->name('bills');
        Route::get('/bills/{bill}', [TenantDashboardController::class, 'billDetail'])->name('bills.detail');
        Route::get('/bills/{bill}/payment', [TenantDashboardController::class, 'showPaymentForm'])->name('bills.payment');
        Route::post('/bills/{bill}/payment', [TenantDashboardController::class, 'processPayment'])->name('bills.payment.store');
        
        // Complaints Management
        Route::get('/complaints', [TenantDashboardController::class, 'complaints'])->name('complaints');
        Route::get('/complaints/create', [TenantDashboardController::class, 'showComplaintForm'])->name('complaints.create');
        Route::post('/complaints', [TenantDashboardController::class, 'submitComplaint'])->name('complaints.store');
        Route::get('/complaints/{complaint}', [TenantDashboardController::class, 'complaintDetail'])->name('complaints.detail');
        
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Rooms Management
        Route::get('/rooms', [AdminDashboardController::class, 'rooms'])->name('rooms');
        Route::post('/rooms', [AdminDashboardController::class, 'storeRoom'])->name('rooms.store');
        Route::get('/rooms/{room}', [AdminDashboardController::class, 'roomDetail'])->name('room.detail');
        Route::put('/rooms/{room}', [AdminDashboardController::class, 'updateRoom'])->name('rooms.update');
        Route::delete('/rooms/{room}', [AdminDashboardController::class, 'deleteRoom'])->name('rooms.delete');
        Route::post('/rooms/{room}/duplicate', [AdminDashboardController::class, 'duplicateRoom'])->name('rooms.duplicate');
        Route::post('/rooms/{room}/vacate', [AdminDashboardController::class, 'vacateRoom'])->name('rooms.vacate');
        Route::put('/rooms/{room}/status', [AdminDashboardController::class, 'updateRoomStatus'])->name('rooms.status');
        
        // Bookings Management
        Route::get('/bookings', [AdminDashboardController::class, 'bookings'])->name('bookings');
        Route::get('/bookings/{booking}', [AdminDashboardController::class, 'bookingDetail'])->name('bookings.detail');
        Route::post('/bookings/{booking}/confirm', [AdminDashboardController::class, 'confirmBooking'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/move-in', [AdminDashboardController::class, 'moveIntoRoom'])->name('bookings.move-in');
        Route::post('/bookings/{booking}/reject', [AdminDashboardController::class, 'rejectBooking'])->name('bookings.reject');
        Route::post('/bookings/{booking}/complete', [AdminDashboardController::class, 'completeBooking'])->name('bookings.complete');
        
        // Bills Management
        Route::get('/bills', [AdminDashboardController::class, 'bills'])->name('bills');
        Route::get('/bills/create', [AdminDashboardController::class, 'showCreateBillForm'])->name('bills.create');
        Route::post('/bills', [AdminDashboardController::class, 'createBill'])->name('bills.store');
        Route::get('/bills/{bill}', [AdminDashboardController::class, 'billDetail'])->name('bills.detail');
        Route::delete('/bills/{bill}', [AdminDashboardController::class, 'deleteBill'])->name('bills.delete');
        
        // Payments Management
        Route::get('/payments', [AdminDashboardController::class, 'payments'])->name('payments');
        Route::get('/payments/{payment}', [AdminDashboardController::class, 'paymentDetail'])->name('payments.detail');
        Route::post('/payments/{payment}/verify', [AdminDashboardController::class, 'verifyPayment'])->name('payments.verify');
        
        // Complaints Management
        Route::get('/complaints', [AdminDashboardController::class, 'complaints'])->name('complaints');
        Route::get('/complaints/{complaint}', [AdminDashboardController::class, 'complaintDetail'])->name('complaints.detail');
        Route::put('/complaints/{complaint}/status', [AdminDashboardController::class, 'updateComplaintStatus'])->name('complaints.status');
        
        // Tenants Management
        Route::get('/tenants', [AdminDashboardController::class, 'tenants'])->name('tenants');
        Route::get('/tenants/{tenant}', [AdminDashboardController::class, 'tenantDetail'])->name('tenants.detail');
        Route::delete('/tenants/{tenant}/delete', [AdminDashboardController::class, 'deleteTenant'])->name('tenants.delete');
        
        // API Routes
        Route::get('/rooms-data', [AdminDashboardController::class, 'getRoomsData'])->name('rooms.data');
    });
});
