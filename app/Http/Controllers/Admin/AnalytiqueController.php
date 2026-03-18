<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnalytiqueController extends Controller {
    public function index()
    {
        $now = Carbon::now();

        // ════════ 1. KPIs ════════
        $kpis = [
            'total'     => Projet::count(),
            'brouillon' => Projet::where('statutProjet', 'brouillon')->count(),
            'soumis'    => Projet::where('statutProjet', 'soumis')->count(),
            'en_examen' => Projet::where('statutProjet', 'en_examen')->count(),
            'approuve'  => Projet::where('statutProjet', 'approuve')->count(),
            'rejete'    => Projet::where('statutProjet', 'rejete')->count(),
            'valide'    => Projet::where('statutProjet', 'valide')->count(),
        ];

        // ════════ 2. ENTONNOIR ════════
        $entonnoir = [
            ['lbl' => 'Brouillon',  'key' => 'brouillon', 'color' => '#9ca3af', 'val' => $kpis['brouillon']],
            ['lbl' => 'Soumis',     'key' => 'soumis',    'color' => '#6366f1', 'val' => $kpis['soumis']],
            ['lbl' => 'En examen',  'key' => 'en_examen', 'color' => '#f97316', 'val' => $kpis['en_examen']],
            ['lbl' => 'Approuvés',  'key' => 'approuve',  'color' => '#22c55e', 'val' => $kpis['approuve']],
            ['lbl' => 'Validés',    'key' => 'valide',    'color' => '#0d9488', 'val' => $kpis['valide']],
        ];
        // Forcer int sur toutes les valeurs de l'entonnoir
        foreach ($entonnoir as &$step) {
            $step['val'] = (int)($step['val'] ?? 0);
        }
        unset($step);
        $maxEntonnoir = max(1, collect($entonnoir)->max('val'));

        // ════════ 3. ÉVOLUTION MENSUELLE ════════
        $moisLabels  = [];
        $moisSoumis  = [];
        $moisValides = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $moisLabels[]  = $m->format('M y');
            $moisSoumis[]  = Projet::whereYear('dateSoumission', $m->year)
                ->whereMonth('dateSoumission', $m->month)->count();
            $moisValides[] = Projet::where('statutProjet', 'valide')
                ->whereYear('validated_at', $m->year)
                ->whereMonth('validated_at', $m->month)->count();
        }

        // ════════ 4. RÉPARTITION STATUTS ════════
        $statutLabels = ['Brouillon','Soumis','En examen','Approuvé','Rejeté','Validé'];
        $statutKeys   = ['brouillon','soumis','en_examen','approuve','rejete','valide'];
        $statutColors = ['#9ca3af','#6366f1','#f97316','#22c55e','#ef4444','#0d9488'];
        $statutValues = array_map(fn($k) => (int)($kpis[$k] ?? 0), $statutKeys);

        // ════════ 5. TOP SECTEURS ════════
        $secteurs = Projet::with('secteur')
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

        // ════════ 6. DÉLAIS MOYENS ════════
        $rawAppro = Projet::whereNotNull('dateApprobation')
            ->whereNotNull('dateSoumission')
            ->selectRaw('AVG(DATEDIFF(dateApprobation, dateSoumission)) as moy')
            ->value('moy');
        $delaiAppro = round((float)($rawAppro ?? 0), 1);

        $rawValid = Projet::whereNotNull('validated_at')
            ->whereNotNull('dateApprobation')
            ->selectRaw('AVG(DATEDIFF(validated_at, dateApprobation)) as moy')
            ->value('moy');
        $delaiValid = round((float)($rawValid ?? 0), 1);

        $rawTotal = Projet::whereNotNull('validated_at')
            ->whereNotNull('dateSoumission')
            ->selectRaw('AVG(DATEDIFF(validated_at, dateSoumission)) as moy')
            ->value('moy');
        $delaiTotal = round((float)($rawTotal ?? 0), 1);

        // ════════ 7. PERFORMANCE PORTEURS ════════
        $porteurs = Projet::select(
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

        // ════════ 8. ANALYSE REJETS ════════
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

        Projet::where('statutProjet', 'rejete')
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

        // ════════ 9. PROJETS EN ATTENTE CRITIQUE (> 10 jours) ════════
        $critiqueStatuts = ['soumis','en_examen','approuve'];
        $projetsBloque   = Projet::with(['porteur','secteur'])
            ->whereIn('statutProjet', $critiqueStatuts)
            ->where('updated_at', '<', $now->copy()->subDays(10))
            ->orderBy('updated_at')
            ->take(15)
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

        // ════════ 10. CHARGE DE TRAVAIL ÉQUIPES ════════
        $approbateurs = User::where('role', 'approbateur')->get()
            ->map(function ($u) {
                $nb = Projet::whereIn('statutProjet', ['approuve','rejete'])
                    ->whereNotNull('dateApprobation')
                    ->where('user_id', '!=', null) // sécurité
                    ->count();
                // On compte par porteur ici — à adapter si colonne approbateur_id existe
                return ['nom' => $u->nomComplet, 'nb' => (int)$nb, 'role' => 'Approbateur'];
            });

        $validateurs = User::where('role', 'validateur')->get()
            ->map(function ($u) {
                $nb = Projet::whereNotNull('validated_at')
                    ->where('validated_by', $u->id)->count();
                return ['nom' => $u->nomComplet, 'nb' => (int)$nb, 'role' => 'Validateur'];
            });

        $equipes      = $approbateurs->merge($validateurs)->sortByDesc('nb')->values();
        $equipeLabels = $equipes->pluck('nom')->toArray();
        $equipeNb     = $equipes->pluck('nb')->map(function($v) { return (int)($v ?? 0); })->toArray();
        $equipeRoles  = $equipes->pluck('role')->toArray();

        return view('admin.analytique', compact(
            'kpis',
            'entonnoir', 'maxEntonnoir',
            'moisLabels', 'moisSoumis', 'moisValides',
            'statutLabels', 'statutColors', 'statutValues',
            'sectLabels', 'sectNb', 'sectDemande', 'sectValide',
            'delaiAppro', 'delaiValid', 'delaiTotal',
            'porteurs',
            'motifsLabels', 'motifsValues',
            'projetsBloque',
            'equipeLabels', 'equipeNb', 'equipeRoles'
        ));
    }
}
