<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    // return view('welcome');
    // redirect()->route('login');
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    } else {
        return redirect()->route('login');
    }
});


Route::middleware('auth')->group(function () {
    Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
