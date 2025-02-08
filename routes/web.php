<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\HitungController;
use App\Http\Controllers\MunaqosahController;
use App\Http\Controllers\ClassifiactionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ------------------ Auth -------------------------
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// ------------------ Santri -----------------------
Route::middleware(['auth', 'santri'])->group(function () {
    Route::get('/santri/dashboard', [SantriController::class, 'dashboard'])
        ->name('dashboardSantri');
    Route::get('/santri/counting', [HitungController::class, 'showCounting'])
        ->name('countingSantri');
    Route::post('/santri/counting', [HitungController::class, 'processCounting'])
        ->name('countingSantri.post');
    Route::get('/santri/history', [HitungController::class, 'history'])
        ->name('historySantri');
    Route::get('/santri/profil', [SantriController::class, 'showProfile'])
        ->name('profilSantri');
    Route::post('/santri/profil', [SantriController::class, 'updateProfile'])
        ->name('profilSantri.update');
    Route::delete('/santri/riwayat/{id}', [MunaqosahController::class, 'destroy'])
        ->name('riwayat.destroy');
    Route::post('/santri/riwayat/{id}/send', [MunaqosahController::class, 'send'])
        ->name('riwayat.send');
});



// ------------------ Admin ------------------------
Route::middleware(['auth', 'admin'])->group(function () {
    // Semua route khusus Admin
    Route::get('/admin/add', [AdminController::class, 'index'])->name('admin.add');
    Route::post('/admin/add', [AdminController::class, 'store'])->name('admin.store');
    Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::get('/admin/santri', [AdminController::class, 'showSantri'])->name('santri.add');
    Route::delete('/admin/santri/{id}', [AdminController::class, 'destroySantri'])->name('santri.delete');
    Route::get('/admin/changePassword', [AdminController::class, 'showChangePassword'])
        ->name('changePassword');
    Route::post('/admin/changePassword', [AdminController::class, 'changePassword'])
        ->name('changePassword.post');
    Route::get('/admin/dataMunqosah', [MunaqosahController::class, 'showMunaqosah'])
        ->name('dataMunaqosah');
    Route::get('/admin/dashboardAdmin', [AdminController::class, 'dashboard'])
        ->name('dashboardAdmin');
    Route::post('/admin/munaqosah/{id}/verify', [MunaqosahController::class, 'verify'])
        ->name('munaqosah.verify');
    Route::post('/admin/munaqosah/{id}/reject', [MunaqosahController::class, 'reject'])
        ->name('munaqosah.reject');
    Route::delete('/admin/munaqosah/{id}', [MunaqosahController::class, 'destroy'])
        ->name('munaqosah.destroy');
    Route::get('/admin/examData', [ClassifiactionController::class, 'examData'])
        ->name('examData');
    Route::get('/admin/trainData', [ClassifiactionController::class, 'trainData'])
        ->name('trainData');
    Route::get('/admin/classificationResult', [ClassifiactionController::class, 'classificationResult'])
        ->name('classificationResult');
});
