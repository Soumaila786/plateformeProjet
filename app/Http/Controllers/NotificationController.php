<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller {

    // Liste des notifications de l'utilisateur connecté
    public function index() {

        try{

            $notifications = Notification::where('destinataire_id', Auth::id())
                ->with('projet')
                ->orderBy('dateEnvoi', 'desc')
                ->paginate(4);

            // Marquer toutes comme lues à l'ouverture
            Notification::where('destinataire_id', Auth::id())
                ->where('statut', 'non_lu')
                ->update(['statut' => 'lu']);

            $role = Auth::user()->role;

            return view('notifications.index', compact('notifications', 'role'));

        }catch(\Exception $e){
            Log::error("Erreur lors de l'affichage des notifications", [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            // NOTE : avant cette correction, le catch tentait de charger une vue nommée
            // littéralement "Erreur de recupération " (qui n'existe pas) → plantage
            // en cascade au lieu d'un simple message d'erreur.
            return back()->with('error', 'Une erreur est survenue lors du chargement des notifications.');
        }
    }

    // Marquer une seule comme lue
    public function marquerLu(Notification $notification) {

        if ($notification->destinataire_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['statut' => 'lu']);
        return back();
    }

    // Marquer toutes comme lues (AJAX ou redirect)
    public function marquerToutesLues() {

        try{

            Notification::where('destinataire_id', Auth::id())
                ->where('statut', 'non_lu')
                ->update(['statut' => 'lu']);

            return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');

        }catch (\Exception $e){
            Log::error('Erreur lors du marquages vues de toutes les notifications',[
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }

    // Supprimer une notification
    public function destroy(Notification $notification) {

        try{

            if ($notification->destinataire_id !== Auth::id()) {
                abort(403);
            }
            $notification->delete();
            return back()->with('success', 'Notification supprimée.');

        }catch (\Exception $e){
            Log::error("Erreur lors de la suppression d'une notification" ,[
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }

    // Supprimer toutes les notifications lues
    public function destroyLues() {

        try{

            Notification::where('destinataire_id', Auth::id())
                ->where('statut', 'lu')
                ->delete();

            return back()->with('success', 'Notifications lues supprimées.');

        }catch (\Exception $e){
            Log::error('Erreur lors de la suppression de toutes les notifications lues',[
                'message' => $e->getMessage()
            ]);
            return back()->with('error', 'Une erreur est survenue');
        }
    }

    // Nombre de notifications non lues (pour badge sidebar - appel AJAX optionnel)
    public function count() {

        try{

            $count = Notification::where('destinataire_id', Auth::id())
                ->where('statut', 'non_lu')
                ->count();

            return response()->json(['count' => $count]);

        }catch (\Exception $e){
            Log::error('Erreur lors de la récuperation du nombre de notifications',[
                'message' => $e->getMessage()
            ]);
            // NOTE : cette route est appelée en AJAX (badge sidebar) — il faut donc
            // toujours répondre en JSON, même en cas d'erreur, jamais un back()->with().
            return response()->json(['count' => 0], 500);
        }
    }
}
