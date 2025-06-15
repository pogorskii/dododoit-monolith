<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('todos/{todo}/toggle-status', [TodoController::class, 'toggleStatus'])->name('todos.toggle-status');
    Route::resource('todos', TodoController::class);
});

require __DIR__.'/auth.php';
