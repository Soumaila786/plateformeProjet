@php
    $roleColors = [
        'admin' => '#6366f1', 'porteur' => '#0d9488', 'approbateur' => '#f97316',
        'validateur' => '#22c55e', 'planificateur' => '#9333ea',
    ];
    $roleLabels = [
        'admin' => 'Admin', 'porteur' => 'Porteur', 'approbateur' => 'Approbateur',
        'validateur' => 'Validateur', 'planificateur' => 'Planificateur',
    ];
@endphp

@forelse ($users as $u)
    @php
        $couleurRole = $roleColors[$u->role] ?? '#9ca3af';
        $champsModifierUser = [
            'nomComplet' => $u->nomComplet, 'email' => $u->email, 'role' => $u->role,
            'fonction' => $u->fonction, 'matricule' => $u->matricule, 'contact' => $u->contact,
            'organisation' => $u->organisation, 'specialite' => $u->specialite,
            'service' => $u->service, 'poste' => $u->poste,
            'dateDebutMandat' => optional($u->dateDebutMandat)->format('Y-m-d'),
            'dateFinMandat' => optional($u->dateFinMandat)->format('Y-m-d'),
        ];
    @endphp
    <div class="lp-row">
        <x-avatars.avatar :user="$u" :size="42" />

        <div class="lp-info">
            <div class="lp-top">
                <span class="lp-titre">{{ $u->nomComplet }}</span>
            </div>
            <p class="lp-meta">
                <span><i class="fas fa-envelope"></i>{{ $u->email }}</span>
                @if ($u->contact)
                    <span><i class="fas fa-phone"></i>{{ $u->contact }}</span>
                @endif
                @if ($u->fonction || $u->organisation)
                    <span><i class="fas fa-briefcase"></i>{{ $u->fonction ?? $u->organisation }}</span>
                @endif
            </p>
        </div>

        <div class="lp-badges">
            <span class="lp-badge" style="background: color-mix(in srgb, {{ $couleurRole }} 16%, white); color: {{ $couleurRole }};">
                <span class="lp-dot" style="background:{{ $couleurRole }};"></span>{{ $roleLabels[$u->role] ?? $u->role }}
            </span>
            <span class="badge {{ $u->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                {{ $u->actif ? 'Actif' : 'Inactif' }}
            </span>

            <button type="button" class="lp-btn" title="Voir" onclick="openModal('modalUserView{{ $u->id }}')">
                <i class="fas fa-eye"></i>
            </button>

            @can('utilisateurs.gerer')
                <button type="button" class="lp-btn" title="Modifier"
                        data-modal-edit="modalUserForm"
                        data-modal-action="{{ route('admin.users.update', $u) }}"
                        data-modal-titre-edition="Modifier l'utilisateur"
                        data-modal-fields="{{ json_encode($champsModifierUser) }}">
                    <i class="fas fa-pen"></i>
                </button>

                <form method="POST" action="{{ route('admin.users.toggle-status', $u) }}" class="d-inline"
                      onsubmit="return confirm('{{ $u->actif ? 'Désactiver' : 'Activer' }} ce compte ?')">
                    @csrf
                    <button type="submit" class="lp-btn {{ $u->actif ? '' : 'lp-btn-green' }}" title="{{ $u->actif ? 'Désactiver' : 'Activer' }}">
                        <i class="fas {{ $u->actif ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="d-inline"
                      onsubmit="return confirm('Supprimer définitivement cet utilisateur ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="lp-btn lp-btn-red" title="Supprimer"><i class="fas fa-trash"></i></button>
                </form>
            @endcan
        </div>
    </div>

    <div id="modalUserView{{ $u->id }}" class="lp-modal-overlay">
        <div class="lp-modal-box">
            <div class="lp-modal-head">
                <h3 class="lp-modal-title"><i class="fas fa-id-card"></i> {{ $u->nomComplet }}</h3>
                <button onclick="closeModal('modalUserView{{ $u->id }}')" class="lp-modal-close"><i class="fas fa-times"></i></button>
            </div>
            <div class="lp-modal-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <x-avatars.avatar :user="$u" :size="56" />
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary-subtle text-primary">{{ $roleLabels[$u->role] ?? $u->role }}</span>
                        <span class="badge {{ $u->actif ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                            {{ $u->actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-muted small">Email</div>
                        <div class="fw-semibold">{{ $u->email }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Contact</div>
                        <div class="fw-semibold">{{ $u->contact ?? '—' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Fonction</div>
                        <div class="fw-semibold">{{ $u->fonction ?? '—' }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Matricule</div>
                        <div class="fw-semibold">{{ $u->matricule ?? '—' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Organisation</div>
                        <div class="fw-semibold">{{ $u->organisation ?? '—' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">{{ $roleLabels[$u->role] ?? ucfirst($u->role) }} — détail</div>
                        <div class="fw-semibold">{{ $u->detailsRole ?? '—' }}</div>
                    </div>
                </div>
            </div>
            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalUserView{{ $u->id }}')" class="btn btn-light btn-sm">Fermer</button>
            </div>
        </div>
    </div>
@empty
    <div class="lp-empty">
        <i class="fas fa-user-slash"></i>
        <p class="mb-0">Aucun utilisateur trouvé.</p>
    </div>
@endforelse

<div class="mt-3">{{ $users->withQueryString()->links() }}</div>

@push('scripts')
    <script src="{{ asset('js/filtres-liste.js') }}"></script>
    <script src="{{ asset('js/modals-crud.js') }}"></script>
@endpush
