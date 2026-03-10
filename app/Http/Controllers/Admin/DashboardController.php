<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Projet;
use App\Models\SecteurActivite;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        Gate::authorize('access-admin');

        // ── Statistiques utilisateurs ──
        $totalUsers       = User::count();
        $usersActifs      = User::where('actif', true)->count();
        $usersInactifs    = User::where('actif', false)->count();
        $usersByRole      = User::selectRaw('role, count(*) as total')
                                ->groupBy('role')
                                ->pluck('total', 'role');

        // ── Statistiques projets ──
        $totalProjets     = Projet::count();
        $projetsParStatut = Projet::selectRaw('statutProjet, count(*) as total')
                                    ->groupBy('statutProjet')
                                    ->pluck('total', 'statutProjet');

        $projetsBrouillon = $projetsParStatut->get('brouillon', 0);
        $projetsSoumis    = $projetsParStatut->get('soumis', 0);
        $projetsEnExamen  = $projetsParStatut->get('en_examen', 0);
        $projetsApprouves = $projetsParStatut->get('approuve', 0);
        $projetsValides   = $projetsParStatut->get('valide', 0);
        $projetsRejetes   = $projetsParStatut->get('rejete', 0);

        // ── Statistiques secteurs ──
        $totalSecteurs    = SecteurActivite::count();
        $secteursActifs   = SecteurActivite::where('statutSecteur', true)->count();

        // ── Projets récents ──
        $projetsRecents   = Projet::with(['porteur', 'secteur'])
                                    ->latest('dateCreation')
                                    ->take(5)
                                    ->get();

        // ── Utilisateurs récents ──
        $usersRecents     = User::latest('dateCreation')
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'usersActifs', 'usersInactifs', 'usersByRole',
            'totalProjets', 'projetsBrouillon', 'projetsSoumis',
            'projetsEnExamen', 'projetsApprouves', 'projetsValides', 'projetsRejetes',
            'totalSecteurs', 'secteursActifs',
            'projetsRecents', 'usersRecents'
        ));
    }
}
