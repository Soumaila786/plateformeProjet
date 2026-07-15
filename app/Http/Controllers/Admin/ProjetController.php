<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

            return view('admin.projets.index', compact('projets'));

        }catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des projets', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function show(Projet $projet){

        $projet->load([
            'porteur', 'secteur',
            'activites',
            'documents.uploader',
            'commentaires.utilisateur'
        ]);

        Log::info('Consultation d’un projet', [
            'projet_id' => $projet->id,
            'admin_id' => Auth::id(),
            'ip' => request()->ip()
        ]);

        return view('admin.projets.show', compact('projet'));
    }

    public function destroy(Projet $projet){

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

            return redirect()->route('admin.projets.index')->with('success', 'Projet supprimé avec succès.');

        }catch(\Exception $e){

            Log::error('Erreur lors de la suppression d’un projet', [
                'projet_id' => $projet->id,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->route('admin.projets.index', $projet)->with('error', 'Une erreur est survenue ');
        }
    }

    // public function changerStatut(Request $request, Projet $projet) {

    //     try{

    //         $request->validate([
    //             'statut' => 'required|in:brouillon,soumis,en_examen,approuve,valide,rejete',
    //         ]);

    //         $ancienStatut = $projet->statutProjet;
    //         $projet->update(['statutProjet' => $request->statut]);

    //         $labels = [
    //             'brouillon' => 'Brouillon', 'soumis'    => 'Soumis',
    //             'en_examen' => 'En examen', 'approuve'  => 'Approuvé',
    //             'valide'    => 'Validé',    'rejete'     => 'Rejeté',
    //         ];

    //         // Notification au porteur
    //         NotificationService::notifierPorteur(
    //             $projet,
    //             'Le statut de votre projet « ' . $projet->titre .
    //             ' » a été modifié de « ' . ($labels[$ancienStatut] ?? $ancienStatut) .
    //             ' » à « ' . ($labels[$request->statut] ?? $request->statut) .
    //             ' » par l\'administrateur.',
    //             'statut_change'
    //         );

    //         Log::notice('Changement de statut d’un projet', [
    //             'projet_id' => $projet->id,
    //             'titre' => $projet->titre,
    //             'ancien_statut' => $ancienStatut,
    //             'nouveau_statut' => $request->statut,
    //             'admin_id' => Auth::id(),
    //             'ip' => $request->ip()
    //         ]);

    //         return redirect()->route('admin.projets.show', $projet)->with('success', 'Statut mis à jour.');

    //     }catch(\Exception $e){

    //         Log::error('Erreur lors du changement de statut',[
    //             'projet_id' => $projet->id,
    //             'message' => $e->getMessage(),
    //             'admin_id' => Auth::id()
    //         ]);
    //         return redirect()->route('admin.projets.show', $projet)
    //             ->with('error', 'Une erreur est survenue ');
    //     }
    // }

    public function downloadDocument(Projet $projet, DocumentProjet $document){

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
