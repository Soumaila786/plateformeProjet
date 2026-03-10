@extends('layouts.app')

@section('title', 'Utilisateurs')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

<div class="projets-page">

    <div class="projets-header">
        <div>
            <h1 class="projets-title">Utilisateurs</h1>
            <p class="projets-subtitle">{{ $users->total() }} utilisateur{{ $users->total() > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>

    {{-- Filtres --}}
    <div class="projets-filters">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input"
                   placeholder="Nom, email..." value="{{ request('search') }}">
        </div>
        <div class="status-filters">
            @foreach(['' => 'Tous', 'admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur', 'validateur' => 'Validateur'] as $val => $label)
            <a href="{{ route('admin.users.index', array_merge(request()->query(), ['role' => $val])) }}"
               class="status-filter {{ request('role', '') === $val ? 'active' : '' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Cards Grid --}}
    <div class="cards-grid">
        @forelse($users as $user)
        <div class="user-card">
            <div class="user-card-top">
                <div class="user-avatar role-avatar-{{ $user->role }}">
                    {{ strtoupper(substr($user->nomComplet, 0, 1)) }}
                </div>
                <div class="user-card-actions">
                    @if($user->actif)
                        <span class="status-badge status-green" style="font-size:.68rem;">Actif</span>
                    @else
                        <span class="status-badge status-red" style="font-size:.68rem;">Inactif</span>
                    @endif
                    <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            <h3 class="user-card-nom">
                <a href="{{ route('admin.users.show', $user) }}">{{ $user->nomComplet }}</a>
            </h3>
            <p class="user-card-email">{{ $user->email }}</p>
            @if($user->organisation)
            <p class="user-card-org"><i class="fas fa-building"></i> {{ $user->organisation }}</p>
            @endif

            <div class="user-card-footer">
                <a href="{{ route('admin.users.show', $user) }}" class="btn-icon" title="Voir">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon" title="Modifier">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display:inline;">
                    @csrf
                    <button type="submit"
                            class="btn-icon {{ $user->actif ? 'btn-icon-warning' : 'btn-icon-success' }}"
                            title="{{ $user->actif ? 'Désactiver' : 'Activer' }}">
                        <i class="fas {{ $user->actif ? 'fa-user-times' : 'fa-user-check' }}"></i>
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('Supprimer cet utilisateur ?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon btn-icon-danger" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="cards-empty" style="grid-column:1/-1;">
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
