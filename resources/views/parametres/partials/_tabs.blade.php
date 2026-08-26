@php
    $ongletsPerso = [
        'profil'        => ['label' => 'Profil', 'subtitle' => 'Vos informations personnelles', 'icon' => 'fa-user', 'route' => 'parametres.profil', 'params' => []],
        'notifications' => ['label' => 'Notifications', 'subtitle' => 'Vos préférences d’alerte', 'icon' => 'fa-bell', 'route' => 'parametres.notifications', 'params' => []],
        'securite'      => ['label' => 'Sécurité', 'subtitle' => 'Mot de passe et protection', 'icon' => 'fa-shield-halved', 'route' => 'parametres.securite', 'params' => []],
    ];

    // FIX : ce sont les vrais NOMS DE ROUTE (admin.users.index, etc.), pas les
    // noms de vue (users.index) — les deux sont différents, seul le view()
    // appelé par les controllers a été renommé, pas les routes elles-mêmes.
    $ongletsAdmin = [
        'utilisateurs' => ['label' => 'Utilisateurs', 'subtitle' => 'Comptes et accès', 'icon' => 'fa-users', 'route' => 'admin.users.index'],
        'secteurs' => ['label' => 'Secteurs d’activité', 'subtitle' => 'Domaines principaux des projets', 'icon' => 'fa-building', 'route' => 'admin.secteurs.index'],
        'types' => ['label' => 'Types de projets', 'subtitle' => 'Catégories de projets CIFEU', 'icon' => 'fa-layer-group', 'route' => 'admin.types-projets.index'],
        'sous-domaines' => ['label' => 'Sous-domaines', 'subtitle' => 'Précision par secteur d’activité', 'icon' => 'fa-diagram-project', 'route' => 'admin.sous-domaines.index'],
        'configuration' => ['label' => 'Configuration système', 'subtitle' => 'Logo, identité et règles de l’application', 'icon' => 'fa-cogs', 'route' => 'admin.configuration.index'],
        'motifs' => ['label' => 'Motifs de rejet', 'subtitle' => 'Motifs proposés lors des contrôles', 'icon' => 'fa-list-check', 'route' => 'admin.motifs.index'],
        'journal' => ['label' => 'Journal', 'subtitle' => 'Traçabilité des actions système', 'icon' => 'fa-clipboard-list', 'route' => 'admin.logs.index'],
    ];

    // Détecte l'onglet actif selon la route/le paramètre courant
    $ongletActifPerso = request()->routeIs('parametres.profil') ? 'profil'
        : (request()->routeIs('parametres.notifications') ? 'notifications'
        : (request()->routeIs('parametres.securite') ? 'securite' : null));
@endphp

<div class="param-tabs">

    @foreach ($ongletsPerso as $cle => $onglet)
        <a href="{{ route($onglet['route'], $onglet['params']) }}"
            class="param-tab {{ $ongletActifPerso === $cle ? 'active' : '' }}">
            <span class="param-tab-icon"><i class="fas {{ $onglet['icon'] }}"></i></span>
            <span><strong>{{ $onglet['label'] }}</strong><small>{{ $onglet['subtitle'] }}</small></span>
        </a>
    @endforeach
    @can('utilisateurs.gerer')
        <span class="param-tabs-sep"></span>
        @foreach ($ongletsAdmin as $onglet)
            @continue(!Route::has($onglet['route']))
            <a href="{{ route($onglet['route']) }}"
                class="param-tab {{ request()->routeIs($onglet['route']) ? 'active' : '' }}">
                <span class="param-tab-icon"><i class="fas {{ $onglet['icon'] }}"></i></span>
                <span><strong>{{ $onglet['label'] }}</strong><small>{{ $onglet['subtitle'] }}</small></span>
            </a>
        @endforeach
    @endcan
</div>
