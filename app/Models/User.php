<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nomComplet',
        'email',
        'matricule',
        'fonction',
        'contact',
        'motDePasse',
        'role',
        'actif',
        'dateCreation'
    ];

    protected $hidden = [
        'motDePasse',
        'remember_token',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'dateCreation' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    // Relations avec les tables spécifiques selon le rôle
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id');
    }

    public function approbateur()
    {
        return $this->hasOne(Approbateur::class, 'user_id');
    }

    public function validateur()
    {
        return $this->hasOne(Validateur::class, 'user_id');
    }

    public function porteur()
    {
        return $this->hasOne(Porteur::class, 'user_id');
    }

    // Notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'destinataire_id');
    }

    // Commentaires écrits par l'utilisateur
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'users_id');
    }
}
