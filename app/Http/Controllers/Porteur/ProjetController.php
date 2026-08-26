<?php

namespace App\Http\Controllers\Porteur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\DocumentProjet;
use App\Models\HistoriqueProjet;
use App\Models\SecteurActivite;
use App\Models\SousDomaine;
use App\Models\TypeProjet;
use App\Services\NotificationService;
use App\Services\Projet\ProjetWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller {

    public function index(Request $request) {

        try{
            $query = Projet::with('secteur')->where('user_id', Auth::id());

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

            $projets = $query->orderBy('created_at', 'desc')->paginate(4);
            $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();
            return view('projets.index', compact('projets','secteurs'));

        }catch(\Exception $e){
            Log::error('Erreur lors du chargement des projets du porteur', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function create() {

        $this->authorize('create', Projet::class);

        try {
            $secteurs = SecteurActivite::where('statutSecteur', true)
                        ->orderBy('nomSecteur')->get();
            $typesProjets = TypeProjet::where('actif', true)->orderBy('nom')->get();
            $sousDomaines = SousDomaine::where('actif', true)->orderBy('nom')->get();

            return view('projets.create', compact('secteurs', 'typesProjets', 'sousDomaines'));

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement du formulaire de création', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

    public function store(Request $request) {

        $this->authorize('create', Projet::class);

        try {
            $request->validate([
                'titre'          => 'required|string|max:255',
                'description'    => 'required|string',
                'objectif'       => 'nullable|string',
                'type_projet_id'  => 'required|exists:types_projets,id',
                'secteur_id'     => 'required|exists:secteur_activites,id',
                'sous_domaine_id' => 'nullable|exists:sous_domaines,id',
                'duree'          => 'nullable|integer|min:1',
                'dateDebut'      => 'nullable|date',
                'dateFin'        => 'nullable|date|after_or_equal:dateDebut',
                'budgetTotal'    => 'nullable|numeric|min:0',
                'montantDemande' => 'nullable|numeric|min:0',
                'documents'      => 'nullable|array',
                'documents.*'    => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'document_names'   => 'nullable|array',
                'document_names.*' => 'nullable|string|max:255',
            ]);

            if ($request->filled('sous_domaine_id')
                && !SousDomaine::where('id', $request->sous_domaine_id)
                    ->where('secteur_id', $request->secteur_id)
                    ->where('actif', true)
                    ->exists()) {
                return back()->withInput()->withErrors([
                    'sous_domaine_id' => 'Le sous-domaine ne correspond pas au secteur sélectionné.',
                ]);
            }

            $code = 'PRJ-' . strtoupper(substr(md5(uniqid()), 0, 8));

            $projet = Projet::create([
                'codeProjet'     => $code,
                'titre'          => $request->titre,
                'description'    => $request->description,
                'objectif'       => $request->objectif ?? '',
                'type_projet_id' => $request->type_projet_id,
                'sous_domaine_id' => $request->sous_domaine_id,
                'duree'          => $request->duree,
                'dateDebut'      => $request->dateDebut,
                'dateFin'        => $request->dateFin,
                'budgetTotal'    => $request->budgetTotal,
                'montantDemande' => $request->montantDemande,
                'statutProjet'   => 'brouillon',
                'user_id'        => Auth::id(),
                'secteur_id'     => $request->secteur_id,
            ]);

            HistoriqueProjet::create([
                'projet_id' => $projet->id,
                'user_id' => Auth::id(),
                'nouveau_statut' => 'brouillon',
                'action' => 'Création du projet',
            ]);

            Log::info('Création d\'un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'porteur_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $index => $file) {
                    $chemin = $file->store("projets/{$projet->id}/documents", 'public');
                    $nom = str_replace(['\\', '/', ':', '*', '?', '"', '<', '>', '|'], '-', trim($request->input("document_names.{$index}", '')));
                    DocumentProjet::create([
                        'nomFichier'    => $nom !== '' ? $nom . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName(),
                        'typeDocument'  => $file->getClientOriginalExtension(),
                        'cheminFichier' => $chemin,
                        'dateUpload'    => now(),
                        'projet_id'     => $projet->id,
                        'uploader_id'   => Auth::id(),
                    ]);
                }
                Log::info('Documents ajoutés au projet', [
                    'projet_id' => $projet->id,
                    'nombre_documents' => count($request->file('documents') ?? []),
                    'user_id' => Auth::id(),
                ]);
            }

            return redirect()->route('porteur.projets.show', $projet)
                ->with('success', 'Projet créé avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du projet', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('porteur.projets.index')
                ->with('error', 'Une erreur est survenue.');
        }
    }

    public function show(Projet $projet) {

        $this->authorize('view', $projet);

        $projet->load([
            'secteur',
            'documents',
            'commentaires.utilisateur',
            'activites',
        ]);
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

        return view('projets.show', compact('projet','secteurs'));
    }

    public function edit(Projet $projet){

        $this->authorize('update', $projet);
        try{

            $secteurs = SecteurActivite::where('statutSecteur', true)
                            ->orderBy('nomSecteur')
                            ->get();
            return view('porteur.projets.edit', compact('projet', 'secteurs'));

        }catch(\Exception $e){
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function update(Request $request, Projet $projet){

        $this->authorize('update', $projet);

        try{
            $request->validate([
            'titre'         => 'required|string|max:255',
            'description'   => 'required|string',
            'objectif'      => 'nullable|string',
            'type_projet_id' => 'required|exists:types_projets,id',
            'secteur_id'    => 'required|exists:secteur_activites,id',
            'sous_domaine_id' => 'nullable|exists:sous_domaines,id',
            'duree'         => 'nullable|integer|min:1',
            'dateDebut'     => 'nullable|date',
            'dateFin'       => 'nullable|date|after_or_equal:dateDebut',
            'budgetTotal'   => 'nullable|numeric|min:0',
            'montantDemande'=> 'nullable|numeric|min:0',
            ]);

            if ($request->filled('sous_domaine_id')
                && !SousDomaine::where('id', $request->sous_domaine_id)
                    ->where('secteur_id', $request->secteur_id)
                    ->where('actif', true)
                    ->exists()) {
                return back()->withInput()->withErrors([
                    'sous_domaine_id' => 'Le sous-domaine ne correspond pas au secteur sélectionné.',
                ]);
            }

            $projet->update([
                'titre'          => $request->titre,
                'description'    => $request->description,
                'objectif'       => $request->objectif ?? '',
                'type_projet_id' => $request->type_projet_id,
                'sous_domaine_id' => $request->sous_domaine_id,
                'duree'          => $request->duree,
                'dateDebut'      => $request->dateDebut,
                'dateFin'        => $request->dateFin,
                'budgetTotal'    => $request->budgetTotal,
                'montantDemande' => $request->montantDemande,
                'secteur_id'     => $request->secteur_id,
                'planification_demandee' => False,

            ]);
            Log::notice('Mise à jour d’un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('porteur.projets.show', $projet)
                            ->with('success', 'Projet mis à jour.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la mise à jour du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('porteur.projets.show', $projet)
                        ->with('error', 'Une erreur est survenue ');
        }
    }

    public function destroy(Projet $projet) {

        $this->authorize('delete', $projet);

        try{

            foreach ($projet->documents as $doc) {
                Storage::disk('public')->delete($doc->cheminFichier);
            }
            $projet->delete();
            Log::warning('Suppression d’un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
            ]);
            return redirect()->route('porteur.projets.index')
                            ->with('success', 'Projet supprimé.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la suppression du projet', [
                'projet_id' => $projet->id ?? null,
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            return redirect()->route('porteur.projets.show', $projet)
                            ->with('error', 'Une erreur est survenue ');
        }
    }

    public function soumettre(Projet $projet){

        $this->authorize('soumettre', $projet);

        try{

            $projet->update(['dateSoumission' => now()]);
            app(ProjetWorkflowService::class)->transition(
                $projet,
                Auth::user(),
                'soumis',
                'Soumission du projet'
            );

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

            Log::notice('Soumission d’un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
            ]);
            return redirect()->route('porteur.projets.show', $projet)
                            ->with('success', 'Projet soumis avec succès.');

        }catch(\Exception $e){
            Log::error('Erreur lors de la soumission du projet', [
                'message' => $e->getMessage(),
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'porteur_id'  =>Auth::id()
            ]);
            return redirect()->route('porteur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue lors de la soumission? Veuillez réactualiser ');
        }
    }

    public function storeDocument(Request $request, Projet $projet) {

        $this->authorize('uploadDocument', $projet);

        try{

            $request->validate([
                'documents'   => 'required|array',
                'documents.*' => 'file|max:10240|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png',
                'document_names'   => 'nullable|array',
                'document_names.*' => 'nullable|string|max:255',
            ]);

            foreach ($request->file('documents') as $index => $file) {
                $chemin = $file->store("projets/{$projet->id}/documents", 'public');
                $nom = str_replace(['\\', '/', ':', '*', '?', '"', '<', '>', '|'], '-', trim($request->input("document_names.{$index}", '')));
                DocumentProjet::create([
                    'nomFichier'    => $nom !== '' ? $nom . '.' . $file->getClientOriginalExtension() : $file->getClientOriginalName(),
                    'typeDocument'  => $file->getClientOriginalExtension(),
                    'cheminFichier' => $chemin,
                    'dateUpload'    => now(),
                    'projet_id'     => $projet->id,
                    'uploader_id'   => Auth::id(),
                ]);
            }
            Log::info('Ajout de documents au projet', [
                'projet_id' => $projet->id,
                'nombre_documents' => count($request->file('documents')),
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return back()->with('success', 'Documents ajoutés.');

        }catch(\Exception $e){
            Log::error("Erreur lors de l'ajout de document du projet", [
                'message' => $e->getMessage(),
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'porteur_id'  =>Auth::id()
            ]);
            return redirect()->route('porteur.projets.show', $projet)
                ->with('error', 'Une erreur est survenue ');
        }
    }

    public function destroyDocument(Projet $projet, DocumentProjet $document){

        $this->authorize('deleteDocument', $projet);

        try{

            Storage::disk('public')->delete($document->cheminFichier);
            $document->delete();
            Log::warning('Suppression d’un document de projet', [
                'document_id' => $document->id,
                'projet_id' => $projet->id,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
            ]);
            return back()->with('success', 'Document supprimé.');

        }catch(\Exception $e){
            Log::error("Erreur lors de la suppression d'un document du projet", [
                'message' => $e->getMessage(),
                'projet_id' => $projet->id,
                'document' => $document->id,
                'code_projet' => $projet->codeProjet,
                'porteur_id'  =>Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }

    public function downloadDocument(Projet $projet, DocumentProjet $document) {

        $this->authorize('view', $projet);

        $path = storage_path('app/public/' . $document->cheminFichier);
        if (!file_exists($path)) {
            Log::warning('Tentative de téléchargement d’un fichier introuvable', [
                'document_id' => $document->id,
                'chemin' => $document->cheminFichier,
                'user_id' => Auth::id(),
            ]);
            return back()->with('error', 'Fichier introuvable.');
        }
        Log::info('Téléchargement d’un document', [
                'document_id' => $document->id,
                'projet_id' => $projet->id,
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
            ]);
        return response()->download($path, $document->nomFichier);
    }


    public function demanderPlanification(Projet $projet) {

        $this->authorize('gererPlanification', $projet);

        try {
            $projet->update([
                'planification_demandee' => true,
            ]);

            $user = Auth::user();

            // Notifier les PLANIFICATEURS
            NotificationService::notifierPlanificateurs(
                $user->nomComplet.' demande une planification pour le projet « ' . $projet->titre . ' » (' . $projet->codeProjet . ').',
                'info',
                $projet->id
            );

            Log::notice('Demande de planification envoyée', [
                'projet_id'  => $projet->id,
                'code_projet'=> $projet->codeProjet,
                'user_id'    => Auth::id(),
            ]);

            return back()->with('success', 'Demande de planification envoyée aux planificateurs.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la demande de planification', [
                'projet_id' => $projet->id,
                'message'   => $e->getMessage(),
                'user_id'   => Auth::id(),
            ]);
            return back()->with('error', 'Une erreur est survenue.');
        }
    }

}
