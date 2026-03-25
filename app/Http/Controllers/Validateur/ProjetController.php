<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use \App\Models\SecteurActivite;
use App\Services\MailService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    protected $mailService;
    protected $notifService;

    public function __construct(MailService $mailService, NotificationService $notifService){
        $this->mailService  = $mailService;
        $this->notifService = $notifService;
    }

    // ── Liste projets approuvés (à valider) ──
    public function index(Request $request){
        $query = Projet::with(['porteur', 'secteur'])
            ->where('statutProjet', ['approuve', 'valide']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('titre', 'like', "%$s%")
                    ->orWhere('codeProjet', 'like', "%$s%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statutProjet', $request->secteur);
        }

        $projets  = $query->orderBy('updated_at', 'desc')->paginate(12);
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();


        return view('validateur.projets.index', compact('projets', 'secteurs'));
    }

    // ── Détail projet ──
    public function show(Projet $projet){
        $projet->load(['secteur', 'porteur', 'documents', 'commentaires.utilisateur', 'activites']);
        return view('validateur.projets.show', compact('projet'));
    }

    // ── Valider ──
    public function valider(Request $request, Projet $projet){
        $request->validate([
            'commentaire' => 'nullable|string|max:1000',
        ]);

        if ($projet->statutProjet !== 'approuve') {
            return back()->with('error', 'Ce projet ne peut pas être validé dans son état actuel.');
        }

        $projet->statutProjet  = 'valide';
        $projet->validated_at  = now();
        $projet->validated_by  = Auth::id();
        $projet->dateValidation= now();
        $projet->save();

        // Commentaire validateur
        if ($request->filled('commentaire')) {
            $projet->Commentaire()->create([
                'message'         => $request->commentaire,
                'typeCommentaire' => 'approbation',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
        }

        // Notifications
        try {
            $this->mailService->envoyerProjetValide($projet);
        } catch (\Exception $e) {}

        try {
            NotificationService::notifierPorteur(
            $projet,
            'Félicitations ! Votre projet « ' . $projet->titre . ' » a été valider.',
            'Validateur'
        );
        } catch (\Exception $e) {}

        return redirect()
            ->route('validateur.projets.index')
            ->with('success', 'Le projet « ' . $projet->titre . ' » a été validé avec succès.');
    }

    // ── Rejeter ──
    public function rejeter(Request $request, Projet $projet){
        $request->validate([
            'motif_rejet' => 'required|string|min:10|max:1000',
        ]);

        if ($projet->statutProjet !== 'approuve') {
            return back()->with('error', 'Ce projet ne peut pas être rejeté dans son état actuel.');
        }

        $projet->statutProjet  = 'rejete';
        $projet->motifRejet    = $request->motif_rejet;
        $projet->validated_at  = now();
        $projet->validated_by  = Auth::id();
        $projet->save();

        // Commentaire rejet
        $projet->Commentaire()->create([
                'message'         => $request->commentaire,
                'typeCommentaire' => 'approbation',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);

        // Notifications
        try {
            $this->notifService->notifier(
                $projet->porteur,
                'Projet rejeté',
                'Votre projet « ' . $projet->titre . ' » a été rejeté lors de la validation finale.',
                'rejete',
                route('porteur.projets.show', $projet)
            );
        } catch (\Exception $e) {}

        return redirect()
            ->route('validateur.projets.index')
            ->with('success', 'Le projet « ' . $projet->titre . ' » a été rejeté.');
    }
}
