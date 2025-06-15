<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

// Redirect root based on auth status
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('student.index')
        : redirect()->route('login');
})->middleware('web');

// Guest routes
Route::middleware(['web', 'guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    // ✅ Register Routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Authenticated routes
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/students', [StudentController::class, 'index'])->name('student.index');
    Route::post('/students', [StudentController::class, 'store'])->name('student.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
});
