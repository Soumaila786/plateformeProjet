<?php

namespace App\Mail;

use App\Models\Projet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjetValideMail extends Mailable
{
    use Queueable, SerializesModels;

    public $projet;

    public function __construct(Projet $projet)
    {
        $this->projet = $projet;
    }

    public function build()
    {
        return $this
            ->subject('Felicitations - Votre projet ' . $this->projet->codeProjet . ' a ete valide')
            ->view('emails.projet_valide')
            ->with(['projet' => $this->projet]);
    }
}
