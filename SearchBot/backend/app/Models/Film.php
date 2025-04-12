<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Film extends Model
{
    public function historiques(): HasMany
    {
        return $this->hasMany(Historique::class, 'film_id');
    }

    public function favoris(): HasMany
    {
        return $this->hasMany(Favori::class, 'film_id');
    }
}
