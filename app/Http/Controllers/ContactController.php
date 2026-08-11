<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller {

    public function envoyer(Request $request) {
        
        $data = $request->validate([
            'email'  => 'required|email|max:255',
            'objet'  => 'required|string|max:255',
            'message'=> 'required|string|max:5000',
        ]);

        try {
            Mail::raw(
                "De : {$data['email']}\n\n{$data['message']}",
                function ($mail) use ($data) {
                    $mail->to(config('mail.admin_address', 'gesprojet@gmail.com'))
                        ->subject('[CIFEU - Contact] ' . $data['objet'])
                        ->replyTo($data['email']);
                }
            );
        } catch (\Exception $e) {
            Log::error('Erreur envoi formulaire de contact', ['message' => $e->getMessage()]);
            return back()->withErrors(['message' => "L'envoi a échoué, réessaie plus tard."])->withInput();
        }

        return back()->with('contact_success', 'Ton message a bien été envoyé, merci !');
    }
}
