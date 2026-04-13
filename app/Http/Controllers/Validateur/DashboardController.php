<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;

class DashboardController extends Controller {
    public function index() {

        try{
            $totalProjets = Projet::count();
            $soumis       = Projet::where('statutProjet', 'soumis')->count();
            $enAttente    = Projet::where('statutProjet', 'approuve')->count();
            $valides      = Projet::where('statutProjet', 'valide')->count();
            $rejetes      = Projet::where('statutProjet', 'rejete')->count();

            $projetsRecents = Projet::with(['secteur', 'porteur'])
                ->whereIn('statutProjet', ['approuve', 'valide', 'rejete'])
                ->latest('updated_at')
                ->take(5)
                ->get();

            $projetsUrgents = Projet::with(['secteur', 'porteur'])
                ->where('statutProjet', 'approuve')
                ->latest('updated_at')
                ->get();

            return view('validateur.dashboard', compact(
                'totalProjets',
                'soumis',
                'enAttente',
                'valides',
                'rejetes',
                'projetsRecents',
                'projetsUrgents'
            ));

        }catch (\Exception $e){

            return back()->with('error', 'Une erreur est survenue', $e->getMessage());
        }
    }
}
