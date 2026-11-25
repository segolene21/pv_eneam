<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Archive des PV') - ENEAM</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/css/adminlte.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">

    {{-- En-tête --}}
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center me-3">
                    {{ auth()->user()->name }}
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-secondary">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Menu latéral --}}
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-link">
                <span class="brand-text fw-light">Archive des PV</span>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <nav class="mt-2">
               <ul class="nav sidebar-menu flex-column" role="menu">

    <li class="nav-item">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon bi bi-speedometer2"></i>
            <p>Tableau de bord</p>
        </a>
    </li>

    @if (Route::has('pvs.index'))
        <li class="nav-item">
            <a href="{{ route('pvs.index') }}"
               class="nav-link {{ request()->routeIs('pvs.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-file-earmark-text"></i>
                <p>Procès-verbaux</p>
            </a>
        </li>
    @endif

    {{-- Réservé à l'admin --}}
    @if (auth()->user()->role === 'admin')
        <li class="nav-header">ADMINISTRATION</li>

        @if (Route::has('annees.index'))
            <li class="nav-item">
                <a href="{{ route('annees.index') }}"
                   class="nav-link {{ request()->routeIs('annees.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-calendar3"></i>
                    <p>Années académiques</p>
                </a>
            </li>
        @endif

        @if (Route::has('filieres.index'))
            <li class="nav-item">
                <a href="{{ route('filieres.index') }}"
                   class="nav-link {{ request()->routeIs('filieres.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-diagram-3"></i>
                    <p>Filières</p>
                </a>
            </li>
        @endif

        @if (Route::has('users.index'))
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-people"></i>
                    <p>Utilisateurs</p>
                </a>
            </li>
        @endif
    @endif

</ul>
            </nav>
        </div>
    </aside>

    {{-- Contenu de la page --}}
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">@yield('title')</h3>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>

    <footer class="app-footer">
        <strong>ENEAM</strong> - Archive des PV de délibération
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/js/adminlte.min.js"></script>
</body>
</html>