<form method="GET" action="{{ url()->current() }}" class="an-filters mb-4">
    <div>
        <label for="date_debut" class="form-label small">Du</label>
        <input type="date" id="date_debut" name="date_debut" value="{{ request('date_debut') }}" class="form-control form-control-sm">
    </div>
    <div>
        <label for="date_fin" class="form-label small">Au</label>
        <input type="date" id="date_fin" name="date_fin" value="{{ request('date_fin') }}" class="form-control form-control-sm">
    </div>
    <div>
        <label for="type_projet_id" class="form-label small">Type de projet</label>
        <select id="type_projet_id" name="type_projet_id" class="form-select form-select-sm">
            <option value="">Tous les types</option>
            @foreach($typesProjets as $type)
                <option value="{{ $type->id }}" {{ (string) request('type_projet_id') === (string) $type->id ? 'selected' : '' }}>{{ $type->nom }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="secteur_id" class="form-label small">Secteur</label>
        <select id="secteur_id" name="secteur_id" class="form-select form-select-sm">
            <option value="">Tous les secteurs</option>
            @foreach($secteursFiltres as $secteur)
                <option value="{{ $secteur->id }}" {{ (string) request('secteur_id') === (string) $secteur->id ? 'selected' : '' }}>{{ $secteur->nomSecteur }}</option>
            @endforeach
        </select>
    </div>
    @if(auth()->user()->role !== 'porteur')
        <div>
            <label for="user_id" class="form-label small">Porteur</label>
            <select id="user_id" name="user_id" class="form-select form-select-sm">
                <option value="">Tous les porteurs</option>
                @foreach($porteursFiltres as $porteur)
                    <option value="{{ $porteur->id }}" {{ (string) request('user_id') === (string) $porteur->id ? 'selected' : '' }}>{{ $porteur->nomComplet }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Filtrer</button>
    <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-rotate-left me-1"></i>Réinitialiser</a>
</form>
