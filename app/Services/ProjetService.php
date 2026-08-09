<?php

namespace App\Services\Projet;

use App\Models\Projet;

class ProjetService {
    /**
     * Configuration des statuts.
     */
    private array $statusMap = [
        'brouillon' => [ 'lbl' => 'Brouillon', 'cls' => 'badge-brouillon', 'dot' => '#9ca3af', ],
        'soumis'    => [ 'lbl' => 'Soumis',    'cls' => 'badge-soumis',    'dot' => '#6366f1', ],
        'en_examen' => [ 'lbl' => 'En examen', 'cls' => 'badge-en-examen', 'dot' => '#f97316', ],
        'approuve'  => [ 'lbl' => 'Approuvé',  'cls' => 'badge-approuve',  'dot' => '#22c55e',  ],
        'valide'    => [ 'lbl' => 'Validé',    'cls' => 'badge-valide',    'dot' => '#0d9488', ],
        'rejete'    => [ 'lbl' => 'Rejeté',    'cls' => 'badge-rejete',    'dot' => '#ef4444', ],
    ];

    /**
     * Prépare toutes les données nécessaires
     * pour l'affichage d'un projet.
     */
    public function prepare(Projet $projet): array {

        return [
            'role' => auth()->user()->role,
            'status' => $this->statusMap[$projet->statutProjet] ?? $this->statusMap['brouillon'],
            'dernierRejet' => $projet->commentaires()
                ->where('typeCommentaire', 'rejet')
                ->latest('dateEnvoi')
                ->first(),
            'derniereDemande' => $projet->commentaires()
                ->where('typeCommentaire', 'demande')
                ->latest('dateEnvoi')
                ->first(),
        ];
    }
}
