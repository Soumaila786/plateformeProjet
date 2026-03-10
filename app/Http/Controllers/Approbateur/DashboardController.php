<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;

class DashboardController extends Controller
{
    public function index()
    {
        $statuts = ['soumis', 'en_examen', 'approuve', 'rejete'];

        // Requête de base incluant les brouillons retournés après rejet
        $queryBase = Projet::where(function($q) use ($statuts) {
            $q->whereIn('statutProjet', $statuts)
              ->orWhere(function($q2) {
                  $q2->where('statutProjet', 'brouillon')->whereNotNull('motifRejet');
              });
        });

        $totalProjets = (clone $queryBase)->count();
        $soumis       = Projet::where('statutProjet', 'soumis')->count();
        $enExamen     = Projet::where('statutProjet', 'en_examen')->count();
        $approuves    = Projet::where('statutProjet', 'approuve')->count();
        $rejetes      = Projet::where('statutProjet', 'rejete')->count();
        $retournes    = Projet::where('statutProjet', 'brouillon')->whereNotNull('motifRejet')->count();
        $rejetes      = $rejetes + $retournes;
        $enAttente    = $soumis + $enExamen;

        $projetsRecents = (clone $queryBase)
            ->with(['porteur', 'secteur'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $projetsUrgents = Projet::whereIn('statutProjet', ['soumis', 'en_examen'])
            ->with(['porteur', 'secteur'])
            ->latest('dateSoumission')
            ->take(5)
            ->get();

        return view('approbateur.dashboard', compact(
            'totalProjets', 'soumis', 'enExamen', 'approuves',
            'rejetes', 'enAttente', 'projetsRecents', 'projetsUrgents'
        ));
    }
}
