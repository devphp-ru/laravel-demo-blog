<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ArticleController;

Route::middleware(['guest:admin'])->prefix('/admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.handler');
});

Route::middleware(['admin.auth:admin', 'admin.banned:admin'])->prefix('/admin')->group(function () {
    /** Resource */
    Route::resource('/admin-users', AdminUserController::class)->except('show');
    Route::resource('/users', UserController::class)->except('show');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/tags', TagController::class);
    Route::resource('/articles', ArticleController::class);
    /** Custom */
    Route::get('/article-comments', [DashboardController::class, 'articleComments'])->name('admin.article.comments');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.user.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
});
