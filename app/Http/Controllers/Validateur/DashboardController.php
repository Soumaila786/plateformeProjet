<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        Gate::authorize('access-validateur');

        // Projets approuvés en attente de validation
        $aValider     = Projet::where('statutProjet', 'approuve')->count();
        $valides      = Projet::where('statutProjet', 'valide')->count();
        $rejetes      = Projet::where('statutProjet', 'rejete')->count();
        $totalProjets = Projet::count();

        // Projets récents à valider
        $projetsRecents = Projet::with(['porteur', 'secteur'])
                                ->where('statutProjet', 'approuve')
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

        return view('validateur.dashboard', compact(
            'aValider', 'valides', 'rejetes',
            'totalProjets', 'projetsRecents'
        ));
    }
}
