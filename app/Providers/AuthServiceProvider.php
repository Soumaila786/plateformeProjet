<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Modèles
use App\Models\User;
use App\Models\Projet;
use App\Models\MotifRejet;
use App\Models\SecteurActivite;

// Policies
use App\Policies\UserPolicy;
use App\Policies\ProjetPolicy;
use App\Policies\MotifRejetPolicy;
use App\Policies\SecteurPolicy;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [
        User::class           => UserPolicy::class,
        Projet::class         => ProjetPolicy::class,
        MotifRejet::class => MotifRejetPolicy::class,
        SecteurActivite::class => SecteurPolicy::class,
    ];

    public function boot() {

        $this->registerPolicies();

        // Gates supplémentaires

        // Accès au dashboard admin
        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Accès au dashboard approbateur
        Gate::define('access-approbateur', function (User $user) {
            return $user->role === 'approbateur';
        });

        // Accès au dashboard validateur
        Gate::define('access-validateur', function (User $user) {
            return $user->role === 'validateur';
        });

        // Accès au dashboard porteur
        Gate::define('access-porteur', function (User $user) {
            return $user->role === 'porteur';
        });

        // Paramètres système (admin uniquement)
        Gate::define('parametres-system', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
