<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projet;

class ProjetPolicy
{
    // ── Voir un projet ──
    public function view(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'admin':
            case 'approbateur':
            case 'validateur':
                return true;
            case 'porteur':
                return $projet->user_id === $user->id;
            default:
                return false;
        }
    }

    // ── Créer un projet ──
    public function create(User $user)
    {
        return $user->role === 'porteur';
    }

    // ── Modifier un projet ──
    public function update(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                return $projet->user_id === $user->id
                    && !in_array($projet->statutProjet, ['approuve', 'valide']);
            case 'admin':
                return true;
            default:
                return false;
        }
    }

    // ── Supprimer un projet ──
    public function delete(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                return $projet->user_id === $user->id
                    && in_array($projet->statutProjet, ['brouillon', 'soumis']);
            case 'admin':
                return true;
            default:
                return false;
        }
    }

    // Soumettre un projet
    public function soumettre(User $user, Projet $projet)
    {
        return $projet->user_id === $user->id
            && in_array($projet->statutProjet, ['brouillon', 'rejete']);
    }

    // Mettre en examen
    public function examiner(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && $projet->statutProjet === 'soumis';
    }

    // Approuver
    public function approuver(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && $projet->statutProjet === 'en_examen';
    }

    // Rejeter
    public function rejeter(User $user, Projet $projet)
    {
        if ($user->role === 'approbateur') {
            return in_array($projet->statutProjet, ['soumis', 'en_examen']);
        }
        if ($user->role === 'validateur') {
            return $projet->statutProjet === 'approuve';
        }
        return false;
    }

    // Valider
    public function valider(User $user, Projet $projet)
    {
        return $user->role === 'validateur'
            && $projet->statutProjet === 'approuve';
    }

    // Demande de modification
    public function demandeModification(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && in_array($projet->statutProjet, ['soumis', 'en_examen']);
    }

    // Documents
    public function uploadDocument(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                return $projet->user_id === $user->id;
            case 'admin':
                return true;
            default:
                return false;
        }
    }

    public function deleteDocument(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                return $projet->user_id === $user->id;
            case 'admin':
                return true;
            default:
                return false;
        }
    }

    // ── Gérer les ACTIVITÉS (porteur seulement) ──
    public function gererActivite(User $user, Projet $projet)
    {
        // Seul le porteur gère ses activités, tant que le projet n'est pas approuvé/validé
        return $user->role === 'porteur'
            && $projet->user_id === $user->id
            && !in_array($projet->statutProjet, ['approuve', 'valide']);
    }

    // ── Gérer la PLANIFICATION (approbateur seulement) ──
    public function gererPlanification(User $user, Projet $projet)
    {
        // L'approbateur planifie sur les projets soumis, en examen ou approuvés
        return $user->role === 'approbateur'
            && in_array($projet->statutProjet, ['soumis', 'en_examen', 'approuve']);
    }

    // ── Voir la planification ──
    public function voirPlanification(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'approbateur':
            case 'admin':
                return true;
            case 'validateur':
                return in_array($projet->statutProjet, ['approuve', 'valide']);
            case 'porteur':
                return $projet->user_id === $user->id;
            default:
                return false;
        }
    }
}
