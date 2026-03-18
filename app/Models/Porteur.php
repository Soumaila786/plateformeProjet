<?php
// app/Models/Porteur.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Porteur extends Model
{
    protected $table = 'porteurs';

    protected $fillable = [
        'user_id',
        'structure',
        'specialite'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relations avec les projets
    public function projets()
    {
        return $this->hasMany(Projet::class, 'porteur_id');
    }

    public function activite()
    {
        return $this->hasMany(Activite::class, 'porteur_id');
    }
}
