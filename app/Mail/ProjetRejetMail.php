<?php

namespace App\Mail;

use App\Models\Projet;
use App\Models\Commentaire;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjetRejetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projet;
    public $commentaire;

    public function __construct(Projet $projet, $commentaire)
    {
        $this->projet = $projet;
        $this->commentaire = $commentaire;
    }

    public function build()
    {
        return $this
            ->subject('Votre projet ' . $this->projet->codeProjet . ' a été rejeté')
            ->view('emails.projet_rejete')
            ->with([
                'projet' => $this->projet,
                'commentaire' => $this->commentaire
            ]);
    }
}