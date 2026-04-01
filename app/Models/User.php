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
        'organisation',
    ];

    protected $hidden = [
        'motDePasse',
    ];

    protected $casts = [
        'actif'        => 'boolean',
        'dateCreation' => 'datetime',
    ];

    protected static function boot() {

        parent::boot();

        static::deleting(function ($user) {
            $user->porteur()->delete();
            $user->approbateur()->delete();
            $user->validateur()->delete();
        });
    }

    // Spatie utilise 'password' par défaut — on pointe vers motDePasse
    public function getAuthPassword() {

        return $this->motDePasse;
    }

    // Relations
    public function projets() {

        return $this->hasMany(Projet::class);
    }

    public function porteur() {
        return $this->hasOne(Porteur::class, 'user_id');
    }

    public function approbateur() {
        return $this->hasOne(Approbateur::class, 'user_id');
    }

    public function validateur() {
        return $this->hasOne(Validateur::class, 'user_id');
    }


}
