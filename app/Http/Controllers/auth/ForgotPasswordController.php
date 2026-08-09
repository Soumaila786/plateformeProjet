<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller {

    public function showLinkRequestForm() {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request) {

        $request->validate(['email' => 'required|email']);

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            Log::info('Demande de réinitialisation de mot de passe', [
                'email' => $request->email,
                'status' => $status,
                'ip' => $request->ip(),
            ]);

            // NOTE : on affiche le même message de succès que l'email existe ou non,
            // pour ne pas révéler quels emails sont enregistrés dans le système.
            return back()->with('success', 'Si cette adresse existe dans notre système, un email de réinitialisation vient de vous être envoyé.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l’envoi du lien de réinitialisation', [
                'email' => $request->email ?? null,
                'message' => $e->getMessage(),
            ]);
            return back()->with('success', 'Si cette adresse existe dans notre système, un email de réinitialisation vient de vous être envoyé.');
        }
    }
}