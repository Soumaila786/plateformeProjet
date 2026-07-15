<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {

    public function index() {

    try{

        $user = Auth::user();
        // Compteurs statuts
        $base = Projet::where('user_id', $user->id);
        // clone sert à :eviter de modifier la requête originale
        // exécuter plusieurs requêtes différentes à partir d’une même base
        // garantir des résultats corrects
        $total     = (clone $base)->count();
        $brouillon = (clone $base)->where('statutProjet', 'brouillon')->count();
        $soumis    = (clone $base)->where('statutProjet', 'soumis')->count();
        $enExamen  = (clone $base)->where('statutProjet', 'en_examen')->count();
        $approuve  = (clone $base)->where('statutProjet', 'approuve')->count();
        $valide    = (clone $base)->where('statutProjet', 'valide')->count();
        $rejete    = (clone $base)->where('statutProjet', 'rejete')->count();
        $finance   = (clone $base)->where('statutProjet', 'finance')->count();

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

            return view('porteur.dashboard', compact(
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
        return view('error', 'Une erreur est survenue', $e->getMessage());
    }
    }
}
