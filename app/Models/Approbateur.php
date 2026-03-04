<?php
// app/Models/Approbateur.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approbateur extends Model
{
    protected $table = 'approbateurs';

    protected $fillable = [
        'user_id',
        'service',
        'poste'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relations avec les projets
    public function projetsExamines()
    {
        return $this->hasMany(Projet::class, 'approbateur_id');
    }
}
