<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Commentaire;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnalytiqueController extends Controller {

    public function index(Request $request) {

        $now = Carbon::now();

        try{
            $base = $this->filteredProjects($request);
            $typesProjets = \App\Models\TypeProjet::orderBy('nom')->get();
            $secteursFiltres = \App\Models\SecteurActivite::orderBy('nomSecteur')->get();
            $porteursFiltres = \App\Models\User::where('role', 'porteur')->orderBy('nomComplet')->get();
            //  1. ENTONNOIR
            $entonnoir = [
            ['lbl'=>'Soumis',    'key'=>'soumis',    'color'=>'#6366f1'],
            ['lbl'=>'En examen', 'key'=>'en_examen', 'color'=>'#f97316'],
            ['lbl'=>'Approuvés', 'key'=>'approuve',  'color'=>'#22c55e'],
            ['lbl'=>'Validés',   'key'=>'valide',    'color'=>'#0d9488'],
            ];

            $totalSoumis = max(1, (clone $base)->whereIn('statutProjet', ['soumis', 'en_examen', 'approuve', 'valide', 'rejete'])->count());

            foreach ($entonnoir as &$step) {
                $step['val'] = (clone $base)->where('statutProjet', $step['key'])->count();
                $step['pct'] = round($step['val'] / $totalSoumis * 100);
                }
                unset($step);

            //============== DONUT STATUTS =============================================================

            $statuts = ['soumis','en_examen','approuve','valide','rejete'];
            $labels  = ['Soumis','En examen','Approuvé','Validé','Rejeté'];
            $colors  = ['#6366f1','#f97316','#22c55e','#0d9488','#ef4444'];
            $donutValues = [];
            foreach ($statuts as $s) {
                $donutValues[] = (clone $base)->where('statutProjet', $s)->count();
            }

            //========== ANALYSE TEMPORELLE =============================================================
            // Soumissions par mois (12 derniers mois)
            $tempLabels   = [];
            $tempSoumis   = [];
            $tempCreation = [];
            for ($i = 11; $i >= 0; $i--) {
                $m = $now->copy()->subMonths($i);
                $tempLabels[]   = $m->format('M y');
                $tempSoumis[]   = (clone $base)->whereYear('dateSoumission', $m->year)
                    ->whereMonth('dateSoumission', $m->month)->count();
                // NOTE : dateCreation a été supprimée (redondante avec created_at)
                $tempCreation[] = (clone $base)->whereYear('created_at', $m->year)
                    ->whereMonth('created_at', $m->month)->count();
            }

            // Délai moyen soumission → approbation
            $delaiMoyenAppro = (clone $base)->whereNotNull('dateApprobation')
            ->whereNotNull('dateSoumission')
            ->selectRaw('AVG(ABS(DATEDIFF(dateApprobation, dateSoumission))) as moy')
                ->value('moy') ?? 0;

            //================== ANALYSE BUDGÉTAIRE =============================================================
            // Budget vs demande par projet (top 8 par montant)
            $budgetProjets = (clone $base)->whereNotNull('montantDemande')
                ->orderByDesc('montantDemande')
                ->take(8)
                ->get(['titre', 'budgetTotal', 'montantDemande']);

            $budgetLabels  = $budgetProjets->map(fn($p) => Str::limit($p->titre, 15))->toArray();
            $budgetTotaux  = $budgetProjets->pluck('budgetTotal')->map(fn($v) => (int)$v)->toArray();
            $budgetDemande = $budgetProjets->pluck('montantDemande')->map(fn($v) => (int)$v)->toArray();

            // Cumul demandes en attente (soumis + en_examen)
            $cumulAttente = (clone $base)->whereIn('statutProjet', ['soumis', 'en_examen'])
            ->sum('montantDemande') ?? 0;

            // Distribution montants (tranches)
            $tranches = [
                '< 1M'    => (clone $base)->where('montantDemande', '<',  1000000)->count(),
                '1-5M'    => (clone $base)->whereBetween('montantDemande', [1000000, 4999999])->count(),
                '5-10M'   => (clone $base)->whereBetween('montantDemande', [5000000, 9999999])->count(),
                '10-50M'  => (clone $base)->whereBetween('montantDemande', [10000000, 49999999])->count(),
                '> 50M'   => (clone $base)->where('montantDemande', '>=', 50000000)->count(),
            ];

           //================ DÉLAIS =============================================================
            $delaiAppro = round((clone $base)->whereNotNull('dateApprobation')
                ->whereNotNull('dateSoumission')
                ->selectRaw('AVG(ABS(DATEDIFF(dateApprobation, dateSoumission))) as moy')
                ->value('moy') ?? 0, 1);

            // NOTE : validated_at renommé en dateValidation
            $delaiValid = round((clone $base)->whereNotNull('dateValidation')
                ->whereNotNull('dateApprobation')
                ->selectRaw('AVG(ABS(DATEDIFF(dateValidation, dateApprobation))) as moy')
                ->value('moy') ?? 0, 1);

                $retard30 = (clone $base)->whereIn('statutProjet', ['soumis','en_examen'])
                ->where('dateSoumission', '<', $now->copy()->subDays(30))->count();

            $retard15 = (clone $base)->whereIn('statutProjet', ['soumis','en_examen'])
                ->where('dateSoumission', '<', $now->copy()->subDays(15))->count();

            //===============MOTIFS DE REJET (basé sur les commentaires)=====================================================
            $motifsCles = [
                'budget'      => ['budget','montant','financier','coût','fonds'],
                'dossier'     => ['pièce','document','dossier','manquant','incomplet'],
                'eligibilite' => ['éligib','critère','condition','secteur'],
                'delai'       => ['objectifs','date','description','duree'],
                'autre'       => [],
            ];
            $motifsLabels = [ 'Budget', 'Dossier incomplet', 'Non-éligibilité', 'Données manquantes', 'Autre' ];

            $motifsValues = array_fill(0, count($motifsLabels), 0);

            $commentaires = Commentaire::query()
                ->whereIn('projet_id', (clone $base)->select('id'))
                ->whereNotNull('message')
                ->where('message', '!=', '')
                ->pluck('message');

            foreach ($commentaires as $message) {

                $message = mb_strtolower($message);
                $categorieTrouvee = false;
                $index = 0;

                foreach ($motifsCles as $categorie => $motsCles) {
                    if ($categorie === 'autre') {
                        continue;
                    }
                    foreach ($motsCles as $mot) {
                        if (str_contains($message, $mot)) {
                            $motifsValues[$index]++;
                            $categorieTrouvee = true;
                            break 2;
                        }
                        }
                        $index++;
                }
                if (!$categorieTrouvee) {
                    $motifsValues[count($motifsValues) - 1]++;
                }
            }
            //============ Par secteur =============================================================
            $secteursData = (clone $base)->with('secteur')
            ->select('secteur_id',
            DB::raw('COUNT(*) as nb'),
            DB::raw('SUM(montantDemande) as total_demande')
                )
                ->groupBy('secteur_id')
                ->get();

            $sectLabels  = $secteursData->map(fn($r) => optional($r->secteur)->nomSecteur ?? 'N/D')->toArray();
            $sectNb      = $secteursData->pluck('nb')->map(fn($v) => (int)$v)->toArray();
            $sectDemande = $secteursData->pluck('total_demande')->map(fn($v) => (int)$v)->toArray();

            //================ TIMELINE =============================================================
            $timeline = (clone $base)->whereNotNull('dateDebut')
                ->whereIn('statutProjet', ['approuve','valide'])
                ->orderBy('dateDebut')
                ->take(5)
                ->get(['titre','dateDebut','dateFin','statutProjet']);

            //=========== TOP PORTEURS =============================================================
            $topPorteurs = (clone $base)->select(
                'user_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN statutProjet = "approuve" OR statutProjet = "valide" THEN 1 ELSE 0 END) as approuves')
                )
                ->with('porteur')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->take(5)
                ->get()
                ->map(function($r) {
                    return [
                        'nom'    => optional($r->porteur)->nomComplet ?? '—',
                        'total'  => (int)$r->total,
                        'taux'   => $r->total > 0 ? round($r->approuves / $r->total * 100) : 0,
                    ];
                });

            //================= MATRICE PRIORISATION =============================================================
            $matrice = (clone $base)->whereIn('statutProjet', ['soumis','en_examen'])
                ->whereNotNull('montantDemande')
                ->take(20)
                ->get(['titre','montantDemande','duree','dateSoumission'])
                ->map(function($p) use ($now) {
                    return [
                        'label'   => Str::limit($p->titre, 18),
                        'x'       => (int)($p->montantDemande / 1000000),
                        'y'       => (int)($p->duree ?? 0),
                        'age'     => $p->dateSoumission
                            ? $now->diffInDays(Carbon::parse($p->dateSoumission))
                            : 0,
                    ];
                });

            return view('analytique.index', compact(
                'entonnoir', 'labels', 'colors', 'donutValues',
                'tempLabels', 'tempSoumis', 'tempCreation', 'delaiMoyenAppro',
                'budgetLabels', 'budgetTotaux', 'budgetDemande', 'cumulAttente',
                'tranches', 'delaiAppro', 'delaiValid', 'retard30',
                'retard15', 'motifsLabels', 'motifsValues', 'sectLabels',
                'sectNb', 'sectDemande', 'timeline', 'topPorteurs', 'matrice',
                'typesProjets', 'secteursFiltres', 'porteursFiltres'
            ));

        }catch(\Exception $e){

            Log::error('Erreur lors du chargement de l’analytique approbateur', [
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id(),
            ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    private function filteredProjects(Request $request)
    {
        $query = Projet::query();
        if ($request->filled('date_debut')) $query->whereDate('created_at', '>=', $request->date_debut);
        if ($request->filled('date_fin')) $query->whereDate('created_at', '<=', $request->date_fin);
        if ($request->filled('type_projet_id')) $query->where('type_projet_id', $request->type_projet_id);
        if ($request->filled('secteur_id')) $query->where('secteur_id', $request->secteur_id);
        if ($request->filled('user_id')) $query->where('user_id', $request->user_id);
        return $query;
    }
}
