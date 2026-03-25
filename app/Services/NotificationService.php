<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Projet;
use App\Models\User;

class NotificationService {

    public static function envoyer($destinataireId, $message, $type = 'info', $projetId = null) {
        Notification::create([
            'message'         => $message,
            'dateEnvoi'       => now(),
            'statut'          => 'non_lu',
            'type'            => $type,
            'destinataire_id' => $destinataireId,
            'projet_id'       => $projetId,
        ]);
    }


    public static function notifierPorteur(Projet $projet, $message, $type = 'info') {
        if ($projet->user_id) {
            self::envoyer($projet->user_id, $message, $type, $projet->id);
        }
    }


    public static function notifierAdmins($message, $type = 'info', $projetId = null) {
        $admins = User::where('role', 'admin')->where('actif', true)->get();
        foreach ($admins as $admin) {
            self::envoyer($admin->id, $message, $type, $projetId);
        }
    }


    public static function notifierApprobateurs($message, $type = 'info', $projetId = null) {
        $approbateurs = User::where('role', 'approbateur')->where('actif', true)->get();
        foreach ($approbateurs as $approbateur) {
            self::envoyer($approbateur->id, $message, $type, $projetId);
        }
    }


    public static function notifierValidateurs($message, $type = 'info', $projetId = null) {
        $validateurs = User::where('role', 'validateur')->where('actif', true)->get();
        foreach ($validateurs as $validateur) {
            self::envoyer($validateur->id, $message, $type, $projetId);
        }
    }
}
