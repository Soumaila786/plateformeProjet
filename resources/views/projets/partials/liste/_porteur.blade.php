@section('title', 'Mes projets')

@section('breadcrumb')
    <a href="{{ route('porteur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Mes projets</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Mes projets</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>

        @can('projets.creer')
            <button type="button" class="btn btn-primary btn-sm"
                    data-modal-new="modalProjetForm"
                    data-modal-action="{{ route('porteur.projets.store') }}"
                    data-modal-titre-creation="Nouveau projet">
                <i class="fas fa-plus"></i> Nouveau projet
            </button>
        @endcan
    </div>

    @include('projets.partials._liste_filtres', [
        'statutOptions' => [
            'brouillon' => 'Brouillon', 'soumis' => 'Soumis', 'en_examen' => 'En examen',
            'approuve' => 'Approuvé', 'valide' => 'Validé', 'rejete' => 'Rejeté',
        ],
    ])
@endsection

@section('content')
    @include('projets.partials._liste_lignes', ['routeShow' => 'porteur.projets.show'])

    @can('projets.creer')
        @include('modals.projet-form')
    @endcan
@endsection
