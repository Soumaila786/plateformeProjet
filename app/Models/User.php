<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'nomComplet',
        'email',
        'matricule',
        'fonction',
        'contact',
        'motDePasse',
        'role',
        'actif',
        'dateCreation',
    ];

    protected $hidden = [
        'motDePasse',
    ];

    protected $casts = [
        'actif'        => 'boolean',
        'dateCreation' => 'datetime',
    ];

    // Spatie utilise 'password' par défaut — on pointe vers motDePasse
    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    // Relations
    public function projets()
    {
        return $this->hasMany(Projet::class);
    }
}
