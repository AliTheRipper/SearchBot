<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DialogflowController;

Route::get('/dialogflow', [DialogflowController::class, 'index']);
Route::post('/send-message', [DialogflowController::class, 'sendMessage']);
