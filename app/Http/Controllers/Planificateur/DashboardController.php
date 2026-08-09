<?php

namespace App\Http\Controllers\Planificateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Activite;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {

    public function index() {

        try {
            // Demandes en attente (porteurs qui ont demandé planification)
            $demandesEnAttente = Projet::where('planification_demandee', true)
                                        ->count();

            // Projets déjà planifiés (traités)
            // NOTE : Planification a été fusionnée dans Activite
            $projetsTraites = Projet::where('planification_demandee', false)
                                    ->whereHas('activites')
                                    ->count();

            // Total projets
            $totalProjets = Projet::count();

            // Total activités de planification créées
            $totalActivites = Activite::count();

            // Activités créées ce mois-ci
            $activitesCeMois = Activite::whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->count();

            // Coût total de toutes les planifications
            $coutTotalPlanifie = Activite::sum('coutEstimatif');

            // 5 dernières demandes en attente
            $dernieresDemandes = Projet::with(['user', 'secteur'])
                                            ->where('planification_demandee', true)
                                            ->orderBy('updated_at', 'desc')
                                            ->take(5)
                                            ->get();

            // 5 projets récemment traités
            $projetsRecentsTraites = Projet::with(['user', 'secteur', 'activites'])
                                            ->where('planification_demandee', false)
                                            ->whereHas('activites')
                                            ->orderBy('updated_at', 'desc')
                                            ->take(5)
                                            ->get();

            // Notifications non lues
            $notifications = Notification::where('destinataire_id', Auth::id())
                                            ->where('statut', 'non_lu')
                                            ->orderBy('dateEnvoi', 'desc')
                                            ->take(3)
                                            ->get();

            return view('dashboard.index', compact(
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

        } catch (\Exception $e) {

            Log::error('Erreur lors du chargement du dashboard planificateur', [
                'message' => $e->getMessage(),
                'planificateur_id' => Auth::id(),
            ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }
}
