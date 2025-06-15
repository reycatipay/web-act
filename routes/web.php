<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'index'])->name('student.index');

Route::post('/students', [StudentController::class, 'store'])->name('student.store');
Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
Route::post('/students/{id}/update', [StudentController::class, 'update'])->name('student.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('student.destroy');


Route::get('/', function () {
    return redirect()->route('student.index');
});
