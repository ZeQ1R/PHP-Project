<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Doctor\DoctorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home/Welcome Page
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect('/admin/dashboard');
        } elseif ($user->isDoctor()) {
            return redirect('/doctor/dashboard');
        } else {
            return redirect('/patient/dashboard');
        }
    }
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Patient Routes
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    
    // Doctors
    Route::get('/doctors', [PatientController::class, 'doctors'])->name('doctors');
    
    // Appointments
    Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{id}', [PatientController::class, 'showAppointment'])->name('appointments.show');
    Route::get('/book-appointment/{doctorId}', [PatientController::class, 'showBooking'])->name('book-appointment');
    Route::post('/book-appointment', [PatientController::class, 'storeAppointment'])->name('store-appointment');
    Route::get('/appointments/{id}/edit', [PatientController::class, 'editAppointment'])->name('appointments.edit');
    Route::put('/appointments/{id}', [PatientController::class, 'updateAppointment'])->name('appointments.update');
    Route::post('/appointments/{id}/cancel', [PatientController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/available-slots/{doctorId}', [PatientController::class, 'getAvailableSlots'])->name('available-slots');
    
    // Profile
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
});

// Doctor Routes
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    
    // Appointments
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('appointments.show');
    Route::post('/appointments/{id}/accept', [DoctorController::class, 'acceptAppointment'])->name('appointments.accept');
    Route::post('/appointments/{id}/reject', [DoctorController::class, 'rejectAppointment'])->name('appointments.reject');
    Route::post('/appointments/{id}/complete', [DoctorController::class, 'completeAppointment'])->name('appointments.complete');
    
    // Availability
    Route::get('/availability', [DoctorController::class, 'availability'])->name('availability');
    Route::post('/availability', [DoctorController::class, 'storeAvailability'])->name('availability.store');
    Route::delete('/availability/{id}', [DoctorController::class, 'deleteAvailability'])->name('availability.delete');
    
    // Profile
    Route::get('/profile', [DoctorController::class, 'profile'])->name('profile');
    Route::put('/profile', [DoctorController::class, 'updateProfile'])->name('profile.update');
});

// Admin Routes (Optional - for future expansion)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});
