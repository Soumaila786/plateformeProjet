<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'nomComplet',
        'email',
        'matricule',
        'fonction',
        'contact',
        'password',
        'role',
        'actif',
        'organisation',
        'photo',
        // Champs fusionnés depuis les anciennes tables satellites par rôle
        'datePriseFonction',
        'service',
        'poste',
        'dateDebutMandat',
        'dateFinMandat',
        'specialite',
    ];

    protected $hidden = [
        'password',
        'rememberToken',
    ];

    protected $casts = [
        'actif'             => 'boolean',
        'datePriseFonction' => 'date',
        'dateDebutMandat'   => 'date',
        'dateFinMandat'     => 'date',
    ];

    // Relations
    public function projets() {
        return $this->hasMany(Projet::class);
    }

    /**
     * URL de la photo de profil si elle existe, sinon null (à gérer côté vue
     * avec le component <x-avatars.user> qui affiche les initiales en repli).
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getInitialesAttribute(): string
    {
        return strtoupper(substr($this->nomComplet ?? 'U', 0, 2));
    }

    /**
     * Envoie l'email de réinitialisation de mot de passe avec notre propre
     * template (cohérent avec le reste des emails de l'application), plutôt
     * que la notification par défaut de Laravel.
     */
    public function sendPasswordResetNotification($token)
    {
        $url = url(route('password.reset', ['token' => $token, 'email' => $this->email], false));

        \Illuminate\Support\Facades\Mail::to($this->email)->send(new \App\Mail\ResetPasswordMail($this, $url));
    }
}