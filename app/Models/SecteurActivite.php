<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecteurActivite extends Model
{
    protected $table = 'secteur_activites';

    protected $fillable = [
        'nomSecteur',
        'description',
        'statutSecteur'
    ];

    protected $casts = [
        'statutSecteur' => 'boolean'
    ];

    public function projets()
    {
        return $this->hasMany(Projet::class, 'secteur_id');
    }
}