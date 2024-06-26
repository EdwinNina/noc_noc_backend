<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

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

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/update-password', [AuthController::class, 'updatePassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/tasks/get-all', [TaskController::class, 'getAllTasks']);
    Route::put('/tasks/update-status/{task}', [TaskController::class, 'updateStatus']);
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('users', UserController::class);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/task/{task_id}', [CommentController::class, 'getCommentsByTask']);
    Route::post('/files', [FileController::class, 'store']);
    Route::get('/files/task/{task_id}', [FileController::class, 'getFilesByTask']);
    Route::delete('/files/{file}', [FileController::class, 'delete']);
    Route::post('/reports', [ReportController::class, 'generatePdf']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
