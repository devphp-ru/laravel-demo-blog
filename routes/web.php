<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:admin'])->prefix('/admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.handler');
});

Route::middleware(['admin.auth:admin', 'admin.banned:admin'])->prefix('/admin')->group(function () {
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.user.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    /** Resource */
    Route::resource('/admin-users', AdminUserController::class)->except('show');
});
