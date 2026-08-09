<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable {

    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    public function __construct(User $user, string $resetUrl){
        $this->user     = $user;
        $this->resetUrl = $resetUrl;
    }

    public function build() {
        return $this
            ->subject('Réinitialisation de votre mot de passe - GesProjet')
            ->view('emails.reset_password')
            ->with([
                'user'     => $this->user,
                'resetUrl' => $this->resetUrl,
            ]);
    }
}