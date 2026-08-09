<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label small">Nom complet</label>
        <input type="text" name="nomComplet" class="form-control @error('nomComplet') is-invalid @enderror" required maxlength="255">
        @error('nomComplet')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label small">Rôle</label>
        <select name="role" id="userFormRole" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">Sélectionner...</option>
            <option value="admin">Admin</option>
            <option value="porteur">Porteur</option>
            <option value="approbateur">Approbateur</option>
            <option value="validateur">Validateur</option>
            <option value="planificateur">Planificateur</option>
        </select>
        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small">Contact</label>
        <input type="text" name="contact" class="form-control @error('contact') is-invalid @enderror" maxlength="20">
        @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label small">Fonction</label>
        <input type="text" name="fonction" class="form-control @error('fonction') is-invalid @enderror" maxlength="100">
        @error('fonction')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label small">Matricule</label>
        <input type="text" name="matricule" class="form-control @error('matricule') is-invalid @enderror" maxlength="100">
        @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-12">
        <label class="form-label small">Organisation</label>
        <input type="text" name="organisation" class="form-control @error('organisation') is-invalid @enderror" maxlength="255">
        @error('organisation')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- ── Champs conditionnels selon le rôle sélectionné (voir public/js/users-form.js) ── --}}
    <div class="col-md-12 champ-role" data-role-visible="porteur">
        <label class="form-label small">Spécialité</label>
        <input type="text" name="specialite" class="form-control" maxlength="255">
    </div>
    <div class="col-md-6 champ-role" data-role-visible="planificateur,approbateur">
        <label class="form-label small">Service</label>
        <input type="text" name="service" class="form-control" maxlength="255">
    </div>
    <div class="col-md-6 champ-role" data-role-visible="approbateur">
        <label class="form-label small">Poste</label>
        <input type="text" name="poste" class="form-control" maxlength="255">
    </div>
    <div class="col-md-6 champ-role" data-role-visible="validateur">
        <label class="form-label small">Début de mandat</label>
        <input type="date" name="dateDebutMandat" class="form-control">
    </div>
    <div class="col-md-6 champ-role" data-role-visible="validateur">
        <label class="form-label small">Fin de mandat</label>
        <input type="date" name="dateFinMandat" class="form-control">
    </div>
</div>

<p class="text-muted small mt-3 mb-0" data-hide-on-edit>
    <i class="fas fa-circle-info"></i> Un mot de passe temporaire sera généré et envoyé par email à l'utilisateur.
</p>
