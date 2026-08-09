<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller {

    public function index() {

    try{

        $user = Auth::user();
        $base = Projet::where('user_id', $user->id);

        $total     = (clone $base)->count();
        $brouillon = (clone $base)->where('statutProjet', 'brouillon')->count();
        $soumis    = (clone $base)->where('statutProjet', 'soumis')->count();
        $enExamen  = (clone $base)->where('statutProjet', 'en_examen')->count();
        $approuve  = (clone $base)->where('statutProjet', 'approuve')->count();
        $valide    = (clone $base)->where('statutProjet', 'valide')->count();
        $rejete    = (clone $base)->where('statutProjet', 'rejete')->count();

        // NOTE : 'finance' n'est pas un statut valide pour statutProjet
        // (seules les activités ont un statut 'financee', pas les projets).
        // Laissé à 0 en placeholder, comme montantFinance ci-dessous.
        $finance   = 0;

        // Finances
        $budgetTotal    = (clone $base)->sum('budgetTotal')    ?? 0;
        $montantDemande = (clone $base)->sum('montantDemande') ?? 0;
        $montantFinance = 0; // colonne non encore créée

        // Projets récents (max 5)
        $projetsRecents = Projet::where('user_id', $user->id)
                                ->with('secteur')
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

        // Notifications récentes (max 4)
        $notifications = Notification::where('destinataire_id', $user->id)
                                    ->latest()
                                    ->take(2)
                                    ->get();

            return view('dashboard.index', compact(
                'total',
                'brouillon',
                'soumis',
                'enExamen',
                'approuve',
                'valide',
                'rejete',
                'finance',
                'budgetTotal',
                'montantDemande',
                'montantFinance',
                'projetsRecents',
                'notifications'
                ));
    }catch (\Exception $e){

        Log::error('Erreur lors du chargement du dashboard porteur', [
            'message' => $e->getMessage(),
            'user_id' => Auth::id(),
        ]);

        return back()->with('error', 'Une erreur est survenue');
    }
    }
}
