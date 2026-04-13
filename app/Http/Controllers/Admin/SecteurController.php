<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\SecteurActivite;
use Illuminate\Http\Request;

class SecteurController extends Controller {

    public function index() {

        try{

            $secteurs = SecteurActivite::with('projets')->get();
            return view('admin.secteurs.index', compact('secteurs'));

            }catch(\Exception $e){

                Log::error('Erreur lors de la récupération des secteurs', [
                    'message' => $e->getMessage(),
                    'admin_id' => Auth::id()
                ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function create() {

        return view('admin.secteurs.create');
    }

    public function store(Request $request) {

        try{
            $request->validate([
                'nomSecteur'  => 'required|string|max:255|unique:secteur_activites,nomSecteur',
                'description' => 'nullable|string|max:500',
            ]);

            SecteurActivite::create([
                'nomSecteur'  => $request->nomSecteur,
                'description' => $request->description,
                'statutSecteur'      => $request->has('statutSecteur'),
            ]);

            Log::info('Création d’un secteur d’activité', [
                'secteur_id' => $secteur->id,
                'nomSecteur' => $secteur->nomSecteur,
                'admin_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('admin.secteurs.index')
                ->with('success', 'Secteur créé avec succès.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la création d’un secteur', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->route('admin.secteurs.index')
                ->with('error', 'Une erreur est survenue ');
        }
    }

    public function edit(SecteurActivite $secteur) {

        return view('admin.secteurs.edit', compact('secteur'));
    }

    public function update(Request $request, SecteurActivite $secteur) {
        try{

            $request->validate([
                'nomSecteur'  => 'required|string|max:255|unique:secteur_activites,nomSecteur,' . $secteur->id,
                'description' => 'nullable|string|max:500',
            ]);

            $ancienNom = $secteur->nomSecteur;

            $secteur->update([
                'nomSecteur'  => $request->nomSecteur,
                'description' => $request->description,
                'statutSecteur'      => $request->has('statutSecteur'),
            ]);

            Log::notice("Mise à jour d'un secteur d'activité",[
                'secteur_id' => $secteur->id,
                'ancien_nom' => $ancienNom,
                'nouveau_nom' => $secteur->nomSecteur,
                'admin_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('admin.secteurs.index')
                ->with('success', 'Secteur mis à jour.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la mise à jour d’un secteur', [
                'secteur_id' => $secteur->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            return redirect()->route('admin.secteurs.index')
                ->with('error', 'Une erreur est survenue ');
        }
    }

    public function destroy(SecteurActivite $secteur) {

        try{

            if ($secteur->projets()->count() > 0) {

                Log::warning('Tentative de suppression d’un secteur contenant des projets', [
                    'secteur_id' => $secteur->id,
                    'nomSecteur' => $secteur->nomSecteur,
                    'admin_id' => Auth::id(),
                    'ip' => request()->ip()
                ]);
                return redirect()->route('admin.secteurs.index')
                    ->with('error', 'Impossible de supprimer un secteur contenant des projets.');
            }

            $secteurNom = $secteur->nomSecteur;
            $secteur->delete();

            Log::warning('Suppression d’un secteur d’activité', [
                'secteur_id' => $secteur->id,
                'nomSecteur' => $secteurNom,
                'admin_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            return redirect()->route('admin.secteurs.index')
                ->with('success', 'Secteur supprimé.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la suppression d’un secteur', [
                'secteur_id' => $secteur->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function toggleStatus(SecteurActivite $secteur) {

        try {
            $ancienStatut = $secteur->statutSecteur;

            $secteur->update([
                'statutSecteur' => !$secteur->statutSecteur
            ]);

            $msg = $secteur->statutSecteur ? 'Secteur activé.' : 'Secteur désactivé.';

            Log::notice('Changement de statut d’un secteur', [
                'secteur_id' => $secteur->id,
                'nomSecteur' => $secteur->nomSecteur,
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $secteur->statutSecteur,
                'admin_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            return back()->with('success', $msg);

        } catch (\Exception $e) {
            
            Log::error('Erreur lors du changement de statut d’un secteur', [
                'secteur_id' => $secteur->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            return back()->with('error', 'Une erreur est survenue.');
        }
    }
}
