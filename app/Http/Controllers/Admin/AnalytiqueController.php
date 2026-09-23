<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalytiqueController extends Controller {

    public function index(Request $request) {

        $now = Carbon::now();
        try{
            $base = $this->filteredProjects($request);
            $typesProjets = \App\Models\TypeProjet::orderBy('nom')->get();
            $secteursFiltres = \App\Models\SecteurActivite::orderBy('nomSecteur')->get();
            $porteursFiltres = User::where('role', 'porteur')->orderBy('nomComplet')->get();

            // 1. KPIs
            $kpis = [
                'total'     => (clone $base)->where('statutProjet', '!=', 'brouillon')->count(),
                'brouillon' => 0,
                'soumis'    => (clone $base)->where('statutProjet', 'soumis')->count(),
                'en_examen' => (clone $base)->where('statutProjet', 'en_examen')->count(),
                'approuve'  => (clone $base)->where('statutProjet', 'approuve')->count(),
                'rejete'    => (clone $base)->where('statutProjet', 'rejete')->count(),
                'valide'    => (clone $base)->where('statutProjet', 'valide')->count(),
            ];

            // 2. ENTONNOIR
            $entonnoir = [
                ['lbl' => 'Soumis',     'key' => 'soumis',    'color' => '#6366f1', 'val' => $kpis['soumis']],
                ['lbl' => 'En examen',  'key' => 'en_examen', 'color' => '#f97316', 'val' => $kpis['en_examen']],
                ['lbl' => 'Approuvés',  'key' => 'approuve',  'color' => '#22c55e', 'val' => $kpis['approuve']],
                ['lbl' => 'Validés',    'key' => 'valide',    'color' => '#0d9488', 'val' => $kpis['valide']],
            ];

            foreach ($entonnoir as &$step) {
                $step['val'] = (int)($step['val'] ?? 0);
            }
            unset($step);
            $maxEntonnoir = max(1, collect($entonnoir)->max('val'));

            // 3. ÉVOLUTION MENSUELLE
            $moisLabels  = [];
            $moisSoumis  = [];
            $moisValides = [];
            for ($i = 11; $i >= 0; $i--) {
                $m = $now->copy()->subMonths($i);
                $moisLabels[]  = $m->format('M y');
                $moisSoumis[]  = (clone $base)->whereYear('dateSoumission', $m->year)
                    ->whereMonth('dateSoumission', $m->month)->count();
                $moisValides[] = (clone $base)->where('statutProjet', 'valide')
                    ->whereYear('dateValidation', $m->year)
                    ->whereMonth('dateValidation', $m->month)->count();
            }

            // 4. RÉPARTITION STATUTS
            $statutLabels = ['Soumis','En examen','Approuvé','Rejeté','Validé'];
            $statutKeys   = ['soumis','en_examen','approuve','rejete','valide'];
            $statutColors = ['#6366f1','#f97316','#22c55e','#ef4444','#0d9488'];
            $statutValues = array_map(fn($k) => (int)($kpis[$k] ?? 0), $statutKeys);

            // 5. TOP SECTEURS
            $secteurs = (clone $base)->where('statutProjet', '!=', 'brouillon')
                ->with('secteur')
                ->select('secteur_id',
                    DB::raw('COUNT(*) as nb'),
                    DB::raw('SUM(montantDemande) as total_demande'),
                    DB::raw('SUM(CASE WHEN statutProjet="valide" THEN 1 ELSE 0 END) as nb_valide')
                )
                ->groupBy('secteur_id')
                ->orderByDesc('nb')
                ->take(8)
                ->get();

            $sectLabels  = $secteurs->map(function($r) { return optional($r->secteur)->nomSecteur ?? 'N/D'; })->toArray();
            $sectNb      = $secteurs->pluck('nb')->map(function($v) { return (int)($v ?? 0); })->toArray();
            $sectDemande = $secteurs->pluck('total_demande')->map(function($v) { return (int)($v ?? 0); })->toArray();
            $sectValide  = $secteurs->pluck('nb_valide')->map(function($v) { return (int)($v ?? 0); })->toArray();

            // 6. DÉLAIS MOYENS
            $rawAppro = (clone $base)->whereNotNull('dateApprobation')
                ->whereNotNull('dateSoumission')
                ->selectRaw('AVG(ABS(DATEDIFF(dateApprobation, dateSoumission))) as moy')
                ->value('moy');

            $delaiAppro = round((float)($rawAppro ?? 0), 1);

            $rawValid = (clone $base)->whereNotNull('dateValidation')
                ->whereNotNull('dateApprobation')
                ->selectRaw('AVG(ABS(DATEDIFF(dateValidation, dateApprobation))) as moy')
                ->value('moy');
            $delaiValid = round((float)($rawValid ?? 0), 1);

            $rawTotal = (clone $base)->whereNotNull('dateValidation')
                ->whereNotNull('dateSoumission')
                ->selectRaw('AVG(ABS(DATEDIFF(dateValidation, dateSoumission))) as moy')
                ->value('moy');
            $delaiTotal = round((float)($rawTotal ?? 0), 1);

            // 7. PERFORMANCE PORTEURS
            $porteurs = (clone $base)->where('statutProjet', '!=', 'brouillon')
                ->select(
                    'user_id',
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN statutProjet IN ("approuve","valide") THEN 1 ELSE 0 END) as reussis'),
                    DB::raw('SUM(CASE WHEN statutProjet = "rejete" THEN 1 ELSE 0 END) as rejetes')
                )
                ->with('porteur')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->take(10)
                ->get()
                ->map(function ($r) {
                    $total   = (int)($r->total ?? 0);
                    $reussis = (int)($r->reussis ?? 0);
                    return [
                        'nom'    => optional($r->porteur)->nomComplet ?? '—',
                        'email'  => optional($r->porteur)->email ?? '',
                        'total'  => $total,
                        'taux'   => $total > 0 ? round($reussis / $total * 100) : 0,
                        'rejete' => (int)($r->rejetes ?? 0),
                        ];
                        });

            // 8. ANALYSE REJETS
            $motifsCles = [
                'Budget'          => ['budget','montant','financier','coût','fonds','prix'],
                'Dossier incomplet' => ['pièce','document','dossier','manquant','incomplet','fichier'],
                'Non-éligibilité' => ['éligib','critère','condition','secteur','champ'],
                'Délai dépassé'   => ['délai','date','expir','retard','tardif'],
                'Doublon'         => ['doublon','existant','déjà','similaire'],
                'Autre'           => [],
            ];
            $motifsLabels = array_keys($motifsCles);
            $motifsValues = array_fill(0, count($motifsCles), 0);
            $motifsKeys   = array_keys($motifsCles);

            (clone $base)->where('statutProjet', 'rejete')
                ->with(['commentaires' => function ($q) {
                    $q->whereNotNull('message');
                }])
                ->get()
                ->pluck('commentaires')
                ->flatten()
                ->pluck('message')
                ->each(function ($motif) use (&$motifsValues, $motifsCles, $motifsKeys) {

                    $lower = mb_strtolower($motif);
                    $found = false;

                    foreach ($motifsCles as $i => $mots) {
                        $idx = array_search($i, $motifsKeys);

                        if ($i === 'Autre') break;

                        foreach ($mots as $mot) {
                            if (str_contains($lower, mb_strtolower($mot))) {
                                $motifsValues[$idx]++;
                                $found = true;
                                break 2;
                            }
                        }
                    }

                    if (!$found) {
                        $motifsValues[count($motifsValues) - 1]++;
                    }
                });

            // 9. PROJETS EN ATTENTE CRITIQUE (> 10 jours)
            $critiqueStatuts = ['soumis','en_examen','approuve'];
            $projetsBloque   = (clone $base)->with(['porteur','secteur'])
                ->whereIn('statutProjet', $critiqueStatuts)
                ->where('updated_at', '<', $now->copy()->subDays(10))
                ->orderBy('updated_at')
                ->take(5)
                ->get()
                ->map(function ($p) use ($now) {
                    return [
                        'id'      => $p->id,
                        'titre'   => $p->titre,
                        'statut'  => $p->statutProjet,
                        'porteur' => optional($p->porteur)->nomComplet ?? '—',
                        'secteur' => optional($p->secteur)->nomSecteur ?? '—',
                        'jours'   => $now->diffInDays(Carbon::parse($p->updated_at)),
                        'code'    => $p->codeProjet,
                    ];
                });

            // 10. CHARGE DE TRAVAIL ÉQUIPES
            // NOTE : avant cette correction, le nombre de dossiers traités par approbateur
            // ne filtrait pas réellement par approbateur (comptait tous les projets approuvés/
            // rejetés du système, même total pour tout le monde). Corrigé pour utiliser
            // approbateur_id, qui existe bien en base.
            $approbateurs = User::where('role', 'approbateur')
                ->get()
                ->map(function ($u) use ($base) {
                    $nb = (clone $base)->where('statutProjet', '!=', 'brouillon')
                        ->where('approbateur_id', $u->id)->count();
                    return ['nom' => $u->nomComplet, 'nb' => (int)$nb, 'role' => 'Approbateur'];
                });

            $validateurs = User::where('role', 'validateur')->get()
                ->map(function ($u) use ($base) {
                    $nb = (clone $base)->whereNotNull('dateValidation')
                        ->where('validateur_id', $u->id)->count();
                    return ['nom' => $u->nomComplet, 'nb' => (int)$nb, 'role' => 'Validateur'];
                });

            $equipes      = $approbateurs->merge($validateurs)->sortByDesc('nb')->values();
            $equipeLabels = $equipes->pluck('nom')->toArray();
            $equipeNb     = $equipes->pluck('nb')->map(function($v) { return (int)($v ?? 0); })->toArray();
            $equipeRoles  = $equipes->pluck('role')->toArray();

            return view('analytique.index', array_merge(compact(
                'kpis', 'entonnoir', 'maxEntonnoir', 'moisLabels',
                'moisSoumis', 'moisValides', 'statutLabels',
                'statutColors', 'statutValues', 'sectLabels',
                'sectNb', 'sectDemande', 'sectValide', 'delaiAppro',
                'delaiValid', 'delaiTotal', 'porteurs', 'motifsLabels',
                'motifsValues', 'projetsBloque', 'equipeLabels',
                'equipeNb', 'equipeRoles', 'typesProjets'
            ), [
                'secteursFiltres' => $secteursFiltres,
                'porteursFiltres' => $porteursFiltres,
            ]));
        }catch(\Exception $e){
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    private function filteredProjects(Request $request)
    {
        $query = Projet::query();

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        if ($request->filled('type_projet_id')) {
            $query->where('type_projet_id', $request->type_projet_id);
        }
        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return $query;
    }
}
