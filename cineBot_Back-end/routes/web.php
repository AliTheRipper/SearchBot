<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;


Route::get('/dialogflow', [DialogflowController::class, 'index']);
Route::post('/send-message', [DialogflowController::class, 'sendMessage']);

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::options('/{any}', function () {
    return response()->noContent()
        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
})->where('any', '.*');