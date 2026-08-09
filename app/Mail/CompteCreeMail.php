<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompteCreeMail extends Mailable {

    use Queueable, SerializesModels;

    public $user;
    public $password;

    public function __construct(User $user, $password){
        $this->user     = $user;
        $this->password = $password;
    }

    public function build() {
        return $this
            ->subject('Bienvenue sur GesProjet - Votre compte a ete cree')
            ->view('emails.compte_cree')
            ->with([
                'user'     => $this->user,
                'password' => $this->password,
            ]);
    }
}
