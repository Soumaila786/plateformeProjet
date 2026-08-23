@php
    $ongletsPerso = [
        'profil'        => ['label' => 'Profil',        'icon' => 'fa-user',            'route' => 'parametres.index', 'params' => ['onglet' => 'profil']],
        'notifications' => ['label' => 'Notifications',  'icon' => 'fa-bell',            'route' => 'parametres.index', 'params' => ['onglet' => 'notifications']],
        'securite'      => ['label' => 'Sécurité',       'icon' => 'fa-shield-halved',   'route' => 'parametres.index', 'params' => ['onglet' => 'securite']],
    ];

    // FIX : ce sont les vrais NOMS DE ROUTE (admin.users.index, etc.), pas les
    // noms de vue (users.index) — les deux sont différents, seul le view()
    // appelé par les controllers a été renommé, pas les routes elles-mêmes.
    $ongletsAdmin = [
        'utilisateurs' => ['label' => 'Utilisateurs',    'icon' => 'fa-users',           'route' => 'admin.users.index'],
        'secteurs'     => ['label' => 'Secteurs',        'icon' => 'fa-building',        'route' => 'admin.secteurs.index'],
        'motifs'       => ['label' => 'Motifs de rejet', 'icon' => 'fa-list-check',      'route' => 'admin.motifs.index'],
        'journal'      => ['label' => 'Journal',         'icon' => 'fa-clipboard-list',  'route' => 'admin.logs.index'],
    ];

    // Détecte l'onglet actif selon la route/le paramètre courant
    $ongletActifPerso = request()->routeIs('parametres.index') ? request('onglet', 'profil') : null;
@endphp

<div class="param-tabs">

    @foreach ($ongletsPerso as $cle => $onglet)
        <a href="{{ route($onglet['route'], $onglet['params']) }}"
            class="param-tab {{ $ongletActifPerso === $cle ? 'active' : '' }}">
            <i class="fas {{ $onglet['icon'] }} me-1"></i> {{ $onglet['label'] }}
        </a>
    @endforeach
    @can('utilisateurs.gerer')
        <span class="param-tabs-sep"></span>
        @foreach ($ongletsAdmin as $onglet)
            @continue(!Route::has($onglet['route']))
            <a href="{{ route($onglet['route']) }}"
                class="param-tab {{ request()->routeIs($onglet['route']) ? 'active' : '' }}">
                <i class="fas {{ $onglet['icon'] }} me-1"></i> {{ $onglet['label'] }}
            </a>
        @endforeach
    @endcan
</div>
