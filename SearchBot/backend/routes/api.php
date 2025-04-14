<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController; // ⚠️ à ajouter si ce n'était pas déjà fait

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Favoris & historiques de l'utilisateur connecté
    Route::get('/favoris', [UserController::class, 'mesFavoris']);
    Route::get('/historiques', [UserController::class, 'mesHistoriques']);

    // Ajout aux favoris ou à l'historique
    Route::post('/favoris', [UserController::class, 'ajouterFavori']);
    Route::post('/historiques', [UserController::class, 'ajouterHistorique']);
});

