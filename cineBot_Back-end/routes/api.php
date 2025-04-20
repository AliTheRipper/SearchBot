
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

Route::get('/movies', [testController::class, 'index'])->name('movie.index');
Route::get('/movies/search', [testController::class, 'search'])->name('movie.search');

Route::get('/film', function(){
    
    return "film ajoute";
});

