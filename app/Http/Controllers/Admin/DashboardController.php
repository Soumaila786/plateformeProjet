<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Projet;
use App\Models\SecteurActivite;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        // ── Projets ──
        $projetsParStatut = Projet::selectRaw('statutProjet, count(*) as total')
            ->groupBy('statutProjet')->pluck('total', 'statutProjet');

        $totalProjets     = Projet::count();
        $projetsBrouillon = $projetsParStatut->get('brouillon', 0);
        $projetsSoumis    = $projetsParStatut->get('soumis', 0);
        $projetsEnExamen  = $projetsParStatut->get('en_examen', 0);
        $projetsApprouves = $projetsParStatut->get('approuve', 0);
        $projetsValides   = $projetsParStatut->get('valide', 0);
        $projetsRejetes   = $projetsParStatut->get('rejete', 0);

        // ── Utilisateurs ──
        $totalUsers    = User::count();
        $usersActifs   = User::where('actif', true)->count();
        $usersInactifs = User::where('actif', false)->count();
        $usersByRole   = User::selectRaw('role, count(*) as total')
            ->groupBy('role')->pluck('total', 'role');

        // ── Secteurs ──
        $totalSecteurs  = SecteurActivite::count();
        $secteursActifs = SecteurActivite::where('statutSecteur', true)->count();

        // ── Projets bloqués (> 10j sans changement) ──
        $projetsBloquesCount = Projet::whereIn('statutProjet', ['soumis','en_examen','approuve'])
            ->where('updated_at', '<', Carbon::now()->subDays(10))->count();

        // ── Projets récents ──
        $projetsRecents = Projet::with(['porteur','secteur'])
            ->latest('updated_at')->take(6)->get();

        // ── Utilisateurs récents ──
        $usersRecents = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProjets','projetsBrouillon','projetsSoumis','projetsEnExamen',
            'projetsApprouves','projetsValides','projetsRejetes',
            'totalUsers','usersActifs','usersInactifs','usersByRole',
            'totalSecteurs','secteursActifs',
            'projetsBloquesCount',
            'projetsRecents','usersRecents'
        ));
    }
}
