<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ParametreController extends Controller {

    public function __construct() {

        $this->middleware('auth');
    }

    //  Index
    public function index() {

        return view('parametres.index');
    }

    //  Profil
    public function profil() {

        return view('parametres.profil');
    }

    public function profilUpdate(Request $request) {

        try{

            $user = Auth::user();

            $request->validate([
                'nomComplet' => 'required|string|max:255',
                'email'      => 'required|email|unique:users,email,' . $user->id,
                'contact'    => 'nullable|string|max:50',
                // Champs spécifiques au rôle (directement sur users, plus de tables satellites)
                'specialite'      => 'nullable|string|max:255',
                'service'         => 'nullable|string|max:255',
                'poste'           => 'nullable|string|max:255',
                'dateDebutMandat' => 'nullable|date',
                'dateFinMandat'   => 'nullable|date',
            ]);

            $data = [
                'nomComplet' => $request->nomComplet,
                'email'      => $request->email,
                'contact'    => $request->contact,
            ];

            // NOTE : porteur()/approbateur()/validateur() n'existent plus (tables satellites
            // fusionnées dans users). On met à jour directement les colonnes concernées,
            // selon le rôle de l'utilisateur.
            if ($user->role === 'porteur') {
                $data['specialite'] = $request->specialite;

            } elseif ($user->role === 'approbateur') {
                $data['service'] = $request->service;
                $data['poste']   = $request->poste;

            } elseif ($user->role === 'planificateur') {
                $data['service'] = $request->service;

            } elseif ($user->role === 'validateur') {
                $data['dateDebutMandat'] = $request->dateDebutMandat;
                $data['dateFinMandat']   = $request->dateFinMandat;
            }

            $user->update($data);

            Log::notice('Mise à jour du profil utilisateur', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('parametres.profil')
                ->with('success', 'Profil mis à jour avec succès.');

        }catch (\Exception $e){
            Log::error('Erreur lors de la mise à jour du profil', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }

    //  Sécurité
    public function securite() {

        return view('parametres.securite');
    }

    public function securiteUpdate(Request $request) {
        try{

            $request->validate([
                'current_password'     => 'required',
                'new_password'         => 'required|min:8|confirmed',
            ]);

            Log::info('Tentative de modification du mot de passe', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);
            if (!Hash::check($request->current_password, Auth::user()->password)) {
                Log::warning('Échec de modification du mot de passe : mot de passe actuel incorrect', [
                    'user_id' => Auth::id(),
                    'ip' => $request->ip(),
                ]);
                return back()->withErrors([
                    'current_password' => 'Le mot de passe actuel est incorrect.'
                ]);
            }

            Auth::user()->update([
                'password' => Hash::make($request->new_password),
            ]);
            Log::warning('Mot de passe modifié avec succès', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
            ]);

            return redirect()->route('parametres.securite')
                ->with('success', 'Mot de passe mis à jour avec succès.');

        }catch (\Exception $e){
            Log::error('Erreur lors du changement du mot de passe', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }

    //  Notifications
    public function notifications() {

        return view('parametres.notifications');
    }

    public function notificationsUpdate(Request $request) {

        return redirect()->route('parametres.notifications')
            ->with('success', 'Préférences de notifications mises à jour.');
    }

    //  Général
    public function general() {

        return view('parametres.general');
    }

    public function generalUpdate(Request $request) {

        try{
            $request->validate([
                'langue'   => 'required|in:fr,en',
                'timezone' => 'required|string',
            ]);
            Log::notice('Mise à jour des paramètres généraux', [
                'user_id' => Auth::id(),
                'langue' => $request->langue,
                'timezone' => $request->timezone,
                'ip' => $request->ip(),
            ]);

            return redirect()->route('parametres.general')
                ->with('success', 'Paramètres généraux mis à jour.');

        }catch (\Exception $e){
            Log::error('Erreur lors de la mise à jour des paramètres généraux', [
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }
}
