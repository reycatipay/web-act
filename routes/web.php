<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

// Apply web middleware group to all routes
Route::middleware(['web'])->group(function () {
    // Redirect root to login
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Guest routes (accessible without authentication)
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    });

    // Protected routes (require authentication)
    Route::middleware(['auth'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Student routes
        Route::get('/students', [StudentController::class, 'index'])->name('student.index');
        Route::post('/students', [StudentController::class, 'store'])->name('student.store');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('student.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');
    });
});
