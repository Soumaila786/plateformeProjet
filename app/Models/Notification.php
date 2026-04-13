<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    
    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'dateEnvoi',
        'statut',
        'type',
        'destinataire_id',
        'projet_id',
    ];

    protected $dates = ['dateEnvoi'];

    // Relations

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    // Helpers

    public function marquerLu()
    {
        $this->update(['statut' => 'lu']);
    }

    public function icone()
    {
        $icons = [
            'statut_change' => 'fa-exchange-alt',
            'approbation'   => 'fa-check-circle',
            'validation'    => 'fa-badge-check',
            'rejet'         => 'fa-times-circle',
            'modification'  => 'fa-edit',
            'soumission'    => 'fa-paper-plane',
            'info'          => 'fa-info-circle',
        ];
        return $icons[$this->type] ?? 'fa-bell';
    }

    public function couleur() {
        $colors = [
            'statut_change' => '#2563eb',
            'approbation'   => '#16a34a',
            'validation'    => '#0d9488',
            'rejet'         => '#dc2626',
            'modification'  => '#d97706',
            'soumission'    => '#6366f1',
            'info'          => '#6b7280',
        ];
        return $colors[$this->type] ?? '#6b7280';
    }
}
