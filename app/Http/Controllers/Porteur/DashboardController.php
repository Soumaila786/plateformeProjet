<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Stats projets
        $projets      = Projet::where('user_id', $userId)->get();
        $total        = $projets->count();
        $brouillon    = $projets->where('statutProjet', 'brouillon')->count();
        $soumis       = $projets->where('statutProjet', 'soumis')->count();
        $enExamen     = $projets->where('statutProjet', 'en_examen')->count();
        $approuve     = $projets->where('statutProjet', 'approuve')->count();
        $valide       = $projets->where('statutProjet', 'valide')->count();
        $rejete       = $projets->where('statutProjet', 'rejete')->count();

        // Budgets
        $budgetTotal     = $projets->sum('budgetTotal');
        $montantDemande  = $projets->sum('montantDemande');

        // Montant financé = somme des activités financées sur les projets de ce porteur
        $projetIds       = $projets->pluck('id');
        $montantFinance  = \App\Models\Planification::whereIn('projet_id', $projetIds)
            ->where('statutActivite', 'financee')
            ->sum('montantDemande');

        // Notifications récentes non lues
        $notifications = Notification::where('destinataire_id', $userId)
            ->where('statut', 'non_lu')
            ->with('projet')
            ->orderBy('dateEnvoi', 'desc')
            ->take(5)
            ->get();

        // Projets récents
        $projetsRecents = Projet::with('secteur')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('porteur.dashboard', compact(
            'total', 'brouillon', 'soumis', 'enExamen', 'approuve', 'valide', 'rejete',
            'budgetTotal', 'montantDemande', 'montantFinance',
            'notifications', 'projetsRecents'
        ));
    }
}
