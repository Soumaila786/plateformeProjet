<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SousDomaine extends Model
{
    protected $table = 'sous_domaines';

    protected $fillable = [
        'secteur_id',
        'nom',
        'description',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function secteur()
    {
        return $this->belongsTo(SecteurActivite::class, 'secteur_id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'sous_domaine_id');
    }
}
