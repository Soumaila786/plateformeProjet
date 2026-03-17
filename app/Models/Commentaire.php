<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Projet;

class Commentaire extends Model
{
    protected $table = 'commentaires';

    protected $fillable = [
        'message',
        'dateEnvoi',
        'typeCommentaire',
        'projet_id',
        'utilisateur_id',
    ];

    protected $dates = ['dateEnvoi'];

    // ── Relations ──

    public function projet(){
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function utilisateur(){
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // ── Helpers ──

    public function icone(){
        $icons = [
            'approbation' => 'fa-check-circle',
            'rejet'       => 'fa-times-circle',
            'demande'     => 'fa-exclamation-circle',
            'info'        => 'fa-info-circle',
        ];
        return $icons[$this->typeCommentaire] ?? 'fa-comment';
    }

    public function couleur(){
        $colors = [
            'approbation' => '#16a34a',
            'rejet'       => '#dc2626',
            'demande'     => '#d97706',
            'info'        => '#2563eb',
        ];
        return $colors[$this->typeCommentaire] ?? '#6b7280';
    }
    
}
