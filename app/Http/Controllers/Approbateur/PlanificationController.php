<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use Illuminate\Http\Request;

class PlanificationController extends Controller
{
    // ── Liste des planifications d'un projet ──
    public function index(Projet $projet)
    {
        $this->authorize('voirPlanification', $projet);
        $planifications = $projet->planifications()->orderBy('idPlanification')->get();
        return view('approbateur.planification.index', compact('projet', 'planifications'));
    }

    // ── Formulaire création ──
    public function create(Projet $projet)
    {
        $this->authorize('gererPlanification', $projet);
        return view('approbateur.planification.create', compact('projet'));
    }

    // ── Enregistrer ──
    public function store(Request $request, Projet $projet)
    {
        $this->authorize('gererPlanification', $projet);

        $request->validate([
            'activitePlanification' => 'required|string|max:255',
            'indicateur'            => 'nullable|string|max:255',
            'uniteIndicateur'       => 'nullable|string|max:100',
            'resultatsAttendues'    => 'nullable|string',
            'coutEstimatif'         => 'nullable|numeric|min:0',
            'periode'               => 'nullable|string|max:100',
        ]);

        $projet->planifications()->create([
            'activitePlanification' => $request->activitePlanification,
            'indicateur'            => $request->indicateur,
            'uniteIndicateur'       => $request->uniteIndicateur,
            'resultatsAttendues'    => $request->resultatsAttendues,
            'coutEstimatif'         => $request->coutEstimatif ?? 0,
            'periode'               => $request->periode,
        ]);

        return redirect()->route('approbateur.projets.show', $projet)
            ->with('success', 'Activité de planification ajoutée.');
    }

    // ── Formulaire modification ──
    public function edit(Projet $projet, Planification $planification)
    {
        $this->authorize('gererPlanification', $projet);
        return view('approbateur.planification.edit', compact('projet', 'planification'));
    }

    // ── Mettre à jour ──
    public function update(Request $request, Projet $projet, Planification $planification)
    {
        $this->authorize('gererPlanification', $projet);

        $request->validate([
            'activitePlanification' => 'required|string|max:255',
            'indicateur'            => 'nullable|string|max:255',
            'uniteIndicateur'       => 'nullable|string|max:100',
            'resultatsAttendues'    => 'nullable|string',
            'coutEstimatif'         => 'nullable|numeric|min:0',
            'periode'               => 'nullable|string|max:100',
        ]);

        $planification->update($request->only([
            'activitePlanification',
            'indicateur',
            'uniteIndicateur',
            'resultatsAttendues',
            'coutEstimatif',
            'periode',
        ]));

        return redirect()->route('approbateur.projets.show', $projet)
            ->with('success', 'Planification mise à jour.');
    }

    // ── Supprimer ──
    public function destroy(Projet $projet, Planification $planification)
    {
        $this->authorize('gererPlanification', $projet);
        $planification->delete();

        return redirect()->route('approbateur.projets.show', $projet)
            ->with('success', 'Activité supprimée.');
    }
}