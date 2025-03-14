<?php

use App\Http\Controllers\Api\QuoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/quotes/random', [QuoteController::class, 'random']);

Route::get('/quotes/filter', [QuoteController::class, 'filter']);

Route::get('/quotes/popular', [QuoteController::class, 'popular']);

Route::apiResource('quotes', QuoteController::class);





// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
