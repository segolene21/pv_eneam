<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Archive des PV') - ENEAM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('inapp/assets/images/favicon-32x32.png') }}">

    <script type="module" crossorigin src="{{ asset('inapp/assets/js/main.js') }}"></script>
    <link rel="stylesheet" crossorigin href="{{ asset('inapp/assets/css/main.css') }}">
</head>

<body>
    <div id="overlay" class="overlay"></div>

    {{-- BARRE DU HAUT --}}
    <nav id="topbar" class="navbar bg-white border-bottom fixed-top topbar px-3">
        <button id="toggleBtn" class="d-none d-lg-inline-flex btn btn-light btn-icon btn-sm">
            <i class="ti ti-layout-sidebar-left-expand"></i>
        </button>
        <button id="mobileBtn" class="btn btn-light btn-icon btn-sm d-lg-none me-2">
            <i class="ti ti-layout-sidebar-left-expand"></i>
        </button>

        <div>
            <ul class="list-unstyled d-flex align-items-center mb-0 gap-1">
                <li class="ms-3 dropdown">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('inapp/assets/images/avatar-1.jpg') }}" alt=""
                             class="avatar avatar-sm rounded-circle" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-0" style="min-width: 220px;">
                        <div class="d-flex gap-3 align-items-center border-bottom px-3 py-3">
                            <img src="{{ asset('inapp/assets/images/avatar-1.jpg') }}" alt=""
                                 class="avatar avatar-md rounded-circle" />
                            <div>
                                <h4 class="mb-0 small">{{ auth()->user()->name }}</h4>
                                <p class="mb-0 small text-secondary">
                                    {{ auth()->user()->role === 'admin' ? 'Administrateur' : 'Chef de département' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-3 d-flex flex-column gap-2 small">
                            <a href="{{ route('profile.edit') }}">Mon profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 small text-decoration-none">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    {{-- MENU LATERAL --}}
    <aside id="sidebar" class="sidebar">
        <div class="logo-area">
            <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center">
                <i class="ti ti-files fs-3 text-primary"></i>
                <span class="logo-text ms-2 fw-bold">Archive des PV</span>
            </a>
        </div>

        <ul class="nav flex-column">
            <li class="px-4 py-2"><small class="nav-text">Principal</small></li>

            <li>
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="ti ti-home"></i><span class="nav-text">Tableau de bord</span>
                </a>
            </li>

            @if (Route::has('pvs.index'))
                <li>
                    <a class="nav-link {{ request()->routeIs('pvs.index', 'pvs.show') ? 'active' : '' }}"
                       href="{{ route('pvs.index') }}">
                        <i class="ti ti-file-text"></i><span class="nav-text">Procès-verbaux</span>
                    </a>
                </li>
            @endif
@if (Route::has('pvs.parcourir'))
    <li>
        <a class="nav-link {{ request()->routeIs('pvs.parcourir') ? 'active' : '' }}"
           href="{{ route('pvs.parcourir') }}">
            <i class="ti ti-building"></i><span class="nav-text">Par filière</span>
        </a>
    </li>
@endif
            @if (auth()->user()->role === 'admin')
                <li class="px-4 pt-4 pb-2"><small class="nav-text">Administration</small></li>

                @if (Route::has('pvs.create'))
                    <li>
                        <a class="nav-link {{ request()->routeIs('pvs.create') ? 'active' : '' }}"
                           href="{{ route('pvs.create') }}">
                            <i class="ti ti-plus"></i><span class="nav-text">Ajouter un PV</span>
                        </a>
                    </li>
                @endif

                @if (Route::has('filieres.index'))
                    <li>
                        <a class="nav-link {{ request()->routeIs('filieres.*') ? 'active' : '' }}"
                           href="{{ route('filieres.index') }}">
                            <i class="ti ti-building"></i><span class="nav-text">Filières</span>
                        </a>
                    </li>
                @endif
                @if (Route::has('admin.users.index'))
    <li>
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
           href="{{ route('admin.users.index') }}">
            <i class="ti ti-users"></i><span class="nav-text">Utilisateurs</span>
        </a>
    </li>
@endif
            @endif
        </ul>
    </aside>

    {{-- CONTENU DE LA PAGE --}}
    <main id="content" class="content py-10">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-6">
                        <h1 class="fs-3 mb-1">@yield('title')</h1>
                        @hasSection('subtitle')
                            <p class="text-secondary">@yield('subtitle')</p>
                        @endif
                    </div>
                </div>
            </div>

            @yield('content')

            <footer class="text-center py-2 mt-6 text-secondary">
                <p class="mb-0">ENEAM - Archive des PV de délibération</p>
            </footer>
        </div>
    </main>
</body>
</html>