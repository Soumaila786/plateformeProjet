@extends('layouts.app')

@section('title', 'Utilisateurs')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="ulist-header">
        <div>
            <h1 class="ulist-title">Utilisateurs</h1>
            <p class="ulist-subtitle">{{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="ulist-btn-add">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>

    {{-- Filtres --}}
    <div class="ulist-filters">
        <div class="ulist-search-wrapper">
            <i class="fas fa-search ulist-search-icon"></i>
            <input type="text" id="searchInput" class="ulist-search-input"
                    placeholder="Rechercher par nom, email..." value="{{ request('search') }}">
        </div>
        <div class="ulist-role-filters">
            @foreach([
                '' => 'Tous',
                'admin' => 'Admin',
                'porteur' => 'Porteur',
                'approbateur' => 'Approbateur',
                'planificateur' => 'Planificateur',
                'validateur' => 'Validateur'
            ] as $val => $label)
            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => $val])) }}"
                class="ulist-role-pill {{ request('role', '') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Liste --}}
    <div class="ulist-table">

        {{-- Entête --}}
        <div class="ulist-thead">
            <div class="ulist-th ulist-col-user">Utilisateur</div>
            <div class="ulist-th ulist-col-info">Informations</div>
            <div class="ulist-th ulist-col-role">Rôle</div>
            <div class="ulist-th ulist-col-statut">Statut</div>
            <div class="ulist-th ulist-col-actions">Actions</div>
        </div>

        {{-- Lignes --}}
        @forelse($users as $user)
        <div class="ulist-row">

            {{-- Avatar + nom --}}
            <div class="ulist-col-user">
                <div class="ulist-avatar ulist-avatar-{{ $user->role }}">
                    {{ strtoupper(substr($user->nomComplet, 0, 1)) }}
                </div>
                <div class="ulist-user-name-block">
                    <a href="{{ route('admin.users.show', $user) }}" class="ulist-user-name">
                        {{ $user->nomComplet }}
                    </a>
                    @if($user->organisation)
                    <span class="ulist-user-org"><i class="fas fa-building"></i> {{ $user->organisation }}</span>
                    @endif
                </div>
            </div>

            {{-- Infos --}}
            <div class="ulist-col-info">
                <span class="ulist-info-item"><i class="fas fa-envelope"></i> {{ $user->email }}</span>
                @if($user->contact)
                <span class="ulist-info-item"><i class="fas fa-phone"></i> {{ $user->contact }}</span>
                @endif
                @if($user->fonction)
                <span class="ulist-info-item"><i class="fas fa-briefcase"></i> {{ $user->fonction }}</span>
                @endif
            </div>

            {{-- Rôle --}}
            <div class="ulist-col-role">
                <span class="ulist-role-badge ulist-role-{{ $user->role }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>

            {{-- Statut --}}
            <div class="ulist-col-statut">
                @if($user->actif)
                    <span class="ulist-status ulist-status-actif">
                        <span class="ulist-status-dot"></span> Actif
                    </span>
                @else
                    <span class="ulist-status ulist-status-inactif">
                        <span class="ulist-status-dot"></span> Inactif
                    </span>
                @endif
            </div>

            {{-- Actions --}}
            <div class="ulist-col-actions">
                <a href="{{ route('admin.users.show', $user) }}" class="ulist-action-btn" title="Voir">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="ulist-action-btn" title="Modifier">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                            class="ulist-action-btn {{ $user->actif ? 'ulist-action-warn' : 'ulist-action-success' }}"
                            title="{{ $user->actif ? 'Désactiver' : 'Activer' }}">
                        <i class="fas {{ $user->actif ? 'fa-user-times' : 'fa-user-check' }}"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                        onsubmit="return confirm('Supprimer cet utilisateur ?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="ulist-action-btn ulist-action-danger" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>

        </div>
        @empty
        <div class="ulist-empty">
            <i class="fas fa-users-slash"></i>
            <p>Aucun utilisateur trouvé.</p>
        </div>
        @endforelse

    </div>

    @if($users->hasPages())
    <div class="projets-pagination">{{ $users->withQueryString()->links() }}</div>
    @endif

</div>

@push('scripts')
<script>
let timer;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    const val = this.value;
    timer = setTimeout(() => {
        const url = new URL(window.location.href);
        url.searchParams.set('search', val);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }, 400);
});
</script>
@endpush

@endsection
