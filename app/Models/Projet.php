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
        'secteur_id',
        'motifRejet',
        'messageModification',
        'dateApprobation',
        'dateValidation',
    ];

    protected $casts = [
        'dateCreation'    => 'datetime',
        'dateSoumission'  => 'datetime',
        'dateApprobation' => 'datetime',
        'dateValidation'  => 'datetime',
        'dateDebut'       => 'date',
        'dateFin'         => 'date',
        'budgetTotal'     => 'decimal:2',
        'montantDemande'  => 'decimal:2',
    ];

    // ── Relations ──

    // Le porteur du projet (user_id)
    public function porteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Alias pour compatibilité
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function secteur()
    {
        return $this->belongsTo(SecteurActivite::class, 'secteur_id');
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

    // ── Accesseurs utiles ──

    public function isEditable()
    {
        return in_array($this->statutProjet, ['brouillon', 'soumis']);
    }

    public function isDeletable()
    {
        return in_array($this->statutProjet, ['brouillon', 'soumis']);
    }

    public function isSubmittable()
    {
        return $this->statutProjet === 'brouillon';
    }
}
