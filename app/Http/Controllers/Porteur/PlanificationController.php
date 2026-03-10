<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use Illuminate\Http\Request;

class PlanificationController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $this->authorize('gererPlanification', $projet);

        $request->validate([
            'activite'            => 'required|string|max:255',
            'descriptionActivite' => 'nullable|string',
            'dateDebut'           => 'required|date',
            'dateFin'             => 'required|date|after_or_equal:dateDebut',
            'montantDemande'      => 'nullable|numeric|min:0',
            'statutActivite'      => 'nullable|in:en_attente,en_cours,termine,annule',
        ]);

        $projet->planifications()->create([
            'activite'            => $request->activite,
            'descriptionActivite' => $request->descriptionActivite,
            'dateDebut'           => $request->dateDebut,
            'dateFin'             => $request->dateFin,
            'montantDemande'      => $request->montantDemande,
            'statutActivite'      => $request->statutActivite ?? 'en_attente',
        ]);

        return back()->with('success', 'Activité ajoutée à la planification.');
    }

    public function destroy(Projet $projet, Planification $planification)
    {
        $this->authorize('gererPlanification', $projet);

        $planification->delete();

        return back()->with('success', 'Activité supprimée.');
    }
}
