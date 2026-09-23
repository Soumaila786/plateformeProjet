<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\SecteurActivite;
use App\Models\SousDomaine;
use App\Models\TypeProjet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalytiqueController extends Controller
{
    public function index(Request $request)
    {
        $base = $this->filteredProjects($request);
        $now = Carbon::now();

        $total = (clone $base)->count();
        $soumis = (clone $base)->where('statutProjet', 'soumis')->count();
        $enCours = (clone $base)->whereIn('statutProjet', ['en_examen', 'approuve'])->count();
        $valides = (clone $base)->where('statutProjet', 'valide')->count();
        $rejetes = (clone $base)->where('statutProjet', 'rejete')->count();
        $brouillons = (clone $base)->where('statutProjet', 'brouillon')->count();
        $decidables = $total - $brouillons;

        $tauxValidation = $decidables > 0 ? round($valides / $decidables * 100) : 0;
        $tauxRejet = $decidables > 0 ? round($rejetes / $decidables * 100) : 0;

        $statuts = [
            'Brouillons' => $brouillons,
            'Soumis' => $soumis,
            'En cours' => $enCours,
            'Validés' => $valides,
            'Rejetés' => $rejetes,
        ];

        $moisLabels = [];
        $moisCrees = [];
        $moisSoumis = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = $now->copy()->subMonths($i);
            $moisLabels[] = $mois->format('M y');
            $moisCrees[] = (clone $base)->whereYear('created_at', $mois->year)
                ->whereMonth('created_at', $mois->month)->count();
            $moisSoumis[] = (clone $base)->whereYear('dateSoumission', $mois->year)
                ->whereMonth('dateSoumission', $mois->month)->count();
        }

        $secteurs = (clone $base)->with('secteur')
            ->select('secteur_id', DB::raw('COUNT(*) as total'))
            ->groupBy('secteur_id')->orderByDesc('total')->get();

        $budgetParDevise = (clone $base)
            ->selectRaw("COALESCE(budgetDevise, 'XOF') AS devise, SUM(budgetTotal) AS total")
            ->groupBy('budgetDevise')->pluck('total', 'devise');
        $demandeParDevise = (clone $base)
            ->selectRaw("COALESCE(montantDemandeDevise, 'XOF') AS devise, SUM(montantDemande) AS total")
            ->groupBy('montantDemandeDevise')->pluck('total', 'devise');
        $devises = $budgetParDevise->keys()->merge($demandeParDevise->keys())->unique()->values();

        $projetsRecents = (clone $base)->with(['secteur', 'typeProjet'])
            ->latest('updated_at')->take(5)->get();

        return view('analytique.index', [
            'total' => $total,
            'soumis' => $soumis,
            'enCours' => $enCours,
            'valides' => $valides,
            'rejetes' => $rejetes,
            'brouillons' => $brouillons,
            'tauxValidation' => $tauxValidation,
            'tauxRejet' => $tauxRejet,
            'statuts' => $statuts,
            'moisLabels' => $moisLabels,
            'moisCrees' => $moisCrees,
            'moisSoumis' => $moisSoumis,
            'secteursLabels' => $secteurs->map(fn ($item) => optional($item->secteur)->nomSecteur ?? 'Non défini')->values()->toArray(),
            'secteursValues' => $secteurs->pluck('total')->map(fn ($value) => (int) $value)->values()->toArray(),
            'devises' => $devises->toArray(),
            'budgetValues' => $devises->map(fn ($devise) => (float) ($budgetParDevise[$devise] ?? 0))->toArray(),
            'demandeValues' => $devises->map(fn ($devise) => (float) ($demandeParDevise[$devise] ?? 0))->toArray(),
            'projetsRecents' => $projetsRecents,
            'typesProjets' => TypeProjet::where('actif', true)->orderBy('nom')->get(),
            'secteursFiltres' => SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get(),
        ]);
    }

    private function filteredProjects(Request $request)
    {
        $query = Projet::where('user_id', Auth::id());

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

        return $query;
    }
}
