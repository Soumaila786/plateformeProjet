<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\Projet\ProjetService;

class ProjetController extends Controller {

    public function index(Request $request) {

        try{

            $query = Projet::with(['porteur', 'secteur']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                        ->orWhere('codeProjet', 'like', "%{$search}%");
                });
            }

            if ($request->filled('statut')) {
                $query->where('statutProjet', $request->statut);
            }

            $projets = $query->latest()->paginate(12);

            Log::info('Consultation de la liste des projets',[
                'admin_id' => Auth::id(),
                'search' => $request->search,
                'statut' => $request->statut,
                'ip' => $request->ip()
            ]);

            return view('projets.index', compact('projets'));

        }catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des projets', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function show(Projet $projet, ProjetService $projetService){

        $this->authorize('view', $projet);

        $projet->load([
            'porteur', 'secteur',
            'activites',
            'documents.uploader',
            'commentaires.utilisateur'
        ]);

        $viewData = $projetService->prepare($projet);

        Log::info('Consultation d’un projet', [
            'projet_id' => $projet->id,
            'admin_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        return view( 'projets.show', array_merge( ['projet' => $projet], $viewData ) );

    }

    public function destroy(Projet $projet){

        $this->authorize('delete', $projet);

        try{

            $titre = $projet->titre;

            foreach ($projet->documents as $doc) {
                Storage::disk('public')->delete($doc->cheminFichier);
            }
            $projet->delete();

            Log::warning('Suppression d’un projet', [
                'projet_id' => $projet->id,
                'titre' => $titre,
                'admin_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            return redirect()->route('projets.index')->with('success', 'Projet supprimé avec succès.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la suppression d’un projet', [
                'projet_id' => $projet->id,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->route('projets.index', $projet)->with('error', 'Une erreur est survenue ');
        }
    }

    // NOTE : changerStatut() était commentée intégralement dans le fichier d'origine
    // (code mort, jamais routée). Supprimée dans le cadre du nettoyage (point 6) —
    // si tu veux qu'un admin puisse forcer un changement de statut, dis-le-moi et
    // je la réécris proprement avec la bonne autorisation Policy.

    public function downloadDocument(Projet $projet, DocumentProjet $document){

        $this->authorize('view', $projet);

        $path = storage_path('app/public/' . $document->cheminFichier);

        if (!file_exists($path)) {

            Log::warning('Tentative de téléchargement d’un fichier introuvable', [
                'projet_id' => $projet->id,
                'document_id' => $document->id,
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Fichier introuvable.');
        }

        Log::info('Téléchargement d’un document de projet', [
            'projet_id' => $projet->id,
            'document_id' => $document->id,
            'nom_fichier' => $document->nomFichier,
            'admin_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        return response()->download($path, $document->nomFichier);
    }
}
