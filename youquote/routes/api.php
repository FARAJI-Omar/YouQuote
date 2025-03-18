<?php

use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth/register', [UserController::class, 'register']);
Route::post('/auth/login', [UserController::class, 'login']);


Route::get('/quotes/random', [QuoteController::class, 'random']);
Route::get('/quotes/filter', [QuoteController::class, 'filter']);
Route::get('/quotes/popular', [QuoteController::class, 'popular']);


Route::apiResource('quotes', QuoteController::class);


Route::middleware('auth:sanctum')->group(function() {
    Route::post('/auth/logout', [UserController::class, 'logout']);
});

