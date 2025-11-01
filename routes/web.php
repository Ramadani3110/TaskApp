<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Task\ListTask;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['guest.redirect']], function () {
    Route::get('/', Login::class)->name('login');
    Route::get('/signup', Register::class)->name('register');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('/my-tasks', ListTask::class)->name('my-tasks')->middleware('auth');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});