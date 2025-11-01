<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TasksControlller;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// Routes protected by Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/my-tasks', [TasksControlller::class, 'index']);
});
