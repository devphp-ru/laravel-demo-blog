<?php

use App\Http\Controllers\Api\V1\ChangeStatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ArticleCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::put('/change-status', ChangeStatusController::class);
Route::delete('/delete-comment', [ArticleCommentController::class, 'deleteComment']);
