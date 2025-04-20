<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;
use App\Http\Controllers\testController;



Route::get('/dialogflow', [DialogflowController::class, 'index']);
Route::post('/send-message', [DialogflowController::class, 'sendMessage']);
Route::post('/webhook', [DialogflowController::class, 'webhook']);

Route::get('/films/{id}', [testController::class, 'show']);
Route::get('/films', [testController::class, 'show_movie']);
Route::post('/movie', [testController::class, 'movie_create']);

Route::post('/moviejson', [testController::class, 'searchByJSON']);

Route::post('/moviejsonByActor', [testController::class, 'getMoviesByActor']);

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::options('/{any}', function () {
    return response()->noContent()
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');