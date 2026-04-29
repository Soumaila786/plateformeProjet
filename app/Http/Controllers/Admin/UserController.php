<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Porteur;
use App\Models\Planificateur;
use App\Models\Approbateur;
use App\Models\Validateur;
use App\Services\MailService;
use App\Helpers\PasswordGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller {

    protected $mailService;

    // Injection du service dans le constructeur
    public function __construct(MailService $mailService){

        $this->mailService = $mailService;
    }

    // Liste
    public function index(Request $request){

        try {
            $query = User::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nomComplet', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }

            if ($request->filled('role')) {
                $query->where('role', $request->role);
            }

            if ($request->filled('actif')) {
                $query->where('actif', $request->actif === '1');
            }

            $users = $query->latest('created_at')->paginate(15);

            return view('admin.users.index', compact('users'));

        } catch (\Exception $e) {

            Log::error('Erreur lors du chargement des utilisateurs', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id(),
            ]);
            return back()->with('error', "Une erreur est survenue lors du chargement des utilisateurs.");
        }
    }

    // Formulaire création
    public function create(){

        return view('admin.users.create');
    }

    // Enregistrer
    public function store(Request $request){

        try {
            $request->validate([
                'nomComplet'  => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'role'        => 'required|in:admin,porteur,approbateur,validateur,planificateur',
                'fonction'    => 'nullable|string|max:100',
                'matricule'   => 'nullable|string|max:100',
                'contact'     => 'nullable|string|max:20',
                'organisation'=> 'nullable|string|max:255',

                // champs dynamiques
                'specialite'        => 'nullable|string|max:255',
                'service'           => 'nullable|string|max:255',
                'poste'             => 'nullable|string|max:255',
                'dateDebutMandat'   => 'nullable|date',
                'dateFinMandat'     => 'nullable|date',
            ]);
            // Méthode pour généérer un mot de passe avec des caractères+chifrres+alphanumériques
            $motDePasse = PasswordGenerator::generate(10);

            $user = User::create([
                'nomComplet'   => $request->nomComplet,
                'email'        => $request->email,
                'role'         => $request->role,
                'motDePasse'   => Hash::make($motDePasse),
                'fonction'     => $request->fonction,
                'matricule'    => $request->matricule,
                'contact'      => $request->contact,
                'organisation' => $request->organisation,
                'actif'        => true,
                'dateCreation' => now(),
            ]);

            // PORTEUR
            if ($request->role == 'porteur') {

                Porteur::create([
                    'user_id'    => $user->id,
                    'specialite' => $request->specialite,
                ]);
            }

            // Planificateur
            if($request->role === 'planificateur'){

                Planificateur::create([
                    'user_id' =>$user->id,
                    'service' => $request->service
                ]);
            }
            // APPROBATEUR
            if ($request->role == 'approbateur') {

                Approbateur::create([
                    'user_id' => $user->id,
                    'service' => $request->service,
                    'poste'   => $request->poste,
                ]);
            }
            // VALIDATEUR
            if ($request->role == 'validateur') {

                Validateur::create([
                    'user_id'          => $user->id,
                    'dateDebutMandat'  => $request->dateDebutMandat,
                    'dateFinMandat'    => $request->dateFinMandat,
                ]);
            }

            $this->mailService->envoyerCompteCreee($user, $motDePasse);

            Log::info('Email de création de compte envoyé', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur créé avec succès.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de la création d’un utilisateur', [
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->back()
                ->with('error', "Une erreur est survenue lors de la création de l'utilisateur");
        }
    }

    // Détail
    public function show(User $user) {

        try {
            // Charger toutes les relations possibles
            $user->load('porteur', 'approbateur', 'validateur','planificateur');

            // Ajouter des champs dynamiques selon le rôle
            if ($user->role === 'porteur') {
                $user->detailsRole = isset($user->porteur) ? $user->porteur->structure : '—';

            } elseif($user->role === 'planificateur'){
                $user->detailsRole = isset($user->planificateur) ? $user->planificateur->service : '—';

            }elseif ($user->role === 'approbateur') {
                $user->detailsRole = isset($user->approbateur) ? $user->approbateur->poste : '—';

            } elseif ($user->role === 'validateur') {

                if (isset($user->validateur) && $user->validateur->dateDebutMandat) {
                    // isset return un booleen et permet de verifier si la variable existe et n'est pas null
                    // Pour eviter les crash
                    $dateFin = isset($user->validateur->dateFinMandat)
                                ? $user->validateur->dateFinMandat->format('d/m/Y')
                                : '—';

                    $user->detailsRole = 'Mandat du ' . $user->validateur->dateDebutMandat->format('d/m/Y')
                                            . ' au ' . $dateFin;

                } else {
                    $user->detailsRole = '—';

                }
            } else {
                $user->detailsRole = $user->organisation ?? '—';

            }

            return view('admin.users.show', compact('user'));

        } catch (\Exception $e) {

            Log::error("Erreur lors de l’affichage d’un utilisateur", [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue' );
        }
    }

    // Formulaire édition
    public function edit(User $user){

        try {
            // Charger toutes les relations possibles
            $user->load('porteur', 'approbateur', 'validateur','planificateur');

            // Ajouter des champs dynamiques selon le rôle
            if ($user->role === 'porteur') {
                $user->detailsRole = isset($user->porteur) ? $user->porteur->structure : '—';

            } elseif ($user->role === 'planificateur') {
                $user->detailsRole = isset($user->planificateur) ? $user->planificateur->service : '—';

            }elseif ($user->role === 'approbateur') {
                $user->detailsRole = isset($user->approbateur) ? $user->approbateur->poste : '—';

            } elseif ($user->role === 'validateur') {
                if (isset($user->validateur) && $user->validateur->dateDebutMandat) {
                    $dateFin = isset($user->validateur->dateFinMandat)
                                ? $user->validateur->dateFinMandat->format('d/m/Y')
                                : '—';
                    $user->detailsRole = 'Mandat du ' . $user->validateur->dateDebutMandat->format('d/m/Y')
                                            . ' au ' . $dateFin;
                } else {
                    $user->detailsRole = '—';
                }
            } else {
                $user->detailsRole = $user->organisation ?? '—';
            }

            return view('admin.users.edit', compact('user'));

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Une erreur est survenue ' );
        }
    }

    // Mettre à jour
    public function update(Request $request, User $user){

        try {
            $request->validate([
                'nomComplet'   => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email,' . $user->id,
                'role'         => 'required|in:admin,porteur,approbateur,validateur',
                'fonction'     => 'nullable|string|max:100',
                'matricule'    => 'nullable|string|max:100',
                'contact'      => 'nullable|string|max:20',
                'organisation' => 'nullable|string|max:255',
                'motDePasse'   => 'nullable|string|min:8|confirmed',

                // dynamiques
                'specialite'        => 'nullable|string|max:255',
                'service'           => 'nullable|string|max:255',
                'poste'             => 'nullable|string|max:255',
                'dateDebutMandat'   => 'nullable|date',
                'dateFinMandat'     => 'nullable|date',
            ]);

            $data = [
                'nomComplet'   => $request->nomComplet,
                'email'        => $request->email,
                'role'         => $request->role,
                'fonction'     => $request->fonction,  // Correction ici
                'matricule'    => $request->matricule,
                'contact'      => $request->contact,
                'organisation' => $request->organisation,
            ];

            if ($request->filled('motDePasse')) {
                $data['motDePasse'] = Hash::make($request->motDePasse);
            }

            $ancienRole = $user->role;
            $ancienEmail = $user->email;

            $user->update($data);

            // PORTEUR
            if ($request->role == 'porteur') {
                $user->porteur()->updateOrCreate(
                    ['user_id' => $user->id], [ 'specialite' => $request->specialite, ]
                );
            } elseif ($request->role == 'planificateur') {
                $user->planificateur()->updateOrCreate(
                    ['user_id' => $user->id], [ 'service' => $request->service, ]
                );
            } elseif ($request->role == 'approbateur') {
                // APPROBATEUR
                $user->approbateur()->updateOrCreate(
                    ['user_id' => $user->id],
                    ['service' => $request->service,
                        'poste'   => $request->poste,
                    ]
                );

                // Supprimer les autres relations si le rôle change
                if ($user->porteur) $user->porteur()->delete();
                if ($user->validateur) $user->validateur()->delete();

            } elseif ($request->role == 'validateur') {
                // VALIDATEUR
                $user->validateur()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'dateDebutMandat' => $request->dateDebutMandat,
                        'dateFinMandat'   => $request->dateFinMandat,
                    ]
                );

                // Supprimer les autres relations si le rôle change
                if ($user->porteur) $user->porteur()->delete();
                if ($user->planificateur) $user->planificateur()->delete();
                if ($user->approbateur) $user->approbateur()->delete();

            } else {
                // Pour le rôle admin, supprimer toutes les relations spécifiques
                if ($user->porteur) $user->porteur()->delete();
                if ($user->planificateur) $user->planificateur()->delete();
                if ($user->approbateur) $user->approbateur()->delete();
                if ($user->validateur) $user->validateur()->delete();
            }

            Log::notice('Mise à jour d’un utilisateur', [
                'user_id' => $user->id,
                'ancien_role' => $ancienRole,
                'nouveau_role' => $user->role,
                'ancien_email' => $ancienEmail,
                'nouveau_email' => $user->email,
                'admin_id' => Auth::id(),
                'ip' => $request->ip()
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur mis à jour avec succès.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de la mise à jour d’un utilisateur', [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue');
        }
    }

    // Supprimer
    public function destroy(User $user){

        try {
            if ($user->projets()->count() > 0) {

                Log::warning('Tentative de suppression d’un utilisateur ayant des projets', [
                    'user_id' => $user->id,
                    'admin_id' => Auth::id(),
                    'ip' => request()->ip()
                ]);

                return redirect()->route('admin.users.index')
                    ->with('error', 'Impossible de supprimer un utilisateur ayant des projets.');
            }
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de la suppression d’un utilisateur', [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);

            return redirect()->route('admin.users.index')
            ->with('error', 'Une erreur est survenue');
        }
    }

    // Activer / Désactiver
    public function toggleStatus(User $user) {

        try {
            $ancienStatut = $user->actif;
            $user->update(['actif' => !$user->actif]);

            Log::warning('Changement de statut d’un utilisateur', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ancien_statut' => $ancienStatut,
                'nouveau_statut' => $user->actif,
                'admin_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            $msg = $user->actif ? 'Compte activé.' : 'Compte désactivé.';

            $this->mailService->envoyerCompteDesactive($user);

            Log::info('Notification de statut envoyée par email', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            return back()->with('success', $msg);

        } catch (\Exception $e) {

            Log::error('Erreur lors du changement de statut d’un utilisateur', [
                'user_id' => $user->id ?? null,
                'message' => $e->getMessage(),
                'admin_id' => Auth::id()
            ]);
            return back()->with('error', 'Une erreur est survenue ');
        }
    }
}
