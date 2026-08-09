<?php
namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlanificationController extends Controller {

    // NOTE : ce controller pilote désormais le Model Activite — l'ancienne table
    // "planifications" a été fusionnée dedans. Noms de classe/méthodes/routes
    // conservés tels quels pour l'instant ; le renommage complet (Planification
    // -> Activite dans les routes/URLs) est prévu en phase 4 (réorganisation
    // des controllers/routes).

    private function validerDonnees(Request $request) {

        return $request->validate([
            'activitePlanification' => 'required|string|max:255',
            'indicateur'            => 'required|integer',
            'uniteIndicateur'       => 'required|string|max:100',
            'resultatsAttendues'    => 'required|string',
            'coutEstimatif'         => 'required|numeric|min:0',
            'periode'               => 'required|string|max:100',
        ]);
    }

    public function create(Projet $projet) {

        // Utilise la vraie permission dédiée (au lieu de 'view' précédemment) :
        // elle vérifie déjà la propriété du projet ET son statut.
        $this->authorize('gererPlanification', $projet);

        return view('planifications.create', compact('projet'));
    }

    public function store(Request $request, Projet $projet) {

        $this->authorize('gererPlanification', $projet);

        try {
            $data = $this->validerDonnees($request);

            Activite::create([
                'activite'           => $data['activitePlanification'],
                'indicateur'         => $data['indicateur'],
                'uniteIndicateur'    => $data['uniteIndicateur'],
                'resultatsAttendues' => $data['resultatsAttendues'],
                'coutEstimatif'      => $data['coutEstimatif'],
                'periode'            => $data['periode'],
                'statutActivite'     => 'en_attente',
                'projet_id'          => $projet->id,
            ]);

            Log::info('Planification créée par le porteur', [
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);

            return redirect()->route('projets.show', $projet)
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

    public function edit(Projet $projet, Activite $planification) {

        $this->authorize('gererPlanification', $projet);
        abort_if($planification->projet_id !== $projet->id, 404);

        return view('porteur.planifications.edit', compact('projet', 'planification'));
    }

    public function update(Request $request, Projet $projet, Activite $planification) {

        $this->authorize('gererPlanification', $projet);
        abort_if($planification->projet_id !== $projet->id, 404);

        try {
            $data = $this->validerDonnees($request);

            $planification->update([
                'activite'           => $data['activitePlanification'],
                'indicateur'         => $data['indicateur'],
                'uniteIndicateur'    => $data['uniteIndicateur'],
                'resultatsAttendues' => $data['resultatsAttendues'],
                'coutEstimatif'      => $data['coutEstimatif'],
                'periode'            => $data['periode'],
            ]);

            Log::info('Planification modifiée par le porteur', [
                'planification_id' => $planification->id,
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

    public function destroy(Projet $projet, Activite $planification) {

        $this->authorize('gererPlanification', $projet);
        abort_if($planification->projet_id !== $projet->id, 404);

        try {
            $planification->delete();

            Log::warning('Planification supprimée par le porteur', [
                'planification_id' => $planification->id,
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
