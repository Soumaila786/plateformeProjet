<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use App\Helpers\PasswordGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    protected $mailService;

    // Injection du service dans le constructeur
    public function __construct(MailService $mailService){
        $this->mailService = $mailService;
    }

    // Liste
    public function index(Request $request){
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
    }

    // Formulaire création
    public function create(){
        return view('admin.users.create');
    }

    // Enregistrer
    public function store(Request $request){

        $request->validate([
            'nomComplet'  => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'role'        => 'required|in:admin,porteur,approbateur,validateur',
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
            \App\Models\Porteur::create([
                'user_id'    => $user->id,
                'specialite' => $request->specialite,
            ]);
        }

        // APPROBATEUR
        if ($request->role == 'approbateur') {
            \App\Models\Approbateur::create([
                'user_id' => $user->id,
                'service' => $request->service,
                'poste'   => $request->poste,
            ]);
        }

        // VALIDATEUR
        if ($request->role == 'validateur') {
            \App\Models\Validateur::create([
                'user_id'          => $user->id,
                'dateDebutMandat'  => $request->dateDebutMandat,
                'dateFinMandat'    => $request->dateFinMandat,
            ]);
        }

        $this->mailService->envoyerCompteCreee($user, $motDePasse);

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    // Détail
    public function show(User $user) {
        // Charger toutes les relations possibles
        $user->load('porteur', 'approbateur', 'validateur');

        // Ajouter des champs dynamiques selon le rôle
        if ($user->role === 'porteur') {
            $user->detailsRole = isset($user->porteur) ? $user->porteur->structure : '—';
        } elseif ($user->role === 'approbateur') {
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

        return view('admin.users.show', compact('user'));
    }

    // Formulaire édition
    public function edit(User $user){

        // Charger toutes les relations possibles
        $user->load('porteur', 'approbateur', 'validateur');

        // Ajouter des champs dynamiques selon le rôle
        if ($user->role === 'porteur') {
            $user->detailsRole = isset($user->porteur) ? $user->porteur->structure : '—';
        } elseif ($user->role === 'approbateur') {
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
    }

    // Mettre à jour
    public function update(Request $request, User $user){

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

        $user->update($data);

        // PORTEUR
        if ($request->role == 'porteur') {
            $user->porteur()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialite' => $request->specialite,
                ]
            );
        } elseif ($request->role == 'approbateur') {
            // APPROBATEUR
            $user->approbateur()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'service' => $request->service,
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
            if ($user->approbateur) $user->approbateur()->delete();

        } else {
            // Pour le rôle admin, supprimer toutes les relations spécifiques
            if ($user->porteur) $user->porteur()->delete();
            if ($user->approbateur) $user->approbateur()->delete();
            if ($user->validateur) $user->validateur()->delete();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Supprimer
    public function destroy(User $user){
        if ($user->projets()->count() > 0) {
            return redirect()->route('admin.users.index')
                                ->with('error', 'Impossible de supprimer un utilisateur ayant des projets.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }

    // Activer / Désactiver
    public function toggleStatus(User $user) {
        $user->update(['actif' => !$user->actif]);
        $msg = $user->actif ? 'Compte activé.' : 'Compte désactivé.';

        $this->mailService->envoyerCompteDesactive($user);

        return back()->with('success', $msg);
    }
}
