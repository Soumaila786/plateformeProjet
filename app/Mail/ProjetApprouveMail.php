<?php

namespace App\Mail;

use App\Models\Projet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjetApprouveMail extends Mailable
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
            ->subject('Votre projet ' . $this->projet->codeProjet . ' a ete approuve')
            ->view('emails.projet_approuve')
            ->with(['projet' => $this->projet]);
    }
}
