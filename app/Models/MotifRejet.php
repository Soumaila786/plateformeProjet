<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotifRejet extends Model
{
    protected $table = 'motifs_rejet';

    protected $fillable = [
        'libelle',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function scopeActifs($query)
    {
        return $query->where('actif', true);
    }

    public function commentaires()
    {
        return $this->belongsToMany(Commentaire::class, 'commentaire_motifs', 'motif_id', 'commentaire_id');
    }
}
