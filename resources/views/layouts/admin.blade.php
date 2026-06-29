<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --vino: #6B1C1C;
            --vino-dark: #3d0f0f;
            --vino-light: #8B2525;
            --crema: #f5f0e8;
            --dorado: #c9a87c;
        }
        * { box-sizing: border-box; }
        body { background-color: var(--crema); font-family: 'Montserrat', sans-serif; margin: 0; }

        /* TOPBAR */
        .topbar { background: linear-gradient(90deg, var(--vino-dark), #5a1010); height: 64px; display: flex; align-items: center; justify-content: space-between; padding: 0 28px; position: fixed; top: 0; left: 0; right: 0; z-index: 100; border-bottom: 2px solid var(--dorado); box-shadow: 0 2px 12px rgba(0,0,0,0.2); }
        .topbar-brand { color: #fff; font-family: Georgia, serif; font-weight: 800; font-size: 1.05rem; text-decoration: none; line-height: 1; }
        .topbar-brand span { display: block; font-size: 0.58rem; color: var(--dorado); letter-spacing: 3px; font-weight: 400; font-family: 'Montserrat', sans-serif; margin-top: 2px; }
        .topbar-user { color: #e8d5b0; font-size: 0.88rem; display: flex; align-items: center; gap: 14px; }
        .topbar-user .user-name { color: var(--dorado); font-weight: 600; }
        .btn-salir { color: var(--dorado); border: 1px solid var(--dorado); padding: 5px 14px; font-size: 0.82rem; background: none; border-radius: 5px; cursor: pointer; font-family: 'Montserrat', sans-serif; font-weight: 600; transition: all 0.2s; }
        .btn-salir:hover { background: var(--dorado); color: var(--vino-dark); }

        /* SIDEBAR */
        .sidebar { position: fixed; top: 64px; left: 0; bottom: 0; width: 230px; background: #fff; border-right: 1px solid #e8dcc8; padding: 20px 0; overflow-y: auto; box-shadow: 2px 0 8px rgba(0,0,0,0.04); }
        .sidebar-section { padding: 10px 22px 4px; font-size: 0.68rem; color: #b0a090; text-transform: uppercase; letter-spacing: 2px; margin-top: 6px; font-weight: 700; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 10px 22px; color: #666; text-decoration: none; font-size: 0.88rem; transition: all 0.2s; border-left: 3px solid transparent; font-weight: 500; }
        .sidebar-item:hover { background: var(--crema); color: var(--vino-dark); border-left-color: var(--dorado); }
        .sidebar-item.active { background: linear-gradient(90deg, #fdf5e8, #fffdf8); color: var(--vino-dark); font-weight: 700; border-left: 3px solid var(--vino); }
        .s-icon { width: 36px; height: 36px; min-width: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); border: 2px solid var(--dorado); box-shadow: 0 3px 8px rgba(61,15,15,0.25); flex-shrink: 0; }
        .sidebar-divider { border: none; border-top: 1px solid #f0e8e0; margin: 14px 0; }
        .sidebar-quote { padding: 16px 22px; color: #bbb; font-size: 0.72rem; font-style: italic; line-height: 1.6; border-top: 1px solid #f0e8e0; margin-top: 8px; }

        /* MAIN */
        .main-content { margin-left: 230px; margin-top: 64px; padding: 32px; min-height: calc(100vh - 64px); }

        /* COMPONENTS */
        .btn-vino { background: linear-gradient(135deg, var(--vino-dark), var(--vino)); color: #fff; border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; }
        .btn-vino:hover { background: linear-gradient(135deg, var(--vino), var(--vino-light)); color: #fff; }
        .card-custom { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.07); }
        .page-title { color: var(--vino-dark); font-weight: 700; font-family: Georgia, serif; margin-bottom: 4px; }
        .page-title-line { width: 40px; height: 3px; background: linear-gradient(90deg, var(--vino-dark), var(--dorado)); margin-bottom: 24px; border-radius: 2px; }
        .table thead { background: linear-gradient(90deg, var(--vino-dark), var(--vino)); color: #e8d5b0; }
        .table tbody tr:hover { background-color: #fdf5e8; }
        .badge-vino { background-color: var(--vino); color: #fff; }
        .portada-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; }
        .portada-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 8px 8px 0 0; }
        .alert-success-custom { background-color: #d4edda; border-left: 4px solid #28a745; color: #155724; border-radius: 8px; }
        .form-control:focus, .form-select:focus { border-color: var(--vino); box-shadow: 0 0 0 0.2rem rgba(107,28,28,0.15); }

        footer { background: linear-gradient(90deg, var(--vino-dark), #5a1010); color: var(--dorado); margin-left: 230px; border-top: 1px solid var(--dorado); }
    </style>
</head>
<body>

<div class="topbar">
    <a class="topbar-brand" href="{{ route('libros.index') }}">
        VERSO & TINTA
        <span>LIBRERÍA LITERARIA</span>
    </a>
    <div class="topbar-user">
        <span class="user-name">Administrador</span>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button class="btn-salir">Salir</button>
        </form>
    </div>
</div>

<div class="sidebar">
    <div class="sidebar-section">Gestión</div>

    <a href="{{ route('libros.index') }}" class="sidebar-item {{ request()->routeIs('libros.*') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <rect x="10" y="6" width="36" height="46" rx="4" fill="#f5e0a0"/>
                <rect x="10" y="6" width="6" height="46" rx="3" fill="#d6af55"/>
                <rect x="16" y="14" width="24" height="3" rx="1.5" fill="#d6af55"/>
                <rect x="16" y="22" width="20" height="3" rx="1.5" fill="#d6af55" opacity="0.7"/>
                <rect x="16" y="30" width="22" height="3" rx="1.5" fill="#d6af55" opacity="0.5"/>
                <rect x="12" y="4" width="36" height="46" rx="4" fill="#f5e0a0" opacity="0.5"/>
            </svg>
        </span>
        Libros
    </a>

    <a href="{{ route('categorias.index') }}" class="sidebar-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <rect x="10" y="18" width="38" height="38" rx="5" fill="#f5e0a0"/>
                <rect x="10" y="18" width="38" height="10" rx="5" fill="#d6af55" opacity="0.8"/>
                <circle cx="48" cy="14" r="9" fill="#d6af55"/>
                <path d="M48 8 L48 14 L53 14" stroke="#3d0f0f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <rect x="18" y="34" width="22" height="3" rx="1.5" fill="#d6af55"/>
                <rect x="18" y="42" width="16" height="3" rx="1.5" fill="#d6af55" opacity="0.6"/>
            </svg>
        </span>
        Categorías
    </a>

    <a href="{{ route('admin.pedidos') }}" class="sidebar-item {{ request()->routeIs('admin.pedidos') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <rect x="8" y="20" width="48" height="36" rx="5" fill="#f5e0a0"/>
                <path d="M20 20 L20 14 C20 10 24 6 32 6 C40 6 44 10 44 14 L44 20" stroke="#d6af55" stroke-width="3" stroke-linecap="round" fill="none"/>
                <rect x="26" y="30" width="12" height="3" rx="1.5" fill="#d6af55"/>
                <rect x="18" y="38" width="28" height="3" rx="1.5" fill="#d6af55" opacity="0.7"/>
                <rect x="18" y="46" width="22" height="3" rx="1.5" fill="#d6af55" opacity="0.5"/>
            </svg>
        </span>
        Pedidos
    </a>

    <hr class="sidebar-divider">
    <div class="sidebar-section">Estructuras</div>

    <a href="{{ route('estructuras.historial') }}" class="sidebar-item {{ request()->routeIs('estructuras.historial') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <circle cx="32" cy="32" r="24" fill="#f5e0a0" opacity="0.6"/>
                <path d="M32 14 L32 32 L44 38" stroke="#d6af55" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <circle cx="32" cy="32" r="22" stroke="#d6af55" stroke-width="3" fill="none"/>
            </svg>
        </span>
        Historial
    </a>

    <a href="{{ route('estructuras.arbol') }}" class="sidebar-item {{ request()->routeIs('estructuras.arbol') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <rect x="10" y="8" width="18" height="12" rx="3" fill="#d6af55"/>
                <rect x="36" y="8" width="18" height="12" rx="3" fill="#d6af55" opacity="0.6"/>
                <rect x="22" y="44" width="20" height="12" rx="3" fill="#d6af55" opacity="0.8"/>
                <line x1="32" y1="20" x2="32" y2="44" stroke="#d6af55" stroke-width="2.5"/>
                <line x1="19" y1="20" x2="32" y2="32" stroke="#d6af55" stroke-width="2" opacity="0.7"/>
                <line x1="45" y1="20" x2="32" y2="32" stroke="#d6af55" stroke-width="2" opacity="0.7"/>
            </svg>
        </span>
        Libros A-Z
    </a>

    <a href="{{ route('estructuras.grafo') }}" class="sidebar-item {{ request()->routeIs('estructuras.grafo') ? 'active' : '' }}">
        <span class="s-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 64 64" fill="none">
                <path d="M32 6 C24 10 18 18 20 28 C22 36 28 40 32 42 C36 40 42 36 44 28 C46 18 40 10 32 6Z" fill="#f5e0a0"/>
                <path d="M32 6 C29 12 28 20 29 28 C30 35 32 42 32 42 C32 42 34 35 35 28 C36 20 35 12 32 6Z" fill="#d6af55"/>
                <rect x="28" y="42" width="8" height="12" rx="4" fill="#d6af55"/>
                <ellipse cx="32" cy="54" rx="8" ry="3" fill="#d6af55" opacity="0.7"/>
            </svg>
        </span>
        Autores Destacados
    </a>

    <div class="sidebar-quote">
        "Los libros son tinta sobre papel, pero también son puertas a otros mundos."
    </div>
</div>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success-custom px-4 py-3 mb-4">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded px-4 py-3 mb-4">
            {{ session('error') }}
        </div>
    @endif
    @yield('content')
</div>

<footer class="text-center py-3 mt-5">
    <small>Verso & Tinta &copy; {{ date('Y') }}</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>