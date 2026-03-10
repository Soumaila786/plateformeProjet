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
                // Voit seulement ses propres projets
                return $projet->user_id === $user->id;

            default:
                return false;
        }
    }

    // ── Créer un projet ──
    public function create(User $user)
    {
        return in_array($user->role, ['porteur', 'approbateur']);
    }

    // ── Modifier un projet ──
    public function update(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                // Seulement ses projets ET pas encore approuvé/validé
                return $projet->user_id === $user->id
                    && !in_array($projet->statutProjet, ['approuve', 'valide']);

            case 'approbateur':
                // Ses propres projets uniquement
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
            case 'approbateur':
                // Seulement ses projets ET seulement si brouillon ou soumis
                return $projet->user_id === $user->id
                    && in_array($projet->statutProjet, ['brouillon', 'soumis']);

            case 'admin':
                return true;

            default:
                return false;
        }
    }

    // ── Soumettre un projet ──
    public function soumettre(User $user, Projet $projet)
    {
        return $projet->user_id === $user->id
            && $projet->statutProjet === 'brouillon';
    }

    // ── Mettre en examen ──
    public function examiner(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && $projet->statutProjet === 'soumis';
    }

    // ── Approuver un projet ──
    public function approuver(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && $projet->statutProjet === 'en_examen';
    }

    // ── Rejeter un projet (approbateur ou validateur) ──
    public function rejeter(User $user, Projet $projet)
    {
        if ($user->role === 'approbateur') {
            return $projet->statutProjet === 'en_examen';
        }

        if ($user->role === 'validateur') {
            return $projet->statutProjet === 'approuve';
        }

        return false;
    }

    // ── Valider un projet ──
    public function valider(User $user, Projet $projet)
    {
        return $user->role === 'validateur'
            && $projet->statutProjet === 'approuve';
    }

    // ── Demande de modification ──
    public function demandeModification(User $user, Projet $projet)
    {
        return $user->role === 'approbateur'
            && in_array($projet->statutProjet, ['soumis', 'en_examen']);
    }

    // ── Gérer les documents ──
    public function uploadDocument(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
            case 'approbateur':
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
            case 'approbateur':
                return $projet->user_id === $user->id;
            case 'admin':
                return true;
            default:
                return false;
        }
    }

    // ── Gérer la planification ──
    public function gererPlanification(User $user, Projet $projet)
    {
        switch ($user->role) {
            case 'porteur':
                // Seulement ses projets non encore approuvés
                return $projet->user_id === $user->id
                    && !in_array($projet->statutProjet, ['approuve', 'valide']);

            case 'approbateur':
                // Tous les projets en examen ou approuvés
                return in_array($projet->statutProjet, ['soumis', 'en_examen', 'approuve']);

            default:
                return false;
        }
    }
}
