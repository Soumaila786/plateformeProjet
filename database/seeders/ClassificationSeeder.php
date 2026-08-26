<?php

namespace Database\Seeders;

use App\Models\SecteurActivite;
use App\Models\SousDomaine;
use App\Models\TypeProjet;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Recherche scientifique',
            'Formation et pédagogie',
            'Infrastructure universitaire',
            'Équipement scientifique et pédagogique',
            'Transformation numérique',
            'Développement institutionnel',
            'Coopération universitaire',
            'Vie universitaire',
            'Environnement et développement durable',
        ];

        foreach ($types as $nom) {
            TypeProjet::firstOrCreate(
                ['nom' => $nom],
                ['actif' => true]
            );
        }

        $domaines = [
            'Informatique' => ['Réseaux', 'Cybersécurité', 'Développement logiciel', 'Intelligence artificielle', 'Systèmes d’information'],
            'Sciences' => ['Physique', 'Chimie', 'Mathématiques', 'Biologie'],
            'Santé' => ['Santé publique', 'Sciences biomédicales', 'Prévention'],
            'Agriculture' => ['Production végétale', 'Production animale', 'Environnement rural'],
        ];

        foreach ($domaines as $nomSecteur => $sousDomaines) {
            $secteur = SecteurActivite::firstOrCreate(
                ['nomSecteur' => $nomSecteur],
                ['description' => 'Domaine d’activité universitaire', 'statutSecteur' => true]
            );

            foreach ($sousDomaines as $nom) {
                SousDomaine::firstOrCreate(
                    ['secteur_id' => $secteur->id, 'nom' => $nom],
                    ['actif' => true]
                );
            }
        }
    }
}
