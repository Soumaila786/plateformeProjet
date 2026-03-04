@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="users-container">

    <!-- En-tête -->
    <div class="users-header">

        <div>
            <h1 class="users-title">Utilisateurs</h1>
            <p class="users-subtitle">{{ $totalUsers ?? 0 }} utilisateurs enregistrés</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn-add">
            <i class="fas fa-plus"></i>
            <span>Nouveau utilisateur</span>
        </a>

    </div>

    <!-- Barre de recherche -->
    <div class="search-container">
        <i class="fas fa-search search-icon"></i>
        <input type="text"
                class="search-input"
                placeholder="Rechercher..."
                id="searchInput"
                onkeyup="filterUsers()">
    </div>

    <!-- Grille des utilisateurs -->
    <div class="users-grid" id="usersGrid">

        @forelse($users as $user)

        <div class="user-card" data-name="{{ strtolower($user->nomComplet) }}" data-email="{{ strtolower($user->email) }}">
            
            <!-- En-tête de la carte avec avatar -->
            <div class="user-card-header">
                <!-- Avatar avec les initiales -->
                <div class="user-avatar">
                    {{ substr($user->nomComplet, 0, 1) }}{{ substr(strstr($user->nomComplet, ' ', false), 1, 1) ?? '' }}
                </div>
                <div class="user-info">
                    <p class="user-name">{{ $user->nomComplet }}</p>
                    <p class="user-email">{{ $user->email }}</p>
                </div>
                <span class="user-status {{ $user->actif ? 'status-active' : 'status-inactive' }}"></span>

            </div>

            <!-- Détails de l'utilisateur -->
            <div class="user-details">
                <div class="detail-row">
                    <span class="detail-label">Rôle</span>
                    <!-- Label du rôle -->
                    <span class="detail-value">
                        @switch($user->role)
                            @case('admin') Administrateur @break
                            @case('approbateur') Approbateur @break
                            @case('validateur') Validateur @break
                            @case('porteur') Porteur de projet @break
                            @default {{ $user->role }}
                        @endswitch
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Matricule</span>
                    <span class="detail-value matricule">{{ $user->matricule ?? 'Non défini' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Fonction</span>
                    <span class="detail-value">{{ $user->fonction ?? 'Non défini' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact</span>
                    <span class="detail-value">{{ $user->contact ?? 'Non défini' }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="user-actions">

                <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit-btn" title="Modifier">
                    <i class="fas fa-edit"></i>
                </a>

                <button class="action-btn delete-btn" title="Supprimer" 
                        onclick="confirmDelete({{ $user->id }}, '{{ $user->nomComplet }}')">
                    <i class="fas fa-trash"></i>
                </button>

                <button class="action-btn more-btn" title="Plus d'options">
                    <i class="fas fa-ellipsis-v"></i>
                </button>

            </div>
        </div>

        @empty
        <div class="empty-state">
            <i class="fas fa-users fa-3x"></i>
            <p>Aucun utilisateur trouvé</p>
        </div>
        
        @endforelse
    </div>
</div>

<!-- Formulaire de suppression caché -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Scripts -->
@push('scripts')
<script>
    // Filtre de recherche
    function filterUsers() {
        const searchInput = document.getElementById('searchInput');
        const filter = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll('.user-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const email = card.getAttribute('data-email');
            
            if (name.includes(filter) || email.includes(filter)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Confirmation de suppression
    function confirmDelete(userId, userName) {
        if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" ?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/users/${userId}`;
            form.submit();
        }
    }
</script>
@endpush
@endsection