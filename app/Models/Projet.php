<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $table = 'projets';

    protected $fillable = [
        'codeProjet',
        'titre',
        'description',
        'objectif',
        'dateCreation',
        'dateSoumission',
        'duree',
        'dateDebut',
        'dateFin',
        'budgetTotal',
        'montantDemande',
        'statutProjet',
        'user_id',
        'secteur_id'
    ];

    protected $casts = [
        'dateCreation' => 'datetime',
        'dateSoumission' => 'datetime',
        'dateDebut' => 'date',
        'dateFin' => 'date',
        'budgetTotal' => 'decimal:2',
        'montantDemande' => 'decimal:2'
    ];

    public function secteur()
    {
        return $this->belongsTo(SecteurActivite::class, 'secteur_id');
    }

    public function porteur()
    {
        return $this->belongsTo(Porteur::class);
    }

    public function approbateur()
    {
        return $this->belongsTo(Approbateur::class);
    }

    public function validateur()
    {
        return $this->belongsTo(Validateur::class);
    }

    public function planifications()
    {
        return $this->hasMany(Planification::class);
    }

    public function documents()
    {
        return $this->hasMany(DocumentProjet::class);
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }
}