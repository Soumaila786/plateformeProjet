<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    protected $table = 'activites';

    protected $fillable = [
        'activite',
        'descriptionActivite',
        'montantDemande',
        'dateDebut',
        'dateFin',
        'statutActivite',
        'projet_id',
    ];

    protected $dates = ['dateDebut', 'dateFin'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    // ── Helpers statut ──

    public function labelStatut()
    {
        $labels = [
            'en_attente' => 'En attente',
            'financee'   => 'Financée',
            'en_cours'   => 'En cours',
            'termine'    => 'Terminée',
            'annule'     => 'Annulée',
        ];
        return $labels[$this->statutActivite] ?? $this->statutActivite;
    }

    public function classeStatut()
    {
        $classes = [
            'en_attente' => 'status-gray',
            'financee'   => 'status-green',
            'en_cours'   => 'status-blue',
            'termine'    => 'status-teal',
            'annule'     => 'status-red',
        ];
        return $classes[$this->statutActivite] ?? 'status-gray';
    }

    public function iconeStatut()
    {
        $icons = [
            'en_attente' => 'fa-clock',
            'financee'   => 'fa-coins',
            'en_cours'   => 'fa-spinner',
            'termine'    => 'fa-check-circle',
            'annule'     => 'fa-times-circle',
        ];
        return $icons[$this->statutActivite] ?? 'fa-circle';
    }

    public function estFinancee()
    {
        return $this->statutActivite === 'financee';
    }
}
