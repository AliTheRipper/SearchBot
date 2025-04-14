<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
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



