<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Projet;

class ProjetPolicy {

    // Voir un projet
    public function view(User $user, Projet $projet) {
        if (!$user->can('projets.voir')) {
            return false;
        }

        // Un brouillon reste privé jusqu'à sa soumission.
        if (in_array($projet->statutProjet, ['brouillon', 'a_corriger'])) {
            return $projet->user_id === $user->id;
        }

        // Le porteur ne voit que ses propres projets, les autres rôles voient tout
        if ($user->hasRole('porteur')) {
            return $projet->user_id === $user->id;
        }

        return true;
    }

    // Créer un projet
    public function create(User $user) {
        return $user->can('projets.creer');
    }

    // Modifier un projet
    // NOTE : un projet 'rejete' est verrouillé définitivement (lecture seule).
    public function update(User $user, Projet $projet){
        if ($user->hasRole('admin')) {
            return false;
        }
        if (!$user->can('projets.modifier')) {
            return false;
        }
        return $projet->user_id === $user->id
            && in_array($projet->statutProjet, ['brouillon', 'a_corriger']);
    }

    // Supprimer un projet
    public function delete(User $user, Projet $projet){
        if ($user->hasRole('admin')) {
            return false;
        }
        if (!$user->can('projets.supprimer')) {
            return false;
        }
        return $projet->user_id === $user->id
            && in_array($projet->statutProjet, ['brouillon', 'a_corriger', 'soumis']);
    }

    // Soumettre un projet
    public function soumettre(User $user, Projet $projet) {
        return $user->can('projets.soumettre')
            && $projet->user_id === $user->id
            && in_array($projet->statutProjet, ['brouillon', 'a_corriger']);
    }

    // Mettre en examen
    public function examiner(User $user, Projet $projet) {
        return $user->can('projets.examiner')
            && $projet->statutProjet === 'soumis';
    }

    // Approuver
    public function approuver(User $user, Projet $projet) {
        return $user->can('projets.approuver')
            && $projet->statutProjet === 'en_examen';
    }

    // Rejeter (approbateur : soumis/en_examen -- validateur : approuve)
    public function rejeter(User $user, Projet $projet) {
        if (!$user->can('projets.rejeter')) {
            return false;
        }
        if ($user->hasRole('approbateur')) {
            return $projet->statutProjet === 'en_examen';
        }
        if ($user->hasRole('validateur')) {
            return $projet->statutProjet === 'en_validation';
        }
        return false;
    }

    // Valider
    public function valider(User $user, Projet $projet) {
        return $user->can('projets.valider')
            && $projet->statutProjet === 'en_validation';
    }

    // Demande de modification (approbateur : soumis/en_examen -- validateur : approuve)
    public function demandeModification(User $user, Projet $projet) {
        if (!$user->can('projets.demander_modification')) {
            return false;
        }
        if ($user->hasRole('approbateur')) {
            return $projet->statutProjet === 'en_examen';
        }
        if ($user->hasRole('validateur')) {
            return $projet->statutProjet === 'en_validation';
        }
        return false;
    }

    // Documents
    public function uploadDocument(User $user, Projet $projet) {
        if ($user->hasRole('admin')) {
            return true;
        }
        return $user->can('documents.upload')
            && $projet->user_id === $user->id;
    }

    public function deleteDocument(User $user, Projet $projet) {
        if ($user->hasRole('admin')) {
            return true;
        }
        return $user->can('documents.supprimer')
            && $projet->user_id === $user->id;
    }

    // Gérer les ACTIVITÉS (porteur seulement)
    public function gererActivite(User $user, Projet $projet) {
        return $user->can('projets.gerer_activite')
            && $projet->user_id === $user->id
            && !in_array($projet->statutProjet, ['approuve', 'valide', 'rejete']);
    }

    // Gérer la planification (pilote le Model Activite)
    public function gererPlanification(User $user, Projet $projet) {
        if (!$user->can('projets.gerer_planification')) {
            return false;
        }
        if ($user->hasRole('porteur')) {
            return $projet->user_id === $user->id
                && !in_array($projet->statutProjet, ['approuve', 'valide', 'rejete']);
        }
        // Planificateur : accès filtré par le controller (index = demandes, show = tous)
        if ($user->hasRole('planificateur')) {
            return true;
        }
        return false;
    }

    // Voir la planification
    public function voirPlanification(User $user, Projet $projet) {
        if (!$user->can('projets.voir_planification')) {
            return false;
        }
        if ($user->hasRole('porteur')) {
            return $projet->user_id === $user->id;
        }
        if ($user->hasRole('validateur')) {
            return in_array($projet->statutProjet, ['approuve', 'valide']);
        }
        // admin, approbateur, planificateur : la permission suffit
        return true;
    }
}
