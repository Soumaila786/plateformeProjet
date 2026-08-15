@auth
@php
    $role = Auth::user()->role;
    $notifCount = \App\Models\Notification::where('destinataire_id', Auth::id())
        ->where('statut', 'non_lu')->count();

    $estActif = function (string $route) {
        if (request()->routeIs($route)) {
            return true;
        }
        if (\Illuminate\Support\Str::endsWith($route, '.index')) {
            $prefixe = \Illuminate\Support\Str::beforeLast($route, '.index');
            return request()->routeIs($prefixe . '.show');
        }
        return false;
    };

    $menusParRole = [
        'admin' => [
            ['label' => 'Tableau Analytique', 'icon' => 'fa-chart-pie',        'route' => 'admin.analytique'],
            ['label' => 'Projets',             'icon' => 'fa-project-diagram', 'route' => 'admin.projets.index',      'permission' => 'projets.voir'],
            ['label' => 'Configuration système','icon' => 'fa-cogs',           'route' => 'admin.configuration.index','permission' => 'configurations.gerer'],
        ],
        'porteur' => [
            ['label' => 'Mes projets',    'icon' => 'fa-folder-open',  'route' => 'porteur.projets.index'],
            ['label' => 'Nouveau projet', 'icon' => 'fa-plus-circle',  'route' => 'porteur.projets.create', 'permission' => 'projets.creer'],
        ],
        'approbateur' => [
            ['label' => 'Tableau Analytique', 'icon' => 'fa-chart-pie',   'route' => 'approbateur.analytique'],
            ['label' => 'À approuver',        'icon' => 'fa-tasks',       'route' => 'approbateur.projets.index'],
            ['label' => 'Mes projets',        'icon' => 'fa-folder-open','route' => 'approbateur.projets.mes_projets'],
        ],
        'validateur' => [
            ['label' => 'Tableau Analytique',    'icon' => 'fa-chart-pie',    'route' => 'validateur.analytique'],
            ['label' => 'À valider',             'icon' => 'fa-check-double', 'route' => 'validateur.projets.index'],
            ['label' => 'Mes projets traités',   'icon' => 'fa-folder-open',  'route' => 'validateur.projets.mes_projets'],
        ],
        'planificateur' => [
            ['label' => 'Projets à traiter', 'icon' => 'fa-inbox',       'route' => 'planificateur.projets.index'],
            ['label' => 'Projets traités',   'icon' => 'fa-folder-open','route' => 'planificateur.projets.traites'],
        ],
    ];

    $items = $menusParRole[$role] ?? [];

    // FIX : vrais noms de route admin.users.*/admin.secteurs.*/admin.motifs.*
    // (pas users.*/secteurs.*/motifs.* — ce sont des noms de vue, pas de route)
    $parametresActif = request()->routeIs('parametres.*')
        || request()->routeIs('admin.users.*')
        || request()->routeIs('admin.secteurs.*')
        || request()->routeIs('admin.motifs.*')
        || request()->routeIs('admin.logs.*');
@endphp

<div class="sidebar" id="mainSidebar">

    <!-- Header logo -->
    <div class="sidebar-header d-flex align-items-center px-3 py-3">
        <x-brand.logo :size="36" :show-text="true" />
    </div>

    <ul class="nav-menu flex-grow-1">

        <!-- Tableau de bord -->
        <li class="nav-item">
            <a href="{{ route($role . '.dashboard') }}"
                class="nav-link {{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}"
                data-tooltip="Tableau de bord">
                <i class="fas fa-home"></i>
                <span>Tableau de bord</span>
            </a>
        </li>

        {{-- Liens spécifiques au rôle connecté --}}
        @foreach ($items as $item)
            @continue(isset($item['permission']) && !auth()->user()->can($item['permission']))
            @continue(!Route::has($item['route']))
            <li class="nav-item">
                <a href="{{ route($item['route']) }}"
                    class="nav-link {{ $estActif($item['route']) ? 'active' : '' }}"
                    data-tooltip="{{ $item['label'] }}">
                    <i class="fas {{ $item['icon'] }}"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach

        {{-- COMMUN --}}

        <li class="nav-item">
            <a href="{{ route($role . '.notifications.index') }}"
                class="nav-link {{ request()->routeIs($role . '.notifications*') ? 'active' : '' }}"
                data-tooltip="Notifications">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                @if($notifCount > 0)
                    <span class="badge">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('parametres.index') }}"
                class="nav-link {{ $parametresActif ? 'active' : '' }}"
                data-tooltip="Paramètres">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </li>

        <div class="trait"></div>

        <!-- Déconnexion -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start"
                        data-tooltip="Déconnexion">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>

        <!-- Toggle -->
        <li class="nav-item">
            <button class="nav-link w-100 border-0 bg-transparent text-start"
                    id="toggleSidebar" data-tooltip="Réduire">
                <i class="fas fa-chevron-left" id="toggleIcon"></i>
                <span class="toggle-text">Réduire</span>
            </button>
        </li>

        <div class="trait"></div>

        <!-- Utilisateur connecté -->
        <li class="nav-item sidebar-user-info" id="userInfo" data-tooltip="{{ Auth::user()->nomComplet }}">
            <div class="nav-link sidebar-user-link">
                <x-avatars.avatar :size="34" class="user-avatar-sm" />
                <div class="user-info-text">
                    <div class="fw-bold">{{ Auth::user()->nomComplet }}</div>
                    <div class="user-role">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </li>

    </ul>
</div>

@push('scripts')
<script src="{{ asset('js/sidebar-toggle.js') }}"></script>
@endpush
@endauth
