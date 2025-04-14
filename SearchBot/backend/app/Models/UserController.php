

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ✅ Obtenir les favoris de l'utilisateur connecté
    public function mesFavoris(Request $request)
    {
        $favoris = $request->user()->load('favoris.film')->favoris;
        return response()->json($favoris);
    }

    // ✅ Obtenir l'historique de l'utilisateur connecté
    public function mesHistoriques(Request $request)
    {
        $historiques = $request->user()->load('historiques.film')->historiques;
        return response()->json($historiques);
    }

    // 🔄 Ajout d'un film aux favoris
    public function ajouterFavori(Request $request)
    {
        $request->validate([
            'film_id' => 'required|integer|exists:films,id',
        ]);

        $user = $request->user();

        // Vérifie si le film est déjà dans les favoris
        if ($user->favoris()->where('film_id', $request->film_id)->exists()) {
            return response()->json(['message' => 'Ce film est déjà dans vos favoris.'], 409);
        }

        $user->favoris()->create([
            'film_id' => $request->film_id,
        ]);

        return response()->json(['message' => 'Film ajouté aux favoris !']);
    }

    // 🕓 Ajout d'un film à l'historique
    public function ajouterHistorique(Request $request)
    {
        $request->validate([
            'film_id' => 'required|integer|exists:films,id',
        ]);

        $user = $request->user();

        // Optionnel : vérifier si le film est déjà dans l'historique
        $user->historiques()->create([
            'film_id' => $request->film_id,
            'date_visionnage' => now(),
        ]);

        return response()->json(['message' => 'Film ajouté à l’historique !']);
    }
}


