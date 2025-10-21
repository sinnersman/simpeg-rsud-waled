<?php

use App\Http\Controllers\DependentDropdownController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
    Route::middleware(['superadmin'])->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::post('/pegawai/{pegawai}/create-account', [PegawaiController::class, 'createAccount'])->name('pegawai.createAccount');
        Route::get('/pegawai/{id}/pdf', [PegawaiController::class, 'generatePDF'])->name('pegawai.pdf');

        // Admin Approvals
        Route::get('/admin/approvals', [\App\Http\Controllers\AdminApprovalController::class, 'index'])->name('admin.approvals.index');
        Route::patch('/admin/approvals/{changeRequest}/approve', [\App\Http\Controllers\AdminApprovalController::class, 'approve'])->name('admin.approvals.approve');
        Route::patch('/admin/approvals/{changeRequest}/reject', [\App\Http\Controllers\AdminApprovalController::class, 'reject'])->name('admin.approvals.reject');
    });

    Route::get('/my-biodata', [PegawaiController::class, 'myBiodataEdit'])->name('pegawai.myBiodataEdit');
    Route::patch('/my-biodata', [PegawaiController::class, 'myBiodataUpdate'])->name('pegawai.myBiodataUpdate');
    Route::post('/my-biodata', [PegawaiController::class, 'myBiodataStore'])->name('pegawai.myBiodataStore');

    // Dokumen Karyawan
    Route::resource('dokumen-karyawan', \App\Http\Controllers\DokumenKaryawanController::class);

    // Master Jabatan
    Route::get('jabatan/trash', [\App\Http\Controllers\JabatanController::class, 'trash'])->name('jabatan.trash');
    Route::get('jabatan/{id}/restore', [\App\Http\Controllers\JabatanController::class, 'restore'])->name('jabatan.restore');
    Route::delete('jabatan/{id}/force-delete', [\App\Http\Controllers\JabatanController::class, 'forceDelete'])->name('jabatan.forceDelete');
    Route::get('jabatan/download-template', [\App\Http\Controllers\JabatanController::class, 'downloadTemplate'])->name('jabatan.downloadTemplate');
    Route::post('jabatan/import-excel', [\App\Http\Controllers\JabatanController::class, 'importExcel'])->name('jabatan.importExcel');
    Route::resource('jabatan', \App\Http\Controllers\JabatanController::class)->except(['show']);

    // Master Induk Unit Kerja
    Route::get('induk_unit_kerja/trash', [\App\Http\Controllers\IndukUnitKerjaController::class, 'trash'])->name('induk_unit_kerja.trash');
    Route::get('induk_unit_kerja/{id}/restore', [\App\Http\Controllers\IndukUnitKerjaController::class, 'restore'])->name('induk_unit_kerja.restore');
    Route::delete('induk_unit_kerja/{id}/force-delete', [\App\Http\Controllers\IndukUnitKerjaController::class, 'forceDelete'])->name('induk_unit_kerja.forceDelete');
    Route::post('induk_unit_kerja/import', [\App\Http\Controllers\IndukUnitKerjaController::class, 'import'])->name('induk_unit_kerja.import');
    Route::get('induk_unit_kerja/download-template', [\App\Http\Controllers\IndukUnitKerjaController::class, 'downloadTemplate'])->name('induk_unit_kerja.downloadTemplate');
    Route::resource('induk_unit_kerja', \App\Http\Controllers\IndukUnitKerjaController::class)->except(['show']);

    // Master Unit Kerja
    Route::get('unit_kerja/trash', [\App\Http\Controllers\UnitKerjaController::class, 'trash'])->name('unit_kerja.trash');
    Route::get('unit_kerja/{id}/restore', [\App\Http\Controllers\UnitKerjaController::class, 'restore'])->name('unit_kerja.restore');
    Route::delete('unit_kerja/{id}/force-delete', [\App\Http\Controllers\UnitKerjaController::class, 'forceDelete'])->name('unit_kerja.forceDelete');
    Route::post('unit_kerja/import', [\App\Http\Controllers\UnitKerjaController::class, 'import'])->name('unit_kerja.import');
    Route::get('unit_kerja/download-template', [\App\Http\Controllers\UnitKerjaController::class, 'downloadTemplate'])->name('unit_kerja.downloadTemplate');
    Route::resource('unit_kerja', \App\Http\Controllers\UnitKerjaController::class)->except(['show']);

    // Master Role
    Route::post('roles/import', [\App\Http\Controllers\RoleController::class, 'import'])->name('roles.import');
    Route::get('roles/download-template', [\App\Http\Controllers\RoleController::class, 'downloadTemplate'])->name('roles.downloadTemplate');
    Route::resource('roles', RoleController::class)->except(['show']);

    // User Management
    Route::resource('users', UserController::class);
    Route::post('users/generate-pegawai-account', [UserController::class, 'generatePegawaiAccount'])->name('users.generatePegawaiAccount');
    Route::patch('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
    Route::patch('users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

    Route::get('/settings', [\App\Http\Controllers\DashboardController::class, 'settings'])->name('settings.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
