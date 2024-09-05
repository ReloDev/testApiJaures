<?php

use App\Http\Controllers\testController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\FileController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('users')->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/addUserFile/{code}', [FileController::class, 'addUserFile']);
});


    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', [UserController::class, 'userAuth']);
        Route::prefix('users')->group(function () {
            
        });
    });


   






    // Route::get('/a', [testController::class, 'a']);
