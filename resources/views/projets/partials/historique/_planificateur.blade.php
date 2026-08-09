@section('title', 'Projets planifiés')

@section('breadcrumb')
    <a href="{{ route('planificateur.dashboard') }}">Tableau de bord</a>
    <span>/</span>
    <span>Projets planifiés</span>
@endsection

@section('page-header')
    <div class="page-header-top">
        <div>
            <h1 class="page-header-title">Projets déjà planifiés</h1>
            <p class="page-header-sub">{{ $projets->total() }} projet{{ $projets->total() > 1 ? 's' : '' }} au total</p>
        </div>
        <a href="{{ route('planificateur.projets.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-inbox"></i> Demandes à planifier
        </a>
    </div>

    @include('projets.partials._liste_filtres')
@endsection

@section('content')
    @include('projets.partials._liste_lignes', ['routeShow' => 'planificateur.projets.show'])
@endsection
