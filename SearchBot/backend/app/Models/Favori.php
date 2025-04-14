<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Favori extends Model
{
    
    // Favori.php
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function film()
    {
    return $this->belongsTo(Film::class);
    }

}
