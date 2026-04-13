<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model {

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
        'messageModification',
        'dateApprobation',
        'dateValidation',
        'validated_at',
        'validated_by',
        'approbateur_id',
        'planification_demandee',
    ];

    protected $casts = [
        'dateCreation'          => 'datetime',
        'dateSoumission'        => 'datetime',
        'dateApprobation'       => 'datetime',
        'dateValidation'        => 'datetime',
        'validated_at'          => 'datetime',
        'dateDebut'             => 'date',
        'dateFin'               => 'date',
        'budgetTotal'           => 'decimal:2',
        'montantDemande'        => 'decimal:2',
        'planification_demandee'=> 'boolean',
    ];

    //  Relations
    public function porteur() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approbateur() {
        return $this->belongsTo(User::class, 'approbateur_id');
    }

    public function validateur() {

        return $this->belongsTo(User::class, 'validated_by');
    }

    public function secteur(){

        return $this->belongsTo(SecteurActivite::class, 'secteur_id');
    }

    public function activites(){

        return $this->hasMany(Activite::class);
    }

    public function documents() {

        return $this->hasMany(DocumentProjet::class);
    }

    public function commentaires() {

        return $this->hasMany(Commentaire::class, 'projet_id');
    }

    public function planifications() {

        return $this->hasMany(Planification::class, 'projet_id');
    }

    //  Accesseurs
    public function isEditable() {
        return in_array($this->statutProjet, ['brouillon', 'soumis', 'rejete']);
    }

    public function isDeletable() {
        return in_array($this->statutProjet, ['brouillon', 'soumis', 'rejete']);
    }

    public function isSubmittable():bool {
        return in_array($this->statutProjet, ['brouillon', 'rejete']);
    }

    public function isApprouveAndValide() {
        return in_array($this->statutProjet, ['approuve', 'valide']);
    }
}
