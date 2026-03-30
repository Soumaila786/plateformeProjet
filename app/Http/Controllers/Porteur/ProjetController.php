<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use App\Models\SecteurActivite;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller {

    public function index(Request $request) {

        $query = Projet::with('secteur')
            ->where('user_id', Auth::id());
        // Filtre statut
        if ($request->filled('statut')) {
            $query->where('statutProjet', $request->statut);
        }
        // Recherche titre / code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', '%' . $search . '%')
                    ->orWhere('codeProjet', 'like', '%' . $search . '%'); });
        }
        $projets = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('porteur.projets.index', compact('projets'));
    }

    public function create() {
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();
        return view('porteur.projets.create', compact('secteurs'));
    }

    public function store(Request $request){
        $request->validate([
            'titre'         => 'required|string|max:255',
            'description'   => 'required|string',
            'objectif'      => 'nullable|string',
            'secteur_id'    => 'required|exists:secteur_activites,id',
            'duree'         => 'nullable|integer|min:1',
            'dateDebut'     => 'nullable|date',
            'dateFin'       => 'nullable|date|after_or_equal:dateDebut',
            'budgetTotal'   => 'nullable|numeric|min:0',
            'montantDemande'=> 'nullable|numeric|min:0',
            'documents'     => 'nullable|array',
            'documents.*'   => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
        ]);
        $code = 'PRJ-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $projet = Projet::create([
            'codeProjet'     => $code,
            'titre'          => $request->titre,
            'description'    => $request->description,
            'objectif'       => $request->objectif ?? '',
            'dateCreation'   => now(),
            'duree'          => $request->duree,
            'dateDebut'      => $request->dateDebut,
            'dateFin'        => $request->dateFin,
            'budgetTotal'    => $request->budgetTotal,
            'montantDemande' => $request->montantDemande,
            'statutProjet'   => 'brouillon',
            'user_id'        => Auth::id(),
            'secteur_id'     => $request->secteur_id,
        ]);
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $chemin = $file->store("projets/{$projet->id}/documents", 'public');
                DocumentProjet::create([
                    'nomFichier'    => $file->getClientOriginalName(),
                    'typeDocument'  => $file->getClientOriginalExtension(),
                    'cheminFichier' => $chemin,
                    'dateUpload'    => now(),
                    'projet_id'     => $projet->id,
                    'uploader_id'   => Auth::id(),
                ]);
            }
        }
        return redirect()->route('porteur.projets.show', $projet)
                            ->with('success', 'Projet créé avec succès.');
    }

    public function show(Projet $projet) {
        $this->authorize('view', $projet);
        $projet->load([
            'secteur',
            'documents',
            'commentaires.utilisateur',
            'planifications',
        ]);
        return view('porteur.projets.show', compact('projet'));
    }
    public function edit(Projet $projet){
        $this->authorize('update', $projet);
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();
        return view('porteur.projets.edit', compact('projet', 'secteurs'));
    }

    public function update(Request $request, Projet $projet){
        $this->authorize('update', $projet);
        $request->validate([
            'titre'         => 'required|string|max:255',
            'description'   => 'required|string',
            'objectif'      => 'nullable|string',
            'secteur_id'    => 'required|exists:secteur_activites,id',
            'duree'         => 'nullable|integer|min:1',
            'dateDebut'     => 'nullable|date',
            'dateFin'       => 'nullable|date|after_or_equal:dateDebut',
            'budgetTotal'   => 'nullable|numeric|min:0',
            'montantDemande'=> 'nullable|numeric|min:0',
        ]);

        $projet->update([
            'titre'          => $request->titre,
            'description'    => $request->description,
            'objectif'       => $request->objectif ?? '',
            'duree'          => $request->duree,
            'dateDebut'      => $request->dateDebut,
            'dateFin'        => $request->dateFin,
            'budgetTotal'    => $request->budgetTotal,
            'montantDemande' => $request->montantDemande,
            'secteur_id'     => $request->secteur_id,
            'planification_demandee' => False,

        ]);

        return redirect()->route('porteur.projets.show', $projet)
                            ->with('success', 'Projet mis à jour.');
    }

    public function destroy(Projet $projet) {
        $this->authorize('delete', $projet);

        foreach ($projet->documents as $doc) {
            Storage::disk('public')->delete($doc->cheminFichier);
        }
        $projet->delete();

        return redirect()->route('porteur.projets.index')
                            ->with('success', 'Projet supprimé.');
    }

    public function soumettre(Projet $projet){

        $this->authorize('soumettre', $projet);
        $projet->update([
            'statutProjet'   => 'soumis',
            'dateSoumission' => now(),
        ]);
        // Notifier les approbateurs
        NotificationService::notifierApprobateurs(
            'Un nouveau projet « ' . $projet->titre . ' » ('. $projet->codeProjet .') a été soumis et est en attente d\'examen.',
            'soumission',
            $projet->id
        );
        // Notifier le porteur lui-même
        NotificationService::notifierPorteur(
            $projet,
            'Votre projet « ' . $projet->titre . ' » a été soumis avec succès et est en attente d\'examen.',
            'soumission'
        );
        return redirect()->route('porteur.projets.show', $projet)
                            ->with('success', 'Projet soumis avec succès.');
    }

    public function storeDocument(Request $request, Projet $projet) {
        $this->authorize('update', $projet);
        $request->validate([
            'documents'   => 'required|array',
            'documents.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
        ]);

        foreach ($request->file('documents') as $file) {
            $chemin = $file->store("projets/{$projet->id}/documents", 'public');
            DocumentProjet::create([
                'nomFichier'    => $file->getClientOriginalName(),
                'typeDocument'  => $file->getClientOriginalExtension(),
                'cheminFichier' => $chemin,
                'dateUpload'    => now(),
                'projet_id'     => $projet->id,
                'uploader_id'   => Auth::id(),
            ]);
        }
        return back()->with('success', 'Documents ajoutés.');
    }

    public function destroyDocument(Projet $projet, DocumentProjet $document){
        $this->authorize('update', $projet);
        Storage::disk('public')->delete($document->cheminFichier);
        $document->delete();
        return back()->with('success', 'Document supprimé.');
    }

    public function downloadDocument(Projet $projet, DocumentProjet $document) {

        $path = storage_path('app/public/' . $document->cheminFichier);
        if (!file_exists($path)) {
            return back()->with('error', 'Fichier introuvable.');
        }
        return response()->download($path, $document->nomFichier);
    }


    public function demanderPlanification($id){

        $projet = Projet::findOrFail($id);
        $projet->update([ 'planification_demandee' => 1 ]);
        // Notifier les approbateurs
        NotificationService::notifierApprobateurs(
            'Un nouveau projet « ' . $projet->titre . ' » ('. $projet->codeProjet .') besoin de planification.',
            'soumission',
            $projet->id
        );
        return back()->with('success', 'Demande envoyée');
    }

}
