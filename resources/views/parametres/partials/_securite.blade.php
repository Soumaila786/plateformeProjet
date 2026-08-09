<x-cards.info titre="Changer le mot de passe" icon="fa-key">
    <form action="{{ route('parametres.securite.update') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label small">Mot de passe actuel</label>
                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small">Nouveau mot de passe</label>
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required minlength="8">
                @error('new_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small">Confirmer le nouveau mot de passe</label>
                <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Mettre à jour</button>
        </div>
    </form>
</x-cards.info>
