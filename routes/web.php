<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SptController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PenandatanganController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
route::get('/dashboard/detail/{id}', [DashboardController::class, 'detail'])->middleware(['auth'])->name('dashboard.detail');


Route::get('/create', [SptController::class, 'create'])->middleware(['auth']);

Route::get('/list', [SptController::class, 'index'])->middleware(['auth'])->name('spt.index');

Route::get('/upload', [SptController::class, 'uploadForm'])->middleware(['auth'])->name('spt.upload');
Route::post('/upload', [SptController::class, 'uploadSurat'])->middleware(['auth'])->name('spt.upload.submit');

Route::get('/detailspt', function () {
    return view('admin.detailSpt');
});

// Tampilkan form edit
Route::get('/admin/spt/{id}/edit', [SptController::class, 'edit'])->name('spt.edit');

// Proses update data
Route::put('/admin/spt/{id}', [SptController::class, 'update'])->name('spt.update');

Route::delete('/spt/{id}', [SptController::class, 'destroy'])->name('spt.destroy');

Route::resource('spt', SptController::class);


// superadmin lihat semua SPT
Route::get('/viewSpt', [SuperAdminController::class, 'index'])->name('superadmin.viewSpt.index');
Route::get('/request', [SuperAdminController::class, 'requestIndex'])->name('superadmin.request.requestIndex');
Route::get('/superadmin/spt/{id}/preview', [App\Http\Controllers\SuperAdminController::class, 'preview'])->name('superadmin.spt.preview');
Route::get('/superadmin/spt/{id}/export-word', [App\Http\Controllers\SuperAdminController::class, 'exportWord'])->name('superadmin.spt.exportWord');

// superadmin request approval spt
// Route::get('/spt/{id}/preview', [SuperAdminController::class, 'preview'])->name('spt.show');
Route::post('/spt/{id}/approve', [SuperAdminController::class, 'approve'])
    ->name('spt.approve');
Route::post('/spt/{id}/reject', [SuperAdminController::class, 'reject'])
    ->name('spt.reject');

// superadmin buat new acc admin
Route::get('/account', function () {
    return view('superadmin.account');
});

Route::middleware('superadmin')->group(function () {
    Route::get('/superadmin/account', [SuperAdminController::class, 'create'])->name('superadmin.account');
    Route::post('/superadmin/account', [SuperAdminController::class, 'store'])->name('superadmin.registerAdmin');
});

// superadmin penandatangan
Route::post('/spt/{id}/set-signer', [SuperAdminController::class, 'setSigner'])->name('superadmin.request.setSigner');

//download dole admin utk spt disetujui
Route::get('/spt/{id}/download', [SptController::class, 'download'])->name('spt.download');

// download list SPT format PDF
Route::get('/spt/download/all', [SptController::class, 'downloadAll'])->name('spt.downloadAll');


Route::get('/detailreport', function () {
    return view('admin.detailReport');
});

Route::get('/editreport', function () {
    return view('admin.editReport');
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
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');

Route::get('/report', [ReportController::class, 'create'])->name('report.create');
Route::post('/report', [ReportController::class, 'store'])->name('report.store');
Route::get('/view', [ReportController::class, 'index'])->name('report.index');
Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('report.destroy');
Route::get('/report/{id}', [App\Http\Controllers\ReportController::class, 'show'])->name('report.show');
Route::get('/report/{id}/edit', [ReportController::class, 'edit'])->name('report.edit');
Route::put('/report/{id}', [ReportController::class, 'update'])->name('report.update');
Route::get('/report/download/{folder}/{filename}', [ReportController::class, 'download'])->name('report.download');
Route::get('/report/{id}/export-word', [ReportController::class, 'exportWord'])->name('report.exportWord');

Route::prefix('penandatangan')->name('penandatangan.')->group(function () {
    Route::get('/', [PenandatanganController::class, 'index'])->name('index');
    Route::get('/create', [PenandatanganController::class, 'create'])->name('create');
    Route::post('/store', [PenandatanganController::class, 'store'])->name('store');
    Route::delete('/{id}', [PenandatanganController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';

