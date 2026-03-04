<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'dateEnvoi',
        'statut',
        'destinataire_id',
        'type',
        'projet_id'
    ];

    protected $casts = [
        'dateEnvoi' => 'datetime',
        'statut' => 'string'
    ];

    public function destinataire()
    {
        return $this->belongsTo(User::class, 'destinataire_id');
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
