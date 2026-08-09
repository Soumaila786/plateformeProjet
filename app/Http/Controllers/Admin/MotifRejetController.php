<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MotifRejet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MotifRejetController extends Controller {

    public function index() {

        $this->authorize('viewAny', MotifRejet::class);

        try{
            $motifs = MotifRejet::orderBy('libelle')->get();
            return view('motifs.index', compact('motifs'));

        }catch(\Exception $e){
            Log::error('Erreur lors du chargement des motifs de rejet', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function store(Request $request) {

        $this->authorize('manage', MotifRejet::class);

        try{
            $request->validate([
                'libelle' => 'required|string|max:255|unique:motifs_rejet,libelle',
            ]);

            $motif = MotifRejet::create([
                'libelle' => $request->libelle,
                'actif'   => true,
            ]);

            Log::info('Création d’un motif de rejet', [
                'motif_id' => $motif->id,
                'libelle' => $motif->libelle,
                'admin_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return back()->with('success', 'Motif ajouté avec succès.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la création d’un motif de rejet', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function update(Request $request, MotifRejet $motif) {

        $this->authorize('manage', MotifRejet::class);

        try{
            $request->validate([
                'libelle' => 'required|string|max:255|unique:motifs_rejet,libelle,' . $motif->id,
            ]);

            $ancienLibelle = $motif->libelle;
            $motif->update(['libelle' => $request->libelle]);

            Log::notice('Mise à jour d’un motif de rejet', [
                'motif_id' => $motif->id,
                'ancien_libelle' => $ancienLibelle,
                'nouveau_libelle' => $motif->libelle,
                'admin_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return back()->with('success', 'Motif mis à jour.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la mise à jour d’un motif de rejet', [
                'motif_id' => $motif->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function destroy(MotifRejet $motif) {

        $this->authorize('manage', MotifRejet::class);

        try{
            // On ne supprime pas un motif déjà utilisé dans l'historique des commentaires,
            // pour ne pas perdre la traçabilité des rejets passés — on le désactive à la place.
            if ($motif->commentaires()->count() > 0) {
                $motif->update(['actif' => false]);

                Log::warning('Motif déjà utilisé : désactivé au lieu de supprimé', [
                    'motif_id' => $motif->id,
                    'libelle' => $motif->libelle,
                    'admin_id' => Auth::id(),
                ]);

                return back()->with('success',
                    'Ce motif a déjà été utilisé dans des rejets passés :
                    il a été désactivé plutôt que supprimé
                    (pour garder l’historique).');
            }

            $libelle = $motif->libelle;
            $motif->delete();

            Log::warning('Suppression d’un motif de rejet', [
                'libelle' => $libelle,
                'admin_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            return back()->with('success', 'Motif supprimé.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la suppression d’un motif de rejet', [
                'motif_id' => $motif->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function toggleStatus(MotifRejet $motif) {

        $this->authorize('manage', MotifRejet::class);

        try{
            $motif->update(['actif' => !$motif->actif]);

            $msg = $motif->actif ? 'Motif activé.' : 'Motif désactivé.';

            Log::notice('Changement de statut d’un motif de rejet', [
                'motif_id' => $motif->id,
                'nouveau_statut' => $motif->actif,
                'admin_id' => Auth::id(),
            ]);

            return back()->with('success', $msg);

        }catch(\Exception $e){
            Log::error('Erreur lors du changement de statut d’un motif', [
                'motif_id' => $motif->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }
}
