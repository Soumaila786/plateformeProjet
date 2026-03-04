<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaires';

    protected $fillable = [
        'message',
        'dateEnvoi',
        'typeCommentaire',
        'projet_id',
        'utilisateur_id'
    ];

    protected $casts = [
        'dateEnvoi' => 'datetime'
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}