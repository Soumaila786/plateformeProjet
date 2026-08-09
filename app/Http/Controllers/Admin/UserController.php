<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use App\Helpers\PasswordGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller {

    protected $mailService;

    public function __construct(MailService $mailService){

        $this->mailService = $mailService;
    }

    // Liste
    public function index(Request $request){

        $this->authorize('viewAny', User::class);

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

            $users = $query->latest('created_at')->paginate(5);

            return view('users.index', compact('users'));

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

        $this->authorize('create', User::class);

        return view('admin.users.create');
    }

    // Enregistrer
    public function store(Request $request){

        $this->authorize('create', User::class);

        try {
            $request->validate([
                'nomComplet'  => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'role'        => 'required|in:admin,porteur,approbateur,validateur,planificateur',
                'fonction'    => 'nullable|string|max:100',
                'matricule'   => 'nullable|string|max:100',
                'contact'     => 'nullable|string|max:20',
                'organisation'=> 'nullable|string|max:255',

                'specialite'        => 'nullable|string|max:255',
                'service'           => 'nullable|string|max:255',
                'poste'             => 'nullable|string|max:255',
                'dateDebutMandat'   => 'nullable|date',
                'dateFinMandat'     => 'nullable|date',
            ]);

            $password = PasswordGenerator::generate(10);

            $user = User::create([
                'nomComplet'   => $request->nomComplet,
                'email'        => $request->email,
                'role'         => $request->role,
                'password'     => Hash::make($password),
                'fonction'     => $request->fonction,
                'matricule'    => $request->matricule,
                'contact'      => $request->contact,
                'organisation' => $request->organisation,
                'actif'        => true,

                'specialite'      => $request->role === 'porteur' ? $request->specialite : null,
                'service'         => in_array($request->role, ['planificateur', 'approbateur']) ? $request->service : null,
                'poste'           => $request->role === 'approbateur' ? $request->poste : null,
                'dateDebutMandat' => $request->role === 'validateur' ? $request->dateDebutMandat : null,
                'dateFinMandat'   => $request->role === 'validateur' ? $request->dateFinMandat : null,
            ]);

            // Synchronise le rôle Spatie (source de vérité des permissions) avec
            // la colonne 'role' choisie dans le formulaire.
            $user->syncRoles([$request->role]);

            $this->mailService->envoyerCompteCreee($user, $password);

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

        $this->authorize('view', $user);

        try {
            $user->detailsRole = $this->resoudreDetailsRole($user);

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

        $this->authorize('update', $user);

        try {
            $user->detailsRole = $this->resoudreDetailsRole($user);

            return view('admin.users.edit', compact('user'));

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Une erreur est survenue ' );
        }
    }

    // Mettre à jour
    public function update(Request $request, User $user){

        $this->authorize('update', $user);

        try {
            $request->validate([
                'nomComplet'   => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email,' . $user->id,
                'role'         => 'required|in:admin,porteur,approbateur,validateur,planificateur',
                'fonction'     => 'nullable|string|max:100',
                'matricule'    => 'nullable|string|max:100',
                'contact'      => 'nullable|string|max:20',
                'organisation' => 'nullable|string|max:255',
                'password'     => 'nullable|string|min:8|confirmed',

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
                'fonction'     => $request->fonction,
                'matricule'    => $request->matricule,
                'contact'      => $request->contact,
                'organisation' => $request->organisation,

                'specialite'      => $request->role === 'porteur' ? $request->specialite : null,
                'service'         => in_array($request->role, ['planificateur', 'approbateur']) ? $request->service : null,
                'poste'           => $request->role === 'approbateur' ? $request->poste : null,
                'dateDebutMandat' => $request->role === 'validateur' ? $request->dateDebutMandat : null,
                'dateFinMandat'   => $request->role === 'validateur' ? $request->dateFinMandat : null,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $ancienRole = $user->role;
            $ancienEmail = $user->email;

            $user->update($data);

            // Resynchronise le rôle Spatie si le rôle a changé (ou même s'il n'a pas
            // changé, syncRoles() est idempotent)
            $user->syncRoles([$request->role]);

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

        $this->authorize('delete', $user);

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

        $this->authorize('toggleStatus', $user);

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

    /**
     * Calcule le libellé "détails du rôle" à afficher, selon le rôle de l'utilisateur.
     */
    private function resoudreDetailsRole(User $user): string {

        switch ($user->role) {
            case 'porteur':
                return $user->specialite ?? '—';

            case 'planificateur':
                return $user->service ?? '—';

            case 'approbateur':
                return $user->poste ?? '—';

            case 'validateur':
                if ($user->dateDebutMandat) {
                    $dateFin = $user->dateFinMandat ? $user->dateFinMandat->format('d/m/Y') : '—';
                    return 'Mandat du ' . $user->dateDebutMandat->format('d/m/Y') . ' au ' . $dateFin;
                }
                return '—';

            default:
                return $user->organisation ?? '—';
        }
    }
}
