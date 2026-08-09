<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Projet;
use App\Models\SecteurActivite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {

    public function index() {

        try{

            //  Projets
            $projetsParStatut = Projet::selectRaw('statutProjet, count(*) as total')
                ->groupBy('statutProjet')
                ->pluck('total', 'statutProjet');

            $totalProjets     = Projet::count();
            $projetsBrouillon = $projetsParStatut->get('brouillon', 0);
            $projetsSoumis    = $projetsParStatut->get('soumis', 0);
            $projetsEnExamen  = $projetsParStatut->get('en_examen', 0);
            $projetsApprouves = $projetsParStatut->get('approuve', 0);
            $projetsValides   = $projetsParStatut->get('valide', 0);
            $projetsRejetes   = $projetsParStatut->get('rejete', 0);

            //  Utilisateurs
            $totalUsers    = User::count();
            $usersActifs   = User::where('actif', true)->count();
            $usersInactifs = User::where('actif', false)->count();
            $usersByRole   = User::selectRaw('role, count(*) as total')
                ->groupBy('role')->pluck('total', 'role');

            //  Secteurs
            $totalSecteurs  = SecteurActivite::count();
            $secteursActifs = SecteurActivite::where('statutSecteur', true)->count();

            //  Projets bloqués (> 10j sans changement)
            $projetsBloquesCount = Projet::whereIn('statutProjet', ['soumis','en_examen','approuve'])
                ->where('updated_at', '<', Carbon::now()->subDays(10))->count();

            //  Projets récents
            $projetsRecents = Projet::with(['porteur','secteur'])
            ->latest('updated_at')->take(6)->get();

            //  Utilisateurs récents
            $usersRecents = User::latest()->take(5)->get();

            return view('dashboard.index', compact(
                'totalProjets','projetsBrouillon','projetsSoumis','projetsEnExamen',
                'projetsApprouves','projetsValides','projetsRejetes',
                'totalUsers','usersActifs','usersInactifs','usersByRole',
                'totalSecteurs','secteursActifs', 'projetsBloquesCount',
                'projetsRecents','usersRecents'
            ));

        }catch(\Exception $e){

            // NOTE : avant cette correction, l'erreur n'était ni loguée ni réellement
            // affichée (with() ne prend que 2 arguments, le 3e était silencieusement
            // ignoré) — un plantage ici passait totalement inaperçu.
            Log::error('Erreur lors du chargement du dashboard admin', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id(),
            ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }
}
