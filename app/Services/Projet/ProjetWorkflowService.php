<?php

namespace App\Services\Projet;

use App\Models\HistoriqueProjet;
use App\Models\Projet;
use App\Models\User;

class ProjetWorkflowService
{
    public function transition(
        Projet $projet,
        User $user,
        string $nouveauStatut,
        string $action,
        ?int $commentaireId = null
    ): void {
        $ancienStatut = $projet->statutProjet;

        if ($ancienStatut === $nouveauStatut) {
            return;
        }

        $projet->update(['statutProjet' => $nouveauStatut]);

        HistoriqueProjet::create([
            'projet_id' => $projet->id,
            'user_id' => $user->id,
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'action' => $action,
            'commentaire_id' => $commentaireId,
        ]);
    }
}
