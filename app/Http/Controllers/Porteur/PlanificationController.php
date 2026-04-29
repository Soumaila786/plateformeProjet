<?php
namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Planification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlanificationController extends Controller {

    private function validerDonnees(Request $request) {
        
        return $request->validate([
            'activitePlanification' => 'required|string|max:255',
            'indicateur'            => 'nullable|string|max:255',
            'uniteIndicateur'       => 'nullable|string|max:100',
            'resultatsAttendues'    => 'nullable|string',
            'coutEstimatif'         => 'nullable|numeric|min:0',
            'periode'               => 'nullable|string|max:100',
        ]);
    }

    public function create(Projet $projet) {

        $this->authorize('view', $projet);
        // Seul le porteur propriétaire peut planifier son projet
        abort_if($projet->user_id !== Auth::id(), 403);

        return view('porteur.planifications.create', compact('projet'));
    }

    public function store(Request $request, Projet $projet) {

        $this->authorize('view', $projet);
        abort_if($projet->user_id !== Auth::id(), 403);

        try {
            $data = $this->validerDonnees($request);
            $data['projet_id'] = $projet->id;

            Planification::create($data);

            Log::info('Planification créée par le porteur', [
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);

            return redirect()->route('porteur.projets.show', $projet)
                ->with('success', 'Activité de planification ajoutée.');

        } catch (\Exception $e) {
            Log::error('Erreur création planification porteur', [
                'message'   => $e->getMessage(),
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function edit(Projet $projet, Planification $planification) {

        $this->authorize('view', $projet);
        abort_if($projet->user_id !== Auth::id(), 403);
        abort_if($planification->projet_id !== $projet->id, 404);

        return view('porteur.planifications.edit', compact('projet', 'planification'));
    }

    public function update(Request $request, Projet $projet, Planification $planification) {

        $this->authorize('view', $projet);
        abort_if($projet->user_id !== Auth::id(), 403);
        abort_if($planification->projet_id !== $projet->id, 404);

        try {
            $data = $this->validerDonnees($request);
            $planification->update($data);

            Log::info('Planification modifiée par le porteur', [
                'planification_id' => $planification->idPlanification,
                'projet_id'        => $projet->id,
                'user_id'          => Auth::id(),
            ]);

            return redirect()->route('porteur.projets.show', $projet)
                ->with('success', 'Planification mise à jour.');

        } catch (\Exception $e) {
            Log::error('Erreur mise à jour planification porteur', [
                'message'   => $e->getMessage(),
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function destroy(Projet $projet, Planification $planification) {

        $this->authorize('view', $projet);
        abort_if($projet->user_id !== Auth::id(), 403);
        abort_if($planification->projet_id !== $projet->id, 404);

        try {
            $planification->delete();

            Log::warning('Planification supprimée par le porteur', [
                'planification_id' => $planification->idPlanification,
                'projet_id'        => $projet->id,
                'user_id'          => Auth::id(),
            ]);

            return back()->with('success', 'Planification supprimée.');

        } catch (\Exception $e) {
            Log::error('Erreur suppression planification porteur', [
                'message'   => $e->getMessage(),
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }
}
