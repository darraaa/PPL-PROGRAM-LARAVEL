<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AddressController;

// User routes
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::get('/user/{id}', [UserController::class, 'get']);
    Route::post('/user/logout', [UserController::class, 'logout']);
});

// Contact routes
Route::middleware('auth:api')->group(function () {
    Route::post('/contact', [ContactController::class, 'create']);
    Route::put('/contact/{id}', [ContactController::class, 'update']);
    Route::get('/contact/{id}', [ContactController::class, 'get']);
    Route::get('/contact/search', [ContactController::class, 'search']);
    Route::delete('/contact/{id}', [ContactController::class, 'remove']);
});

// Address routes
Route::middleware('auth:api')->group(function () {
    Route::post('/address', [AddressController::class, 'create']);
    Route::put('/address/{id}', [AddressController::class, 'update']);
    Route::get('/address/{id}', [AddressController::class, 'get']);
    Route::get('/address', [AddressController::class, 'list']);
    Route::delete('/address/{id}', [AddressController::class, 'remove']);
});
