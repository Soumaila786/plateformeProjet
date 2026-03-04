<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planification extends Model
{
    protected $table = 'planifications';

    protected $fillable = [
        'activite',
        'descriptionActivite',
        'montantDemande',
        'dateDebut',
        'dateFin',
        'statutActivite',
        'projet_id',
    ];

    protected $casts = [
        'dateDebut' => 'date',
        'dateFin' => 'date',
        'montantDemande' => 'decimal:2'
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

}