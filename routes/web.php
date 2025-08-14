<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SptController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/create', [SptController::class, 'create'])->middleware(['auth']);

Route::get('/list', [SptController::class, 'index'])->middleware(['auth'])->name('spt.index');

Route::get('/upload', [SptController::class, 'uploadForm'])->middleware(['auth'])->name('spt.upload');
Route::post('/upload', [SptController::class, 'uploadSurat'])->middleware(['auth'])->name('spt.upload.submit');

Route::get('/report', function () {
    return view('admin.inputReport');
});

Route::get('/view', function () {
    return view('admin.viewReport');
});

Route::get('/detailspt', function () {
    return view('admin.detailSpt');
});

// Tampilkan form edit
Route::get('/admin/spt/{id}/edit', [SptController::class, 'edit'])->name('spt.edit');

// Proses update data
Route::put('/admin/spt/{id}', [SptController::class, 'update'])->name('spt.update');

Route::delete('/spt/{id}', [SptController::class, 'destroy'])->name('spt.destroy');

Route::resource('spt', SptController::class);


Route::get('/detailreport', function () {
    return view('admin.detailReport');
});

Route::get('/editreport', function () {
    return view('admin.editReport');
});

Route::get('/request', function () {
    return view('superadmin.request');
});

Route::get('/viewSpt', function () {
    return view('superadmin.viewSpt');
});

Route::get('/account', function () {
    return view('superadmin.account');
});

    Route::middleware('superadmin')->group(function () {
        Route::get('/superadmin/account', [SuperAdminController::class, 'create'])
            ->name('superadmin.account');
        Route::post('/superadmin/account', [SuperAdminController::class, 'store'])
            ->name('superadmin.registerAdmin');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('spt', SptController::class)->middleware(['auth']);
Route::get('/spt/create', [SptController::class, 'create'])->name('spt.create');
Route::post('/spt', [SptController::class, 'store'])->name('spt.store');
Route::get('/spt', [SptController::class, 'index'])->name('spt.index');
Route::get('/spt/{id}', [SptController::class, 'show'])->name('spt.show');
Route::get('/spt/{id}/download', [SptController::class, 'download'])->name('spt.download');

Route::resource('/pegawai', PegawaiController::class);
Route::resource('/pegawai', PegawaiController::class)->middleware(['auth']);
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/add', [PegawaiController::class, 'create'])->name('pegawai.add');
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

Route::get('/report', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/view', [ReportController::class, 'index'])->name('report.index');
Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('report.destroy');

require __DIR__.'/auth.php';

