<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriqueProjet extends Model {
    protected $table = 'historique_projets';
    protected $fillable = [
        'projet_id',
        'user_id',
        'ancien_statut',
        'nouveau_statut',
        'action',
        'commentaire_id',
    ];

    public function projet(){
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function utilisateur(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function commentaire(){
        return $this->belongsTo(Commentaire::class, 'commentaire_id');
    }
}
