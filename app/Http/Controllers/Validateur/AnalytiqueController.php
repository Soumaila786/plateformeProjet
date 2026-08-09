<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnalytiqueController extends Controller {

    public function index() {

        $now = Carbon::now();
        try{
            //  1. ENTONNOIR
            $entonnoir = [
                'soumis'   => Projet::where('statutProjet', 'soumis')->count(),
                'approuve' => Projet::where('statutProjet', 'approuve')->count(),
                'valide'   => Projet::where('statutProjet', 'valide')->count(),
                'rejete'   => Projet::where('statutProjet', 'rejete')->count(),
            ];

            //  2. JAUGE
            $totalDemande  = Projet::sum('montantDemande') ?? 0;
            $totalBudget   = Projet::sum('budgetTotal')    ?? 0;
            $pctJauge      = $totalBudget > 0
                ? min(100, round($totalDemande / $totalBudget * 100))
                : 0;

            //  3. DONUT statuts
            $donut = Projet::select('statutProjet', DB::raw('count(*) as total'))
                ->groupBy('statutProjet')
                ->pluck('total', 'statutProjet')
                ->toArray();

            $statutLabels = [
                'brouillon' => 'Brouillon',
                'soumis'    => 'Soumis',
                'en_examen' => 'En examen',
                'approuve'  => 'Approuvé',
                'valide'    => 'Validé',
                'rejete'    => 'Rejeté',
            ];
            $donutLabels = [];
            $donutValues = [];
            foreach ($statutLabels as $key => $lbl) {
                if (isset($donut[$key]) && $donut[$key] > 0) {
                    $donutLabels[] = $lbl;
                    $donutValues[] = $donut[$key];
                }
            }

            //  4. DÉLAIS TRAITEMENT
            $delaiAppro = Projet::whereNotNull('dateApprobation')
                ->whereNotNull('dateSoumission')
                ->select(DB::raw('AVG(DATEDIFF(dateApprobation, dateSoumission)) as moy'))
                ->value('moy');

            // NOTE : validated_at renommé en dateValidation
            $delaiValid = Projet::whereNotNull('dateValidation')
                ->whereNotNull('dateApprobation')
                ->select(DB::raw('AVG(DATEDIFF(dateValidation, dateApprobation)) as moy'))
                ->value('moy');

            $delaiTotal = Projet::whereNotNull('dateValidation')
                ->whereNotNull('dateSoumission')
                ->select(DB::raw('AVG(DATEDIFF(dateValidation, dateSoumission)) as moy'))
                ->value('moy');

            $delais = [
                'labels' => ['Soumission → Approbation', 'Approbation → Validation', 'Total du processus'],
                'values' => [
                    round($delaiAppro ?? 0, 1),
                    round($delaiValid ?? 0, 1),
                    round($delaiTotal ?? 0, 1),
                ],
            ];

            // Projets en retard (soumis depuis > 30 jours sans décision)
            $retard = Projet::whereIn('statutProjet', ['soumis', 'en_examen', 'approuve'])
                ->where('dateSoumission', '<', $now->copy()->subDays(30))
                ->count();

            //  5. ANALYSE FINANCIÈRE
            $finParSecteur = Projet::with('secteur')
                ->select('secteur_id',
                    DB::raw('SUM(budgetTotal) as total_budget'),
                    DB::raw('SUM(montantDemande) as total_demande'),
                    DB::raw('COUNT(*) as nb')
                )
                ->groupBy('secteur_id')
                ->get();

            $secteurLabels  = [];
            $secteurBudget  = [];
            $secteurDemande = [];
            foreach ($finParSecteur as $row) {
                $secteurLabels[]  = optional($row->secteur)->nomSecteur ?? 'Non défini';
                $secteurBudget[]  = (int)$row->total_budget;
                $secteurDemande[] = (int)$row->total_demande;
            }

            // Évolution cumulative montants demandés par mois (12 derniers mois)
            $evolution = [];
            $cumul = 0;
            for ($i = 11; $i >= 0; $i--) {
                $mois  = $now->copy()->subMonths($i);
                $mois_total = Projet::whereYear('dateSoumission', $mois->year)
                    ->whereMonth('dateSoumission', $mois->month)
                    ->sum('montantDemande') ?? 0;
                $cumul += $mois_total;
                $evolution['labels'][] = $mois->format('M y');
                $evolution['values'][] = (int)$cumul;
            }

            //  6. HEATMAP SECTEURS
            $heatmap = Projet::with('secteur')
                ->select('secteur_id', 'statutProjet', DB::raw('COUNT(*) as total'))
                ->groupBy('secteur_id', 'statutProjet')
                ->get()
                ->groupBy('secteur_id');

            $heatSecteurs = [];
            $heatData     = [];
            foreach ($heatmap as $secteurId => $rows) {
                $nomSecteur     = optional($rows->first()->secteur)->nomSecteur ?? 'Non défini';
                $heatSecteurs[] = $nomSecteur;
                $heatData[]     = $rows->sum('total');
            }

            //  7. PERFORMANCE VALIDATEUR
            // NOTE : validated_at/validated_by renommés en dateValidation/validateur_id
            $validateur = Auth::user();
            $perfAujourdhui = Projet::whereNotNull('dateValidation')
                ->where('validateur_id', $validateur->id)
                ->whereDate('dateValidation', $now->toDateString())
                ->count();

            $perfSemaine = Projet::whereNotNull('dateValidation')
                ->where('validateur_id', $validateur->id)
                ->whereBetween('dateValidation', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
                ->count();

            $totalTraites = Projet::whereNotNull('dateValidation')
                ->where('validateur_id', $validateur->id)
                ->count();

            $totalValides = Projet::where('statutProjet', 'valide')
                ->where('validateur_id', $validateur->id)
                ->count();

            $tauxValidation = $totalTraites > 0
                ? round($totalValides / $totalTraites * 100)
                : 0;

            $enAttente = Projet::where('statutProjet', 'approuve')->count();

            $perf = [
                'aujourd_hui'    => $perfAujourdhui,
                'semaine'        => $perfSemaine,
                'total_traites'  => $totalTraites,
                'taux_validation'=> $tauxValidation,
                'en_attente'     => $enAttente,
            ];

            return view('analytique.index', compact(
                'entonnoir',
                'totalDemande',
                'totalBudget',
                'pctJauge',
                'donutLabels',
                'donutValues',
                'delais',
                'retard',
                'secteurLabels',
                'secteurBudget',
                'secteurDemande',
                'evolution',
                'heatSecteurs',
                'heatData',
                'perf'
            ));

        }catch (\Exception $e){
            Log::error('Erreur lors de la récuperation des données pour le tableau analytique du validateur', [
                'message' => $e->getMessage(),
                'validateur_id' =>Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }
}
