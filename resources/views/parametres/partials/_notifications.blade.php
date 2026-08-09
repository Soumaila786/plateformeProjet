{{--
    NOTE IMPORTANTE : ParametreController::notificationsUpdate() ne valide et
    n'enregistre actuellement AUCUN champ (il redirige juste avec un message
    succès). Pour que cet onglet soit réellement fonctionnel, il faut :
    1. Ajouter une colonne (ex: notif_email_actif, boolean, défaut true) sur `users`
    2. Traiter $request->boolean('notif_email_actif') dans notificationsUpdate()
    Tant que ce n'est pas fait, ce formulaire s'affiche mais ne change rien
    en base — je ne voulais pas laisser un onglet vide vu que "tout doit être
    réel", donc dis-moi si tu préfères que je retire cet onglet en attendant
    plutôt que de le laisser non branché.
--}}
@php $u = auth()->user(); @endphp
<x-cards.info titre="Préférences de notification" icon="fa-bell">
    <form action="{{ route('parametres.notifications.update') }}" method="POST">
        @csrf

        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="notif_email_actif" id="notifEmail"
                   value="1" {{ old('notif_email_actif', $u->notif_email_actif ?? true) ? 'checked' : '' }}>
            <label class="form-check-label small" for="notifEmail">
                Recevoir les notifications importantes par email (soumission, approbation, rejet...)
            </label>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
        </div>
    </form>
</x-cards.info>
