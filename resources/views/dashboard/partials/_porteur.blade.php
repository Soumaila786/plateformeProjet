@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

<div class="dash-stats-grid">
    {{-- <x-cards.stat label="Mes projets" :valeur="$total" icon="fa-folder" href="{{ route('porteur.projets.index') }}" /> --}}
    <x-cards.stat label="Brouillons" :valeur="$brouillon" icon="fa-pen" couleur="var(--status-brouillon)" />
    <x-cards.stat label="Soumis" :valeur="$soumis" icon="fa-paper-plane" couleur="var(--status-soumis)" />
    <x-cards.stat label="En examen" :valeur="$enExamen" icon="fa-magnifying-glass" couleur="var(--status-en-examen)" />
    <x-cards.stat label="Approuvés" :valeur="$approuve" icon="fa-check" couleur="var(--status-approuve)" />
    <x-cards.stat label="Validés" :valeur="$valide" icon="fa-check-double" couleur="var(--status-valide)" />
    <x-cards.stat label="Rejetés" :valeur="$rejete" icon="fa-xmark" couleur="var(--status-rejete)" />
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Mes projets récents</h6>
            @include('dashboard.partials._projets_recents', ['projetsRecents' => $projetsRecents, 'routeShow' => 'porteur.projets.show'])
        </div>
    </div>
    <div class="col-lg-5">
        <div class="dash-card mb-3">
            <h6 class="fw-bold mb-3">Finances</h6>
            <div class="d-flex justify-content-between py-1 small">
                <span class="text-muted">Budget total demandé</span>
                <strong class="font-monospace">{{ number_format($budgetTotal, 0, ',', ' ') }} FCFA</strong>
            </div>
            <div class="d-flex justify-content-between py-1 small">
                <span class="text-muted">Montant demandé</span>
                <strong class="font-monospace">{{ number_format($montantDemande, 0, ',', ' ') }} FCFA</strong>
            </div>
        </div>
        <div class="dash-card">
            <h6 class="fw-bold mb-3">Notifications récentes</h6>
            @forelse ($notifications as $notif)
                <div class="py-2 {{ !$loop->last ? 'border-bottom' : '' }} small">{{ $notif->message }}</div>
            @empty
                <p class="text-muted small mb-0 py-3 text-center">Aucune notification.</p>
            @endforelse
        </div>
    </div>
</div>
