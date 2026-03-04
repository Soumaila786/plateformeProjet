<?php
// app/Models/Validateur.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validateur extends Model
{
    protected $table = 'validateurs';

    protected $fillable = [
        'user_id',
        'dateDebutMandat',
        'dateFinMandat'
    ];

    protected $casts = [
        'dateDebutMandat' => 'date',
        'dateFinMandat' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relations avec les projets
    public function projetsValides()
    {
        return $this->hasMany(Projet::class, 'validateur_id');
    }
}
