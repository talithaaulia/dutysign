<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SptController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/create', function () {
    return view('admin.create');
});

Route::get('/list', function () {
    return view('admin.list');
});

Route::get('/upload', function () {
    return view('admin.upload');
});

Route::get('/report', function () {
    return view('admin.inputReport');
});

Route::get('/view', function () {
    return view('admin.viewReport');
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

Route::get('/detailspt', function () {
    return view('admin.detailSpt');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/spt', [SptController::class, 'store'])->name('spt.store');

require __DIR__.'/auth.php';
