<?php

use App\Http\Controllers\DependentDropdownController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // return view('welcome');
    // redirect()->route('login');
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/provinces', [DependentDropdownController::class, 'provinces'])->name('provinces');
Route::get('/cities', [DependentDropdownController::class, 'cities'])->name('cities');
Route::get('/districts', [DependentDropdownController::class, 'districts'])->name('districts');
Route::get('/villages', [DependentDropdownController::class, 'villages'])->name('villages');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::post('/pegawai/{pegawai}/create-account', [PegawaiController::class, 'createAccount'])->name('pegawai.createAccount');
    Route::get('/pegawai/{id}/pdf', [PegawaiController::class, 'generatePDF'])->name('pegawai.pdf');

    // Master Jabatan
    Route::get('jabatan/trash', [\App\Http\Controllers\JabatanController::class, 'trash'])->name('jabatan.trash');
    Route::get('jabatan/{id}/restore', [\App\Http\Controllers\JabatanController::class, 'restore'])->name('jabatan.restore');
    Route::delete('jabatan/{id}/force-delete', [\App\Http\Controllers\JabatanController::class, 'forceDelete'])->name('jabatan.forceDelete');
    Route::resource('jabatan', \App\Http\Controllers\JabatanController::class)->except(['show']);

    // Master Induk Unit Kerja
    Route::get('induk_unit_kerja/trash', [\App\Http\Controllers\IndukUnitKerjaController::class, 'trash'])->name('induk_unit_kerja.trash');
    Route::get('induk_unit_kerja/{id}/restore', [\App\Http\Controllers\IndukUnitKerjaController::class, 'restore'])->name('induk_unit_kerja.restore');
    Route::delete('induk_unit_kerja/{id}/force-delete', [\App\Http\Controllers\IndukUnitKerjaController::class, 'forceDelete'])->name('induk_unit_kerja.forceDelete');
    Route::resource('induk_unit_kerja', \App\Http\Controllers\IndukUnitKerjaController::class)->except(['show']);

    // Master Unit Kerja
    Route::get('unit_kerja/trash', [\App\Http\Controllers\UnitKerjaController::class, 'trash'])->name('unit_kerja.trash');
    Route::get('unit_kerja/{id}/restore', [\App\Http\Controllers\UnitKerjaController::class, 'restore'])->name('unit_kerja.restore');
    Route::delete('unit_kerja/{id}/force-delete', [\App\Http\Controllers\UnitKerjaController::class, 'forceDelete'])->name('unit_kerja.forceDelete');
    Route::resource('unit_kerja', \App\Http\Controllers\UnitKerjaController::class)->except(['show']);

    Route::get('/settings', [\App\Http\Controllers\DashboardController::class, 'settings'])->name('settings.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
