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
        $users = [
            [
                'email' => 'porteur1@gmail.com',
                'nomComplet' => 'Awa Ouedraogo',
                'matricule' => 'POR-BF-001',
                'fonction' => 'Coordinatrice des programmes agricoles',
                'organisation' => 'Association pour le Developpement Rural du Burkina',
                'specialite' => 'Agroecologie et autonomisation des femmes',
                'role' => 'porteur',
            ],
            [
                'email' => 'porteur2@gmail.com',
                'nomComplet' => 'Souleymane Kaboré',
                'matricule' => 'POR-BF-002',
                'fonction' => 'Directeur des operations',
                'organisation' => 'Initiative Jeunesse et Numerique Burkina',
                'specialite' => 'Formation professionnelle et inclusion numerique',
                'role' => 'porteur',
            ],
            [
                'email' => 'approbateur@gmail.com',
                'nomComplet' => 'Idrissa Sawadogo',
                'matricule' => 'APP-BF-001',
                'fonction' => 'Directeur des programmes',
                'service' => 'Direction des projets et de la cooperation',
                'poste' => 'Responsable de l approbation',
                'role' => 'approbateur',
            ],
            [
                'email' => 'validateur@gmail.com',
                'nomComplet' => 'Dr Mariam Zongo',
                'matricule' => 'VAL-BF-001',
                'fonction' => 'Experte en suivi-evaluation',
                'dateDebutMandat' => '2026-01-01',
                'dateFinMandat' => '2026-12-31',
                'role' => 'validateur',
            ],
            [
                'email' => 'planificateur@gmail.com',
                'nomComplet' => 'Boubacar Traore',
                'matricule' => 'PLA-BF-001',
                'fonction' => 'Charge de la planification et du budget',
                'service' => 'Cellule de planification',
                'role' => 'planificateur',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                array_merge($userData, [
                    'contact' => '70000000',
                    'password' => Hash::make('password'),
                    'actif' => true,
                ])
            );

        }

        $porteurs = User::whereIn('email', ['porteur1@gmail.com', 'porteur2@gmail.com'])
            ->get()
            ->keyBy('email');
        $secteurs = SecteurActivite::whereIn('nomSecteur', ['Agriculture', 'Informatique', 'Santé', 'Sciences'])
            ->get()
            ->keyBy('nomSecteur');
        $types = TypeProjet::where('actif', true)->get()->keyBy('nom');

        $projects = [
            [
                'codeProjet' => 'BF-AGR-001', 'porteur' => 'porteur1@gmail.com', 'secteur' => 'Agriculture',
                'sous_domaine' => 'Production vegetale', 'type' => 'Environnement et développement durable',
                'titre' => 'Programme de production agroecologique du niébé dans la Boucle du Mouhoun',
                'description' => 'Le projet accompagne 450 exploitations familiales dans l adoption de pratiques agroecologiques et l amélioration du stockage du niébé.',
                'objectif' => 'Renforcer la productivite et les revenus des producteurs tout en preservant les sols.',
                'budgetTotal' => 185000000, 'montantDemande' => 148000000, 'duree' => 24, 'statutProjet' => 'soumis',
            ],
            [
                'codeProjet' => 'BF-AGR-002', 'porteur' => 'porteur1@gmail.com', 'secteur' => 'Agriculture',
                'sous_domaine' => 'Production animale', 'type' => 'Recherche scientifique',
                'titre' => 'Amelioration de la sante animale et de la productivite laitiere au Sahel',
                'description' => 'Le projet met en place un dispositif de suivi sanitaire et de formation des eleveurs dans les communes rurales du Sahel.',
                'objectif' => 'Reduire les pertes du cheptel et augmenter durablement la production laitiere.',
                'budgetTotal' => 96000000, 'montantDemande' => 76800000, 'duree' => 18, 'statutProjet' => 'en_examen',
            ],
            [
                'codeProjet' => 'BF-AGR-003', 'porteur' => 'porteur1@gmail.com', 'secteur' => 'Agriculture',
                'sous_domaine' => 'Environnement rural', 'type' => 'Environnement et développement durable',
                'titre' => 'Restauration des terres degradees et gestion communautaire de l eau a Yatenga',
                'description' => 'Le projet rehabilite des terres degradees par les cordons pierreux, le zaï et la regeneration naturelle assistee.',
                'objectif' => 'Restaurer 600 hectares et securiser les productions agricoles face aux aleas climatiques.',
                'budgetTotal' => 124000000, 'montantDemande' => 99000000, 'duree' => 24, 'statutProjet' => 'approuve',
            ],
            [
                'codeProjet' => 'BF-SAN-001', 'porteur' => 'porteur1@gmail.com', 'secteur' => 'Santé',
                'sous_domaine' => 'Sante publique', 'type' => 'Développement institutionnel',
                'titre' => 'Renforcement de la sante maternelle et neonatale dans les districts ruraux',
                'description' => 'Le projet renforce les competences des agents de sante communautaires et facilite la reference des urgences obstetricales.',
                'objectif' => 'Ameliorer l acces aux soins maternels et reduire les complications evitables.',
                'budgetTotal' => 210000000, 'montantDemande' => 168000000, 'duree' => 30, 'statutProjet' => 'valide',
            ],
            [
                'codeProjet' => 'BF-SAN-002', 'porteur' => 'porteur1@gmail.com', 'secteur' => 'Santé',
                'sous_domaine' => 'Prevention', 'type' => 'Formation et pédagogie',
                'titre' => 'Campagne communautaire de prevention du paludisme chez les enfants',
                'description' => 'Le projet deploie des actions de sensibilisation, de suivi et de distribution de moyens de prevention dans les zones prioritaires.',
                'objectif' => 'Accroitre l utilisation correcte des moustiquaires et le recours rapide aux soins.',
                'budgetTotal' => 68000000, 'montantDemande' => 54400000, 'duree' => 12, 'statutProjet' => 'brouillon',
            ],
            [
                'codeProjet' => 'BF-INF-001', 'porteur' => 'porteur2@gmail.com', 'secteur' => 'Informatique',
                'sous_domaine' => 'Développement logiciel', 'type' => 'Transformation numérique',
                'titre' => 'Plateforme numerique de suivi des projets de developpement local',
                'description' => 'La plateforme centralise le suivi des indicateurs, des activites et des budgets des projets mis en oeuvre au Burkina Faso.',
                'objectif' => 'Ameliorer la transparence et la prise de decision grace a des donnees fiables et accessibles.',
                'budgetTotal' => 155000000, 'montantDemande' => 124000000, 'duree' => 18, 'statutProjet' => 'soumis',
            ],
            [
                'codeProjet' => 'BF-INF-002', 'porteur' => 'porteur2@gmail.com', 'secteur' => 'Informatique',
                'sous_domaine' => 'Réseaux', 'type' => 'Infrastructure universitaire',
                'titre' => 'Extension de la connectivite internet des etablissements secondaires',
                'description' => 'Le projet installe des liaisons internet, des equipements reseau et des points d acces securises dans dix etablissements.',
                'objectif' => 'Reduire la fracture numerique et faciliter l acces des eleves aux ressources pedagogiques.',
                'budgetTotal' => 178000000, 'montantDemande' => 142400000, 'duree' => 20, 'statutProjet' => 'en_examen',
            ],
            [
                'codeProjet' => 'BF-INF-003', 'porteur' => 'porteur2@gmail.com', 'secteur' => 'Informatique',
                'sous_domaine' => 'Cybersécurité', 'type' => 'Développement institutionnel',
                'titre' => 'Mise en place d un dispositif de securite des systemes d information',
                'description' => 'Le projet accompagne les structures partenaires dans la protection des donnees, la gestion des acces et la sensibilisation du personnel.',
                'objectif' => 'Renforcer la resilience des organisations face aux incidents de securite informatique.',
                'budgetTotal' => 112000000, 'montantDemande' => 89600000, 'duree' => 15, 'statutProjet' => 'approuve',
            ],
            [
                'codeProjet' => 'BF-SCI-001', 'porteur' => 'porteur2@gmail.com', 'secteur' => 'Sciences',
                'sous_domaine' => 'Biologie', 'type' => 'Recherche scientifique',
                'titre' => 'Valorisation des plantes locales pour la nutrition et la sante',
                'description' => 'Le projet analyse les proprietes nutritionnelles de plantes locales et developpe des produits accessibles aux communautes.',
                'objectif' => 'Soutenir la recherche appliquee et la valorisation durable des ressources naturelles burkinabe.',
                'budgetTotal' => 89000000, 'montantDemande' => 71200000, 'duree' => 24, 'statutProjet' => 'valide',
            ],
            [
                'codeProjet' => 'BF-SCI-002', 'porteur' => 'porteur2@gmail.com', 'secteur' => 'Sciences',
                'sous_domaine' => 'Physique', 'type' => 'Équipement scientifique et pédagogique',
                'titre' => 'Modernisation des laboratoires scientifiques pour la formation des etudiants',
                'description' => 'Le projet equipe les laboratoires de travaux pratiques et renforce la maintenance ainsi que la formation des enseignants.',
                'objectif' => 'Ameliorer la qualite de la formation scientifique et l employabilite des diplomes.',
                'budgetTotal' => 235000000, 'montantDemande' => 188000000, 'duree' => 18, 'statutProjet' => 'rejete',
            ],
        ];

        Projet::where('codeProjet', 'like', 'DEMO-%')->delete();

        foreach ($projects as $project) {
            $secteur = $secteurs->get($project['secteur']);
            $type = $types->get($project['type']);
            $sousDomaine = SousDomaine::where('secteur_id', $secteur->id)
                ->where('nom', $project['sous_domaine'])
                ->firstOrFail();
            $status = $project['statutProjet'];

            Projet::updateOrCreate(
                ['codeProjet' => $project['codeProjet']],
                [
                    'titre' => $project['titre'],
                    'description' => $project['description'],
                    'objectif' => $project['objectif'],
                    'type_projet_id' => $type->id,
                    'sous_domaine_id' => $sousDomaine->id,
                    'dateSoumission' => $status === 'brouillon' ? null : now()->subDays(12),
                    'duree' => $project['duree'],
                    'dateDebut' => now()->startOfYear()->toDateString(),
                    'dateFin' => now()->startOfYear()->addMonths($project['duree'])->toDateString(),
                    'budgetTotal' => $project['budgetTotal'],
                    'budgetDevise' => 'XOF',
                    'montantDemande' => $project['montantDemande'],
                    'montantDemandeDevise' => 'XOF',
                    'statutProjet' => $status,
                    'user_id' => $porteurs->get($project['porteur'])->id,
                    'secteur_id' => $secteur->id,
                ]
            );
        }
    }
}
