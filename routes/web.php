<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\testController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/page', [UserController::class, 'page'])->name('page');

Route::get('/page', function () {
    return view('app');
});

Route::get('auth/google', [testController::class, 'redirectToGoogle']);
Route::get('callback/google', [testController::class, 'handleCallback']);