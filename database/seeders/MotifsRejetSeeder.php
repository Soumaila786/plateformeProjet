<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MotifRejet;

class MotifsRejetSeeder extends Seeder
{
    public function run()
    {
        $motifs = [
            'Dossier incomplet',
            'Documents justificatifs manquants',
            'Informations administratives incomplètes',
            'Informations administratives erronées',
            'Budget prévisionnel incohérent',
            'Budget prévisionnel insuffisamment détaillé',
            'Plan de financement incomplet',
            'Objectifs du projet insuffisamment définis',
            'Description des activités insuffisante',
            'Chronogramme incomplet',
            'Chronogramme incohérent',
            'Indicateurs de suivi insuffisants',
            'Indicateurs de résultats insuffisants',
            'Analyse des risques insuffisante',
            'Impact attendu insuffisamment démontré',
            'Faisabilité technique insuffisante',
            'Viabilité économique insuffisante',
            'Viabilité financière insuffisante',
            'Montant du financement non justifié',
            'Coût du projet non réaliste',
            "Non-conformité aux critères d'éligibilité",
            'Non-conformité aux priorités stratégiques',
            'Non-conformité aux conditions de soumission',
            "Projet hors du domaine d'intervention",
            'Projet en doublon',
            'Porteur de projet non éligible',
            'Équipe de projet insuffisamment qualifiée',
            'Capacité de mise en œuvre insuffisante',
            'Pièces obligatoires manquantes',
            'Pièces justificatives illisibles',
            'Informations contradictoires',
            'Calendrier de réalisation irréaliste',
            'Plan de gestion des risques incomplet',
            'Innovation insuffisante',
            'Impact socio-économique insuffisant',
            'Impact environnemental insuffisamment pris en compte',
            'Risques juridiques ou réglementaires',
            'Autre motif',
        ];

        foreach ($motifs as $libelle) {
            MotifRejet::firstOrCreate(['libelle' => $libelle], ['actif' => true]);
        }
    }
}
