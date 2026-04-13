<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Projet;
use App\Models\Planification;
use Illuminate\Http\Request;

class PlanificationController extends Controller {

    // Liste des planifications d'un projet
    public function index(Projet $projet) {

        $this->authorize('voirPlanification', $projet);

        $planifications = $projet->planifications()
            ->orderBy('idPlanification')
            ->get();

        return view('approbateur.planification.index', compact('projet', 'planifications'));
    }

    // Formulaire création
    public function create(Projet $projet) {

        $this->authorize('gererPlanification', $projet);

        return view('approbateur.planification.create', compact('projet'));
    }

    // Enregistrer
    public function store(Request $request, Projet $projet) {

        $this->authorize('gererPlanification', $projet);
        try{

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

            Log::info('Ajout d’une planification', [
                'planification_id' => $planification->idPlanification ?? $planification->id,
                'projet_id' => $projet->id,
                'activite' => $planification->activitePlanification,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Activité de planification ajoutée.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de l’ajout d’une planification', [
                'projet_id' => $projet->id,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);

        return redirect()->route('approbateur.projets.show', $projet)
            ->with('error', 'Une erreur est survenue.');
    }
    }

    // Formulaire modification
    public function edit(Projet $projet, Planification $planification) {

        $this->authorize('gererPlanification', $projet);

        return view('approbateur.planification.edit', compact('projet', 'planification'));
    }

    // Mettre à jour
    public function update(Request $request, Projet $projet, Planification $planification) {

        $this->authorize('gererPlanification', $projet);

        try{

            $request->validate([
                'activitePlanification' => 'required|string|max:255',
                'indicateur'            => 'nullable|string|max:255',
                'uniteIndicateur'       => 'nullable|string|max:100',
                'resultatsAttendues'    => 'nullable|string',
                'coutEstimatif'         => 'nullable|numeric|min:0',
                'periode'               => 'nullable|string|max:100',
            ]);

            $ancienCout = $planification->coutEstimatif;

            $planification->update($request->only([
                'activitePlanification',
                'indicateur',
                'uniteIndicateur',
                'resultatsAttendues',
                'coutEstimatif',
                'periode',
            ]));

            Log::notice('Mise à jour d’une planification', [
                'planification_id' => $planification->idPlanification ?? $planification->id,
                'projet_id' => $projet->id,
                'ancien_cout' => $ancienCout,
                'nouveau_cout' => $planification->coutEstimatif,
                'approbateur_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Planification mise à jour.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de la mise à jour d’une planification', [
                'planification_id' => $planification->idPlanification ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue.');
        }
    }

    // Supprimer
    public function destroy(Projet $projet, Planification $planification) {

        $this->authorize('gererPlanification', $projet);

        try {
            $planificationId = $planification->idPlanification ?? $planification->id;
            $activite = $planification->activitePlanification;

            $planification->delete();

            Log::warning('Suppression d’une planification', [
                'planification_id' => $planificationId,
                'projet_id' => $projet->id,
                'activite' => $activite,
                'approbateur_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('success', 'Activité supprimée.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la suppression d’une planification', [
                'planification_id' => $planification->idPlanification ?? null,
                'message' => $e->getMessage(),
                'approbateur_id' => Auth::id()
            ]);

            return redirect()->route('approbateur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue.');
        }
    }
}
