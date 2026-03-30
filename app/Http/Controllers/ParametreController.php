<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'nomComplet' => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . Auth::id(),
            'matricule'  => 'nullable|string|max:50',
            'fonction'   => 'nullable|string|max:100',
            'contact'    => 'nullable|string|max:50',
        ]);

        Auth::user()->update([
            'nomComplet' => $request->nomComplet,
            'email'      => $request->email,
            'matricule'  => $request->matricule,
            'fonction'   => $request->fonction,
            'contact'    => $request->contact,
        ]);

        return redirect()->route('parametres.profil')
                            ->with('success', 'Profil mis à jour avec succès.');
    }

    //  Sécurité
    public function securite() {
        return view('parametres.securite');
    }

    public function securiteUpdate(Request $request) {
        $request->validate([
            'current_password'     => 'required',
            'new_password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.'
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('parametres.securite')
                            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    //  Notifications
    public function notifications()
    {
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
        $request->validate([
            'langue'   => 'required|in:fr,en',
            'timezone' => 'required|string',
        ]);

        return redirect()->route('parametres.general')
                            ->with('success', 'Paramètres généraux mis à jour.');
    }
}
