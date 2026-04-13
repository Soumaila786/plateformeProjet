<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;

class DashboardController extends Controller {

    public function index() {

        try{

            $totalProjets = Projet::count();
            $soumis       = Projet::where('statutProjet', 'soumis')->count();
            $enExamen     = Projet::where('statutProjet', 'en_examen')->count();
            $approuve     = Projet::where('statutProjet', 'approuve')->count();
            $valide       = Projet::where('statutProjet', 'valide')->count();
            $rejete       = Projet::where('statutProjet', 'rejete')->count();
            $brouillon    = Projet::where('statutProjet', 'brouillon')->count();

            // Actions urgentes = soumis + en_examen
            $enAttente = $soumis + $enExamen;

            $projetsRecents = Projet::with(['secteur', 'porteur'])
                ->whereIn('statutProjet', ['soumis', 'en_examen', 'approuve', 'rejete'])
                ->latest('updated_at')
                ->take(5)
                ->get();

            $projetsUrgents = Projet::with(['porteur'])
                ->whereIn('statutProjet', ['soumis', 'en_examen'])
                ->latest('dateSoumission')
                ->get();

                return view('approbateur.dashboard', compact(
                    'totalProjets', 'soumis', 'enExamen', 'approuve',
                    'valide', 'rejete', 'brouillon', 'enAttente',
                    'projetsRecents', 'projetsUrgents'
                    ));
        }catch(\Exception $e){

            return back()->with('error', 'Une erreur est survenue ', $e->getMessage());
        }
    }
}
