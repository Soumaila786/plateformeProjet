
<nav class="navbar navbar-expand-lg sticky-top" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div class="container-fluid px-4">
        <!-- Logo et nom de l'application -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div class="brand-icon me-2" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-tasks text-white" style="font-size: 1.2rem;"></i>
            </div>
            <div>
                <span class="fw-bold" style="color: #1e293b;">{{ config('app.name') }}</span>
                <small class="d-block text-muted" style="font-size: 0.7rem; line-height: 1;">Gestion de projets</small>
            </div>
        </a>

        <!-- Bouton toggler pour mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="box-shadow: none;">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu de droite -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                    <!-- Utilisateur non connecté -->
                    <li class="nav-item me-2">
                        <a class="nav-link px-3 py-2 rounded-3" href="{{ route('login') }}" style="color: #475569; transition: all 0.3s ease;">
                            <i class="fas fa-sign-in-alt me-2" style="color: #3b82f6;"></i>
                            <span>Connexion</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-3" href="#" style="color: #475569; transition: all 0.3s ease;">
                            <i class="fas fa-user-plus me-2" style="color: #8b5cf6;"></i>
                            <span>Inscription</span>
                        </a>
                    </li>
                @else
                    <!-- Notifications -->
                    <li class="nav-item me-2">
                        <a class="nav-link position-relative px-3 py-2 rounded-3" href="#" style="color: #475569;">
                            <i class="fas fa-bell" style="color: #64748b;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                                  style="background: #ef4444; font-size: 0.6rem; padding: 0.25rem 0.4rem;">
                                3
                            </span>
                        </a>
                    </li>


                    <!-- Profil utilisateur -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" style="color: #1e293b;">
                            <div class="user-avatar-sm me-2" style="width: 38px; height: 38px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1rem;">
                                {{ substr(Auth::user()->nomComplet, 0, 1) }}
                            </div>
                            <div class="d-none d-lg-block text-start">
                                <div class="fw-semibold" style="font-size: 0.9rem; color: #1e293b;">{{ Auth::user()->nomComplet }}</div>
                                <small style="font-size: 0.7rem; color: #64748b;">{{ ucfirst(Auth::user()->role) }}</small>
                            </div>
                        </a>

                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius: 12px; padding: 0.5rem; min-width: 220px;">
                             <li>
                                <a class="dropdown-item rounded-3" href="/profil" style="padding: 0.7rem 1rem; color: #475569;">
                                    <i class="fas fa-user me-3" style="color: #8b5cf6; width: 20px;"></i>
                                    <span>Mon profil</span>
                                </a>
                            </li>
                           
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3" style="padding: 0.7rem 1rem; color: #ef4444;">
                                        <i class="fas fa-sign-out-alt me-3" style="width: 20px;"></i>
                                        <span>Déconnexion</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Styles personnalisés pour le header -->
<style>
    /* Animation du dropdown */
    .dropdown-menu {
        animation: dropdownFade 0.3s ease;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    @keyframes dropdownFade {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Hover effects */
    .nav-link {
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .nav-link:hover {
        background: rgba(59, 130, 246, 0.05);
        transform: translateY(-1px);
    }

    .dropdown-item {
        transition: all 0.2s ease;
        border-radius: 8px;
        font-size: 0.95rem;
    }

    .dropdown-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }

    /* Badge animation */
    .badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
        }
        70% {
            box-shadow: 0 0 0 5px rgba(239, 68, 68, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 1rem;
        }

        .dropdown-menu {
            width: 100%;
        }
    }

    /* Effet de glassmorphisme léger */
    .navbar {
        backdrop-filter: blur(10px);
        background: rgba(248, 250, 252, 0.95) !important;
    }
</style>
