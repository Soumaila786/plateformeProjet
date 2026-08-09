<?php
namespace App\Http\Controllers\Planificateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Activite;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlanificationController extends Controller {

    // NOTE : pilote désormais le Model Activite (l'ancienne table planifications
    // a été fusionnée dedans).

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

    // Liste des projets avec demande de planification
    public function index(Request $request) {

        try {
            $query = Projet::with(['secteur', 'user'])
                            ->where('planification_demandee', true);

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                        ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            $projets = $query->orderBy('updated_at', 'desc')->paginate(4);

            return view('projets.index', compact('projets'));

        } catch (\Exception $e) {
            Log::error('Erreur chargement projets planificateur', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function show(Projet $projet) {

        $this->authorize('voirPlanification', $projet);

        $projet->load(['secteur', 'user', 'activites', 'documents']);
        return view('projets.show', compact('projet'));
    }

    public function create(Projet $projet) {

        $this->authorize('gererPlanification', $projet);

        return view('planificateur.planifications.create', compact('projet'));
    }

    public function store(Request $request, Projet $projet) {

        $this->authorize('gererPlanification', $projet);

        try {
            $data = $this->validerDonnees($request);

            $projet->activites()->create([
                'activite'           => $data['activitePlanification'],
                'indicateur'         => $data['indicateur'],
                'uniteIndicateur'    => $data['uniteIndicateur'],
                'resultatsAttendues' => $data['resultatsAttendues'],
                'coutEstimatif'      => $data['coutEstimatif'],
                'periode'            => $data['periode'],
                'statutActivite'     => 'en_attente',
                'planificateur_id'   => Auth::id(),
            ]);

            // NE PAS remettre planification_demandee à false ici
            // Le planificateur peut ajouter plusieurs activités librement

            NotificationService::notifierPorteur(
                $projet,
                'Le planificateur a ajouté une activité de planification sur votre projet « ' . $projet->titre . ' ».',
                'info'
            );

            Log::info('Planification créée par le planificateur', [
                'projet_id'        => $projet->id,
                'planificateur_id' => Auth::id(),
            ]);

            return redirect()->route('planificateur.projets.show', $projet)
                ->with('success', 'Activité ajoutée.');

        } catch (\Exception $e) {
            Log::error('Erreur création planification (planificateur)', [
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

        return view('planificateur.planifications.edit', compact('projet', 'planification'));
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

            Log::info('Planification modifiée par le planificateur', [
                'planification_id' => $planification->id,
                'projet_id'        => $projet->id,
                'user_id'          => Auth::id(),
            ]);

            return redirect()->route('planificateur.projets.show', $projet)
                ->with('success', 'Planification mise à jour.');

        } catch (\Exception $e) {
            Log::error('Erreur mise à jour planification (planificateur)', [
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

            Log::warning('Planification supprimée par le planificateur', [
                'planification_id' => $planification->id,
                'projet_id'        => $projet->id,
                'user_id'          => Auth::id(),
            ]);

            return back()->with('success', 'Planification supprimée.');

        } catch (\Exception $e) {
            Log::error('Erreur suppression planification (planificateur)', [
                'message'   => $e->getMessage(),
                'projet_id' => $projet->id,
                'user_id'   => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    // Projets déjà planifiés par ce planificateur (planification_demandee = false et ont des activités)
    public function traites(Request $request) {
        try {
            $query = Projet::with(['secteur', 'user'])
                ->where('planification_demandee', false)
                ->whereHas('activites');

            if ($request->filled('search')) {
                $s = $request->search;
                $query->where(function ($q) use ($s) {
                    $q->where('titre', 'like', '%'.$s.'%')
                    ->orWhere('codeProjet', 'like', '%'.$s.'%');
                });
            }

            $projets = $query->orderBy('updated_at', 'desc')->paginate(10);

            return view('planificateur.projets.traites', compact('projets'));

        } catch (\Exception $e) {
            Log::error('Erreur chargement projets traités planificateur', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }
}
