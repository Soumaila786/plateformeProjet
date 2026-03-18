<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalytiqueController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ════════ 1. ENTONNOIR ════════
        $entonnoir = [
            ['lbl'=>'Soumis',    'key'=>'soumis',    'color'=>'#6366f1'],
            ['lbl'=>'En examen', 'key'=>'en_examen', 'color'=>'#f97316'],
            ['lbl'=>'Approuvés', 'key'=>'approuve',  'color'=>'#22c55e'],
            ['lbl'=>'Validés',   'key'=>'valide',    'color'=>'#0d9488'],
        ];
        $totalSoumis = max(1, Projet::where('statutProjet', 'soumis')->count()
            + Projet::where('statutProjet', 'en_examen')->count()
            + Projet::where('statutProjet', 'approuve')->count()
            + Projet::where('statutProjet', 'valide')->count()
            + Projet::where('statutProjet', 'rejete')->count());

        foreach ($entonnoir as &$step) {
            $step['val'] = Projet::where('statutProjet', $step['key'])->count();
            $step['pct'] = round($step['val'] / $totalSoumis * 100);
        }
        unset($step);

        // ════════ 2. DONUT STATUTS ════════
        $statuts = ['brouillon','soumis','en_examen','approuve','valide','rejete'];
        $labels  = ['Brouillon','Soumis','En examen','Approuvé','Validé','Rejeté'];
        $colors  = ['#9ca3af','#6366f1','#f97316','#22c55e','#0d9488','#ef4444'];
        $donutValues = [];
        foreach ($statuts as $s) {
            $donutValues[] = Projet::where('statutProjet', $s)->count();
        }

        // ════════ 3. ANALYSE TEMPORELLE ════════
        // Soumissions par mois (12 derniers mois)
        $tempLabels   = [];
        $tempSoumis   = [];
        $tempCreation = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $tempLabels[]   = $m->format('M y');
            $tempSoumis[]   = Projet::whereYear('dateSoumission', $m->year)
                ->whereMonth('dateSoumission', $m->month)->count();
            $tempCreation[] = Projet::whereYear('dateCreation', $m->year)
                ->whereMonth('dateCreation', $m->month)->count();
        }

        // Délai moyen soumission → approbation
        $delaiMoyenAppro = Projet::whereNotNull('dateApprobation')
            ->whereNotNull('dateSoumission')
            ->selectRaw('AVG(DATEDIFF(dateApprobation, dateSoumission)) as moy')
            ->value('moy') ?? 0;

        // ════════ 4. ANALYSE BUDGÉTAIRE ════════
        // Budget vs demande par projet (top 8 par montant)
        $budgetProjets = Projet::whereNotNull('montantDemande')
            ->orderByDesc('montantDemande')
            ->take(8)
            ->get(['titre', 'budgetTotal', 'montantDemande']);

        $budgetLabels  = $budgetProjets->map(fn($p) => \Str::limit($p->titre, 15))->toArray();
        $budgetTotaux  = $budgetProjets->pluck('budgetTotal')->map(fn($v) => (int)$v)->toArray();
        $budgetDemande = $budgetProjets->pluck('montantDemande')->map(fn($v) => (int)$v)->toArray();

        // Cumul demandes en attente (soumis + en_examen)
        $cumulAttente = Projet::whereIn('statutProjet', ['soumis', 'en_examen'])
            ->sum('montantDemande') ?? 0;

        // Distribution montants (tranches)
        $tranches = [
            '< 1M'    => Projet::where('montantDemande', '<',  1000000)->count(),
            '1-5M'    => Projet::whereBetween('montantDemande', [1000000, 4999999])->count(),
            '5-10M'   => Projet::whereBetween('montantDemande', [5000000, 9999999])->count(),
            '10-50M'  => Projet::whereBetween('montantDemande', [10000000, 49999999])->count(),
            '> 50M'   => Projet::where('montantDemande', '>=', 50000000)->count(),
        ];

        // ════════ 5. DÉLAIS ════════
        $delaiAppro = round(Projet::whereNotNull('dateApprobation')
            ->whereNotNull('dateSoumission')
            ->selectRaw('AVG(DATEDIFF(dateApprobation, dateSoumission)) as moy')
            ->value('moy') ?? 0, 1);

        $delaiValid = round(Projet::whereNotNull('validated_at')
            ->whereNotNull('dateApprobation')
            ->selectRaw('AVG(DATEDIFF(validated_at, dateApprobation)) as moy')
            ->value('moy') ?? 0, 1);

        $retard30 = Projet::whereIn('statutProjet', ['soumis','en_examen'])
            ->where('dateSoumission', '<', $now->copy()->subDays(30))->count();

        $retard15 = Projet::whereIn('statutProjet', ['soumis','en_examen'])
            ->where('dateSoumission', '<', $now->copy()->subDays(15))->count();

        // ════════ 6. MOTIFS DE REJET ════════
        $motifsCles = [
            'budget'     => ['Budget','montant','financier','coût','fonds'],
            'dossier'    => ['pièce','document','dossier','manquant','incomplet'],
            'eligibilite'=> ['éligib','critère','condition','secteur'],
            'delai'      => ['délai','date','expir','retard'],
            'autre'      => [],
        ];
        $motifsLabels = ['Budget','Dossier incomplet','Non-éligibilité','Délai dépassé','Autre'];
        $motifsValues = array_fill(0, 5, 0);

        $rejets = Projet::where('statutProjet', 'rejete')
                            ->with(['commentaires' => function ($q) {
                                $q->whereNotNull('message');
                            }])
                            ->get()
                            ->pluck('commentaires')
                            ->flatten()
                            ->pluck('message');

        foreach ($rejets as $motif) {
            $motifLower = mb_strtolower($motif);
            $found = false;
            $i = 0;
            foreach ($motifsCles as $cat => $mots) {
                if ($cat === 'autre') break;
                foreach ($mots as $mot) {
                    if (str_contains($motifLower, mb_strtolower($mot))) {
                        $motifsValues[$i]++;
                        $found = true;
                        break 2;
                    }
                }
                $i++;
            }
            if (!$found) $motifsValues[4]++;
        }

        // ════════ 7. PAR SECTEUR ════════
        $secteursData = Projet::with('secteur')
            ->select('secteur_id',
                DB::raw('COUNT(*) as nb'),
                DB::raw('SUM(montantDemande) as total_demande')
            )
            ->groupBy('secteur_id')
            ->get();

        $sectLabels  = $secteursData->map(fn($r) => optional($r->secteur)->nomSecteur ?? 'N/D')->toArray();
        $sectNb      = $secteursData->pluck('nb')->map(fn($v) => (int)$v)->toArray();
        $sectDemande = $secteursData->pluck('total_demande')->map(fn($v) => (int)$v)->toArray();

        // ════════ 8. TIMELINE ════════
        $timeline = Projet::whereNotNull('dateDebut')
            ->whereIn('statutProjet', ['approuve','valide'])
            ->orderBy('dateDebut')
            ->take(10)
            ->get(['titre','dateDebut','dateFin','statutProjet']);

        // ════════ 9. TOP PORTEURS ════════
        $topPorteurs = Projet::select(
                'user_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN statutProjet = "approuve" OR statutProjet = "valide" THEN 1 ELSE 0 END) as approuves')
            )
            ->with('porteur')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->take(8)
            ->get()
            ->map(function($r) {
                return [
                    'nom'    => optional($r->porteur)->nomComplet ?? '—',
                    'total'  => (int)$r->total,
                    'taux'   => $r->total > 0 ? round($r->approuves / $r->total * 100) : 0,
                ];
            });

        // ════════ 10. MATRICE PRIORISATION ════════
        // Axe X = montantDemande (importance), Axe Y = duree (urgence)
        $matrice = Projet::whereIn('statutProjet', ['soumis','en_examen'])
            ->whereNotNull('montantDemande')
            ->take(20)
            ->get(['titre','montantDemande','duree','dateSoumission'])
            ->map(function($p) use ($now) {
                return [
                    'label'   => \Str::limit($p->titre, 18),
                    'x'       => (int)($p->montantDemande / 1000000), // en millions
                    'y'       => (int)($p->duree ?? 0),
                    'age'     => $p->dateSoumission
                        ? $now->diffInDays(Carbon::parse($p->dateSoumission))
                        : 0,
                ];
            });

        return view('approbateur.analytique', compact(
            'entonnoir',
            'labels', 'colors', 'donutValues',
            'tempLabels', 'tempSoumis', 'tempCreation', 'delaiMoyenAppro',
            'budgetLabels', 'budgetTotaux', 'budgetDemande', 'cumulAttente', 'tranches',
            'delaiAppro', 'delaiValid', 'retard30', 'retard15',
            'motifsLabels', 'motifsValues',
            'sectLabels', 'sectNb', 'sectDemande',
            'timeline',
            'topPorteurs',
            'matrice'
        ));
    }
}
