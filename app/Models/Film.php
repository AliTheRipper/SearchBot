<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    //
    protected $fillable = ['titre', 'annee', 'genre', 'note'];
    protected $table = 'films';
    
}
