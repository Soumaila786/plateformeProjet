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
        'type_projet_id',
        'sous_domaine_id',
        'dateSoumission',
        'duree',
        'dateDebut',
        'dateFin',
        'budgetTotal',
        'montantDemande',
        'statutProjet',
        'user_id',
        'secteur_id',
        'dateApprobation',
        'approbateur_id',
        'dateValidation',
        'validateur_id',
        'planification_demandee',
    ];

    protected $casts = [
        'dateSoumission'         => 'datetime',
        'dateApprobation'        => 'datetime',
        'dateValidation'         => 'datetime',
        'dateDebut'              => 'date',
        'dateFin'                => 'date',
        'budgetTotal'            => 'decimal:2',
        'montantDemande'         => 'decimal:2',
        'planification_demandee' => 'boolean',
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
        return $this->belongsTo(User::class, 'validateur_id');
    }

    public function secteur(){
        return $this->belongsTo(SecteurActivite::class, 'secteur_id');
    }

    public function typeProjet()
    {
        return $this->belongsTo(TypeProjet::class, 'type_projet_id');
    }

    public function sousDomaine()
    {
        return $this->belongsTo(SousDomaine::class, 'sous_domaine_id');
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

    public function historiques()
    {
        return $this->hasMany(HistoriqueProjet::class, 'projet_id')->latest();
    }

    // Dernier commentaire de rejet (remplace l'ancien champ motifRejet / commentaire_id)
    public function dernierMotifRejet() {
        return $this->hasOne(Commentaire::class, 'projet_id')
                     ->where('typeCommentaire', 'rejet')
                     ->latestOfMany();
    }

    //  Accesseurs de statut
    // IMPORTANT : ces helpers reflètent exactement la logique de ProjetPolicy.
    // Si tu changes une règle ici, change-la aussi dans ProjetPolicy (et inversement)
    // pour éviter que les boutons affichés dans les vues ne correspondent plus
    // à ce qui est réellement autorisé par les controllers.

    // Un projet 'rejete' est définitivement verrouillé (lecture seule, aucune resoumission).
    // 'en_examen' reste éditable (cohérent avec ProjetPolicy::update()).
    public function isEditable() {
        return in_array($this->statutProjet, ['brouillon', 'a_corriger']);
    }

    public function isDeletable() {
        return in_array($this->statutProjet, ['brouillon', 'soumis']);
    }

    public function isSubmittable(): bool {
        return in_array($this->statutProjet, ['brouillon', 'a_corriger']);
    }

    public function isRejected(): bool {
        return $this->statutProjet === 'rejete';
    }

    public function isApprouveAndValide() {
        return in_array($this->statutProjet, ['approuve', 'en_validation', 'valide']);
    }
}
