<?php

namespace App\Services;

use App\Mail\CompteCreeMail;
use App\Mail\CompteDesactiveMail;
use App\Mail\ProjetApprouveMail;
use App\Mail\ProjetRejetMail;
use App\Mail\ProjetValideMail;
use App\Models\Projet;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService {

    // ── Compte créé
    public function envoyerCompteCreee(User $user, $motDePasse){
        try {
            Mail::to($user->email)->send(new CompteCreeMail($user, $motDePasse));
        } catch (\Exception $e) {
            Log::error('MailService::envoyerCompteCree - ' . $e->getMessage());
        }
    }

    // ── Compte désactivé
    public function envoyerCompteDesactive(User $user){
        try {
            Mail::to($user->email)->send(new CompteDesactiveMail($user));
        } catch (\Exception $e) {
            Log::error('MailService::envoyerCompteDesactive - ' . $e->getMessage());
        }
    }

    // ── Projet approuvé
    public function envoyerProjetApprouve(Projet $projet){
        if (!$projet->porteur || !$projet->porteur->email) return;

        try {
            Mail::to($projet->porteur->email)->send(new ProjetApprouveMail($projet));
        } catch (\Exception $e) {
            Log::error('MailService::envoyerProjetApprouve - ' . $e->getMessage());
        }
    }

    // ── Projet validé 
    public function envoyerProjetValide(Projet $projet) {
        if (!$projet->porteur || !$projet->porteur->email) return;

        try {
            Mail::to($projet->porteur->email)->send(new ProjetValideMail($projet));
        } catch (\Exception $e) {
            Log::error('MailService::envoyerProjetValide - ' . $e->getMessage());
        }
    }

    // ── Projet rejeté 
    public function envoyerProjetRejete(Projet $projet, Commentaire $commentaire) {
        if (!$projet->porteur || !$projet->porteur->email) return;

        try {
            // Passage du commentaire au constructeur
            Mail::to($projet->porteur->email)->send(new ProjetRejetMail($projet, $commentaire));
        } catch (\Exception $e) {
            Log::error('MailService::envoyerProjetRejete - ' . $e->getMessage());
        }
    }
}
