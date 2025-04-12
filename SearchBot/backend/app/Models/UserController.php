<?php

use App\Models\User;

public function favoris($id)
{
    $user = User::with('favoris.film')->findOrFail($id);
    return response()->json($user->favoris);
}

public function historiques($id)
{
    $user = User::with('historiques.film')->findOrFail($id);
    return response()->json($user->historiques);
}
