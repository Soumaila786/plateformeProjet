<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteCreeMail extends Mailable {

    use Queueable, SerializesModels;

    public $user;
    public $motDePasse;

    public function __construct(User $user, $motDePasse){
        $this->user       = $user;
        $this->motDePasse = $motDePasse;
    }

    public function build() {
        return $this
            ->subject('Bienvenue sur GesProjet - Votre compte a ete cree')
            ->view('emails.compte_cree')
            ->with([
                'user'       => $this->user,
                'motDePasse' => $this->motDePasse,
            ]);
    }
}
