<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use Illuminate\Http\Request;

class PlanificationController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $request->validate([
            'activite'            => 'required|string|max:255',
            'descriptionActivite' => 'nullable|string',
            'dateDebut'           => 'required|date',
            'dateFin'             => 'required|date|after_or_equal:dateDebut',
            'montantDemande'      => 'nullable|numeric|min:0',
            'statutActivite'      => 'required|in:en_attente,en_cours,termine,annule',
        ]);

        $projet->planifications()->create([
            'activite'            => $request->activite,
            'descriptionActivite' => $request->descriptionActivite,
            'dateDebut'           => $request->dateDebut,
            'dateFin'             => $request->dateFin,
            'montantDemande'      => $request->montantDemande,
            'statutActivite'      => $request->statutActivite,
        ]);

        return redirect()->route('projets.show', $projet)
                            ->with('success', 'Activité ajoutée avec succès.');
    }

    public function destroy(Projet $projet, Planification $planification)
    {
        $planification->delete();

        return redirect()->route('projets.show', $projet)
                            ->with('success', 'Activité supprimée.');
    }
}