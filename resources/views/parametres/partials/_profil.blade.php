@php $u = auth()->user(); @endphp

<x-cards.info titre="Photo de profil" icon="fa-camera" class="mb-3">
    <form action="{{ route('parametres.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="param-avatar-upload">
            <x-avatars.avatar :user="$u" :size="64" />
            <div>
                <input type="file" name="photo" accept="image/*" class="form-control form-control-sm @error('photo') is-invalid @enderror">
                @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="text-muted small mt-1">JPG ou PNG, 2 Mo max.</div>
            </div>
            <button type="submit" class="btn btn-outline-secondary btn-sm ms-auto">Changer la photo</button>
        </div>
    </form>
</x-cards.info>

<x-cards.info titre="Informations personnelles" icon="fa-id-card">
    <form action="{{ route('parametres.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small">Nom complet</label>
                <input type="text" name="nomComplet" value="{{ old('nomComplet', $u->nomComplet) }}"
                    class="form-control @error('nomComplet') is-invalid @enderror" required>
                @error('nomComplet')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small">Email</label>
                <input type="email" name="email" value="{{ old('email', $u->email) }}"
                    class="form-control @error('email') is-invalid @enderror" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small">Contact</label>
                <input type="text" name="contact" value="{{ old('contact', $u->contact) }}"
                    class="form-control @error('contact') is-invalid @enderror" maxlength="50">
                @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label small">Rôle</label>
                <input type="text" value="{{ ucfirst($u->role) }}" class="form-control" disabled>
            </div>

            @if ($u->role === 'porteur')
                <div class="col-md-12">
                    <label class="form-label small">Spécialité</label>
                    <input type="text" name="specialite" value="{{ old('specialite', $u->specialite) }}" class="form-control" maxlength="255">
                </div>
            @elseif ($u->role === 'approbateur')
                <div class="col-md-6">
                    <label class="form-label small">Service</label>
                    <input type="text" name="service" value="{{ old('service', $u->service) }}" class="form-control" maxlength="255">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Poste</label>
                    <input type="text" name="poste" value="{{ old('poste', $u->poste) }}" class="form-control" maxlength="255">
                </div>
            @elseif ($u->role === 'planificateur')
                <div class="col-md-12">
                    <label class="form-label small">Service</label>
                    <input type="text" name="service" value="{{ old('service', $u->service) }}" class="form-control" maxlength="255">
                </div>
            @elseif ($u->role === 'validateur')
                <div class="col-md-6">
                    <label class="form-label small">Début de mandat</label>
                    <input type="date" name="dateDebutMandat" value="{{ old('dateDebutMandat', optional($u->dateDebutMandat)->format('Y-m-d')) }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label small">Fin de mandat</label>
                    <input type="date" name="dateFinMandat" value="{{ old('dateFinMandat', optional($u->dateFinMandat)->format('Y-m-d')) }}" class="form-control">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-check me-1"></i>Enregistrer</button>
        </div>
    </form>
</x-cards.info>
