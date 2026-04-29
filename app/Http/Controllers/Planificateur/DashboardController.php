<?php

namespace App\Http\Controllers\Planificateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {

        // Demandes en attente (porteurs qui ont demandé planification)
        $demandesEnAttente = Projet::where('planification_demandee', true)
                                    ->count();

        // Projets déjà planifiés (traités)
        $projetsTraites = Projet::where('planification_demandee', false)
                                ->whereHas('planifications')
                                ->count();

        // Total projets
        $totalProjets = Projet::count();

        // Total activités de planification créées
        $totalActivites = Planification::count();

        // Activités créées ce mois-ci
        $activitesCeMois = Planification::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count();

        // Coût total de toutes les planifications
        $coutTotalPlanifie = Planification::sum('coutEstimatif');

        // 5 dernières demandes en attente
        $dernieresDemandes = Projet::with(['user', 'secteur'])
                                        ->where('planification_demandee', true)
                                        ->orderBy('updated_at', 'desc')
                                        ->take(5)
                                        ->get();

        // 5 projets récemment traités
        $projetsRecentsTraites = Projet::with(['user', 'secteur', 'planifications'])
                                        ->where('planification_demandee', false)
                                        ->whereHas('planifications')
                                        ->orderBy('updated_at', 'desc')
                                        ->take(5)
                                        ->get();

        // Notifications non lues
        $notifications = Notification::where('destinataire_id', Auth::id())
                                        ->where('statut', 'non_lu')
                                        ->orderBy('dateEnvoi', 'desc')
                                        ->take(3)
                                        ->get();

        return view('planificateur.dashboard', compact(
            'demandesEnAttente',
            'projetsTraites',
            'totalProjets',
            'totalActivites',
            'activitesCeMois',
            'coutTotalPlanifie',
            'dernieresDemandes',
            'projetsRecentsTraites',
            'notifications'
        ));
    }
}