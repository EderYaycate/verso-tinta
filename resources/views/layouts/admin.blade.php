<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --vino: #6B1C1C;
            --vino-dark: #3d0f0f;
            --vino-light: #8B2525;
            --crema: #f5f0e8;
        }
        body { background-color: var(--crema); font-family: 'Segoe UI', sans-serif; margin: 0; }

        .topbar { background-color: var(--vino-dark); height: 60px; display: flex; align-items: center; justify-content: space-between; padding: 0 24px; position: fixed; top: 0; left: 0; right: 0; z-index: 100; border-bottom: 2px solid var(--vino); }
        .topbar-brand { color: #fff; font-family: Georgia, serif; font-weight: 800; font-size: 1rem; text-decoration: none; }
        .topbar-brand span { display: block; font-size: 0.6rem; color: #c9a87c; letter-spacing: 2px; font-weight: 400; }
        .topbar-user { color: #e8d5b0; font-size: 0.9rem; display: flex; align-items: center; gap: 12px; }

        .sidebar { position: fixed; top: 60px; left: 0; bottom: 0; width: 220px; background-color: #fff; border-right: 1px solid #e0d5c5; padding: 24px 0; overflow-y: auto; }
        .sidebar-section { padding: 8px 24px; font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; }
        .sidebar-item { display: flex; align-items: center; gap: 10px; padding: 10px 24px; color: #555; text-decoration: none; font-size: 0.9rem; transition: all 0.2s; }
        .sidebar-item:hover { background-color: var(--crema); color: var(--vino-dark); }
        .sidebar-item.active { background-color: var(--crema); color: var(--vino-dark); font-weight: 600; border-left: 3px solid var(--vino); }
        .sidebar-icon { width: 18px; text-align: center; }
        .sidebar-divider { border-top: 1px solid #e0d5c5; margin: 12px 0; }
        .sidebar-quote { padding: 16px 24px; color: #999; font-size: 0.75rem; font-style: italic; line-height: 1.5; }

        .main-content { margin-left: 220px; margin-top: 60px; padding: 32px; min-height: calc(100vh - 60px); }

        .btn-vino { background-color: var(--vino); color: #fff; border: none; }
        .btn-vino:hover { background-color: var(--vino-light); color: #fff; }
        .card-custom { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .page-title { color: var(--vino-dark); font-weight: 700; font-family: Georgia, serif; margin-bottom: 4px; }
        .page-title-line { width: 40px; height: 2px; background-color: var(--vino); margin-bottom: 24px; }
        .table thead { background-color: var(--vino-dark); color: #e8d5b0; }
        .table tbody tr:hover { background-color: #fdf5e8; }
        .badge-vino { background-color: var(--vino); color: #fff; }
        .portada-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; }
        .portada-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 8px 8px 0 0; }
        .alert-success-custom { background-color: #d4edda; border-left: 4px solid #28a745; color: #155724; }
        .form-control:focus, .form-select:focus { border-color: var(--vino); box-shadow: 0 0 0 0.2rem rgba(107,28,28,0.2); }

        footer { background-color: var(--vino-dark); color: #c9a87c; margin-left: 220px; }
    </style>
</head>
<body>

<div class="topbar">
    <a class="topbar-brand" href="{{ route('libros.index') }}">
        VERSO & TINTA
        <span>LIBRERIA LITERARIA</span>
    </a>
    <div class="topbar-user">
        <span>Administrador</span>
        <form action="{{ route('logout') }}" method="POST" class="mb-0">
            @csrf
            <button class="btn btn-sm" style="color:#c9a87c;border:1px solid #c9a87c;padding:4px 12px;">Salir</button>
        </form>
    </div>
</div>

<div class="sidebar">
    <div class="sidebar-section">Gestión</div>
    <a href="{{ route('libros.index') }}" class="sidebar-item {{ request()->routeIs('libros.*') ? 'active' : '' }}">
        <span class="sidebar-icon">&#128218;</span> Libros
    </a>
    <a href="{{ route('autores.index') }}" class="sidebar-item {{ request()->routeIs('autores.*') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9997;</span> Autores
    </a>
    <a href="{{ route('categorias.index') }}" class="sidebar-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
        <span class="sidebar-icon">&#127991;</span> Categorias
    </a>
    <a href="{{ route('admin.pedidos') }}" class="sidebar-item {{ request()->routeIs('admin.pedidos') ? 'active' : '' }}">
        <span class="sidebar-icon">&#128230;</span> Pedidos
    </a>

    <div class="sidebar-divider"></div>

    <div class="sidebar-section">Estructuras</div>
    <a href="{{ route('estructuras.lista') }}" class="sidebar-item {{ request()->routeIs('estructuras.lista') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9783;</span> Catalogo
    </a>
    <a href="{{ route('estructuras.pila') }}" class="sidebar-item {{ request()->routeIs('estructuras.pila') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9783;</span> Historial
    </a>
    <a href="{{ route('estructuras.cola') }}" class="sidebar-item {{ request()->routeIs('estructuras.cola') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9783;</span> Solicitudes
    </a>
    <a href="{{ route('estructuras.arbol') }}" class="sidebar-item {{ request()->routeIs('estructuras.arbol') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9783;</span> Busqueda
    </a>
    <a href="{{ route('estructuras.grafo') }}" class="sidebar-item {{ request()->routeIs('estructuras.grafo') ? 'active' : '' }}">
        <span class="sidebar-icon">&#9783;</span> Relaciones
    </a>

    <div class="sidebar-quote">
        "Los libros son tinta sobre papel, pero también son puertas a otros mundos."
    </div>
</div>

<div class="main-content">
    @if(session('success'))
        <div class="alert alert-success-custom rounded px-4 py-3 mb-4">
            {{ session('success') }}
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