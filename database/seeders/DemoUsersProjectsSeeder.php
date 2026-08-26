<?php

namespace Database\Seeders;

use App\Models\Projet;
use App\Models\SecteurActivite;
use App\Models\SousDomaine;
use App\Models\TypeProjet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $secteurs = collect([
            ['nomSecteur' => 'Agriculture et environnement', 'description' => 'Projets agricoles et environnementaux'],
            ['nomSecteur' => 'Education et formation', 'description' => 'Projets educatifs et de formation'],
            ['nomSecteur' => 'Sante et protection sociale', 'description' => 'Projets de sante et de protection sociale'],
            ['nomSecteur' => 'Technologie et innovation', 'description' => 'Projets numeriques et innovants'],
        ])->mapWithKeys(function (array $data) {
            $secteur = SecteurActivite::firstOrCreate(
                ['nomSecteur' => $data['nomSecteur']],
                ['description' => $data['description'], 'statutSecteur' => true]
            );

            return [$secteur->id => $secteur];
        });

        $users = [
            [
                'email' => 'porteur1@gmail.com',
                'nomComplet' => 'Porteur Demo 1',
                'matricule' => 'POR001',
                'fonction' => 'Chef de projet',
                'organisation' => 'Organisation Demo 1',
                'specialite' => 'Developpement rural',
                'role' => 'porteur',
            ],
            [
                'email' => 'porteur2@gmail.com',
                'nomComplet' => 'Porteur Demo 2',
                'matricule' => 'POR002',
                'fonction' => 'Responsable programme',
                'organisation' => 'Organisation Demo 2',
                'specialite' => 'Innovation sociale',
                'role' => 'porteur',
            ],
            [
                'email' => 'approbateur@gmail.com',
                'nomComplet' => 'Approbateur Demo',
                'matricule' => 'APP001',
                'fonction' => 'Responsable approbation',
                'service' => 'Service des projets',
                'poste' => 'Approbateur',
                'role' => 'approbateur',
            ],
            [
                'email' => 'validateur@gmail.com',
                'nomComplet' => 'Validateur Demo',
                'matricule' => 'VAL001',
                'fonction' => 'Responsable validation',
                'dateDebutMandat' => '2026-01-01',
                'dateFinMandat' => '2026-12-31',
                'role' => 'validateur',
            ],
            [
                'email' => 'planificateur@gmail.com',
                'nomComplet' => 'Planificateur Demo',
                'matricule' => 'PLA001',
                'fonction' => 'Responsable planification',
                'service' => 'Service de planification',
                'role' => 'planificateur',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'contact' => '70000000',
                    'password' => Hash::make('password'),
                    'actif' => true,
                ])
            );

            $user->update(['role' => $userData['role'], 'actif' => true]);
        }

        $statuses = ['brouillon', 'soumis', 'en_examen', 'approuve', 'valide', 'rejete'];
        $typesProjets = TypeProjet::where('actif', true)->orderBy('id')->get();
        $porteurs = User::whereIn('email', ['porteur1@gmail.com', 'porteur2@gmail.com'])
            ->orderBy('email')
            ->get();

        foreach ($porteurs as $porteurIndex => $porteur) {
            for ($projectIndex = 1; $projectIndex <= 10; $projectIndex++) {
                $code = sprintf('DEMO-%d-%02d', $porteurIndex + 1, $projectIndex);
                $status = $statuses[($projectIndex - 1) % count($statuses)];
                $secteur = $secteurs->values()[($projectIndex - 1) % $secteurs->count()];
                $sousDomaine = SousDomaine::where('secteur_id', $secteur->id)
                    ->where('actif', true)
                    ->orderBy('id')
                    ->first();
                $typeProjet = $typesProjets->values()[($projectIndex - 1) % $typesProjets->count()];

                Projet::firstOrCreate(
                    ['codeProjet' => $code],
                    [
                        'titre' => 'Projet demo ' . ($porteurIndex + 1) . '-' . $projectIndex,
                        'description' => 'Projet de demonstration cree automatiquement pour tester le workflow.',
                        'objectif' => 'Illustrer le suivi et le traitement des projets.',
                        'type_projet_id' => $typeProjet->id,
                        'sous_domaine_id' => $sousDomaine ? $sousDomaine->id : null,
                        'dateSoumission' => $status === 'brouillon' ? null : now()->subDays(30 - $projectIndex),
                        'duree' => 12,
                        'dateDebut' => now()->startOfYear()->toDateString(),
                        'dateFin' => now()->addMonths(12)->toDateString(),
                        'budgetTotal' => 1000000 + ($projectIndex * 100000),
                        'montantDemande' => 800000 + ($projectIndex * 80000),
                        'statutProjet' => $status,
                        'user_id' => $porteur->id,
                        'secteur_id' => $secteur->id,
                    ]
                );
            }
        }
    }
}
