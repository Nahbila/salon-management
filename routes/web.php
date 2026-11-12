<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ClientSpaceController;

Route::redirect('/', '/services');

// Public pages
Route::get('/services', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/book', [BookingController::class, 'create'])->name('booking.create');
Route::post('/book', [BookingController::class, 'store'])->name('booking.store');
Route::get('/book/{appointment}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/my-appointments', [ClientSpaceController::class, 'lookup'])->name('client.lookup');
Route::post('/my-appointments', [ClientSpaceController::class, 'find'])->name('client.find');
Route::get('/my-appointments/list', [ClientSpaceController::class, 'index'])->name('client.index');
Route::post('/my-appointments/{appointment}/cancel', [ClientSpaceController::class, 'cancel'])->name('client.cancel');
Route::post('/my-appointments/{appointment}/reschedule', [ClientSpaceController::class, 'reschedule'])->name('client.reschedule');
Route::post('/my-appointments/exit', [ClientSpaceController::class, 'exit'])->name('client.exit');
Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

// Admin auth (public, no login required to reach these)
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin area (protected, requires login)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
    Route::post('/appointments/{appointment}/update-status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
    Route::post('/appointments/{appointment}/mark-paid', [AppointmentController::class, 'markPaid'])->name('admin.appointments.markPaid');

    Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    Route::post('/services/{service}/reactivate', [ServiceController::class, 'reactivate'])->name('admin.services.reactivate');
});
