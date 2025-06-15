<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'create'])->name('student.create');
Route::post('/students', [StudentController::class, 'store'])->name('student.store');
