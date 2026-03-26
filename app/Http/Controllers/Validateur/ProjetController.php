<?php

namespace App\Http\Controllers\Validateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\SecteurActivite;
use App\Models\Commentaire;
use App\Services\MailService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller {
    protected $mailService;
    protected $notifService;

    public function __construct(MailService $mailService, NotificationService $notifService) {
        $this->mailService  = $mailService;
        $this->notifService = $notifService;
    }

    // Liste A valider (avec recherche + filtre secteur)
    public function index(Request $request) {
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

        $query = Projet::with(['secteur', 'porteur'])
            ->where('statutProjet', 'approuve');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('titre', 'like', '%'.$s.'%')
                    ->orWhere('codeProjet', 'like', '%'.$s.'%');
            });
        }

        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }

        $projets = $query->orderBy('updated_at', 'asc')->paginate(10);

        return view('validateur.projets.index', compact('projets', 'secteurs'));
    }

    // Mes projets traités
    public function mesProjets(Request $request) {
        $secteurs = SecteurActivite::where('statutSecteur', true)->orderBy('nomSecteur')->get();

        $query = Projet::with(['secteur', 'porteur'])
            ->where('validated_by', Auth::id());

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('titre', 'like', '%'.$s.'%')
                    ->orWhere('codeProjet', 'like', '%'.$s.'%');
            });
        }

        if ($request->filled('secteur_id')) {
            $query->where('secteur_id', $request->secteur_id);
        }

        if ($request->filled('statut')) {
            $query->where('statutProjet', $request->statut);
        }

        $projets = $query->orderBy('validated_at', 'desc')->paginate(10);

        // Récupérer le motif de rejet depuis les commentaires
        $projets->getCollection()->transform(function ($p) {
            $p->motifRejet = null;
            if ($p->statutProjet === 'rejete') {
                $com = Commentaire::where('projet_id', $p->id)
                    ->where('typeCommentaire', 'rejet')
                    ->latest('dateEnvoi')
                    ->first();
                $p->motifRejet = $com ? $com->message : null;
            }
            return $p;
        });

        return view('validateur.projets.mes_projets', compact('projets', 'secteurs'));
    }

    // Détail d'un projet
    public function show(Projet $projet) {
        $projet->load(['secteur', 'porteur', 'planifications', 'documents', 'commentaires.utilisateur']);
        return view('validateur.projets.show', compact('projet'));
    }

    // Valider
    public function valider(Request $request, Projet $projet) {
        $request->validate([
            'commentaire' => 'nullable|string|max:1000',
        ]);

        if ($projet->statutProjet !== 'approuve') {
            return back()->with('error', 'Ce projet ne peut pas être validé dans son état actuel.');
        }

        $projet->statutProjet   = 'valide';
        $projet->validated_by   = Auth::id();
        $projet->validated_at   = now();
        $projet->dateValidation = now();
        $projet->save();

        if ($request->filled('commentaire')) {
            Commentaire::create([
                'message'         => $request->commentaire,
                'typeCommentaire' => 'approbation',
                'dateEnvoi'       => now(),
                'projet_id'       => $projet->id,
                'utilisateur_id'  => Auth::id(),
            ]);
        }

        NotificationService::notifierPorteur(
            $projet,
            'Félicitations ! Votre projet « '.$projet->titre.' » a été validé.',
            'validation'
        );

        try { $this->mailService->envoyerProjetValide($projet); } catch (\Exception $e) {}

        return redirect()->route('validateur.projets.index')
            ->with('success', 'Le projet « '.$projet->titre.' » a été validé avec succès.');
    }

    // Rejeter
    public function rejeter(Request $request, Projet $projet) {
        $request->validate([
            'motifRejet' => 'required|string|min:5|max:1000',
        ]);

        if ($projet->statutProjet !== 'approuve') {
            return back()->with('error', 'Ce projet ne peut pas être rejeté dans son état actuel.');
        }

        $projet->statutProjet   = 'rejete';
        $projet->validated_by   = Auth::id();
        $projet->validated_at   = now();
        $projet->dateValidation = now();
        $projet->save();

        Commentaire::create([
            'message'         => $request->motifRejet,
            'typeCommentaire' => 'rejet',
            'dateEnvoi'       => now(),
            'projet_id'       => $projet->id,
            'utilisateur_id'  => Auth::id(),
        ]);

        NotificationService::notifierPorteur(
            $projet,
            'Votre projet « '.$projet->titre.' » a été rejeté par le validateur. Motif : '.$request->motifRejet,
            'rejet'
        );

        return redirect()->route('validateur.projets.index')
            ->with('success', 'Le projet a été rejeté.');
    }
}
