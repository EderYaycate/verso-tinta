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
        body { background-color: var(--crema); font-family: 'Segoe UI', sans-serif; }
        .navbar-main { background-color: var(--vino-dark); border-bottom: 2px solid var(--vino); }
        .navbar-main .nav-link { color: #e8d5b0 !important; font-size: 0.9rem; padding: 12px 16px !important; transition: background 0.2s; }
        .navbar-main .nav-link:hover, .navbar-main .nav-link.active { background-color: var(--vino) !important; color: #fff !important; }
        .navbar-main .dropdown-menu { background-color: var(--vino-dark); border: 1px solid var(--vino); }
        .navbar-main .dropdown-item { color: #e8d5b0; }
        .navbar-main .dropdown-item:hover { background-color: var(--vino); color: #fff; }
        .btn-vino { background-color: var(--vino); color: #fff; border: none; }
        .btn-vino:hover { background-color: var(--vino-light); color: #fff; }
        .card-custom { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .page-title { color: var(--vino-dark); font-weight: 700; border-left: 4px solid var(--vino); padding-left: 12px; font-family: Georgia, serif; }
        .table thead { background-color: var(--vino-dark); color: #e8d5b0; }
        .table tbody tr:hover { background-color: #fdf5e8; }
        .badge-vino { background-color: var(--vino); color: #fff; }
        .portada-img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; }
        .portada-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; border-radius: 8px 8px 0 0; }
        .alert-success-custom { background-color: #d4edda; border-left: 4px solid #28a745; color: #155724; }
        .form-control:focus, .form-select:focus { border-color: var(--vino); box-shadow: 0 0 0 0.2rem rgba(107,28,28,0.2); }
        footer { background-color: var(--vino-dark); color: #c9a87c; }
        .carrito-badge { position: absolute; top: 6px; right: 6px; background: #e74c3c; color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: 700; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-main py-2">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div>
                <span style="display:block;font-size:1rem;font-weight:800;color:#fff;font-family:Georgia,serif;line-height:1">VERSO & TINTA</span>
                <span style="display:block;font-size:0.6rem;color:#c9a87c;letter-spacing:2px">LIBRERIA LITERARIA</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('usuario.lista') ? 'active' : '' }}"
                        href="{{ route('usuario.lista') }}">Catalogo</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Explorar</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request()->routeIs('usuario.lista') ? 'active' : '' }}"
                            href="{{ route('usuario.lista') }}">Catalogo de Libros</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('usuario.pila') ? 'active' : '' }}"
                            href="{{ route('usuario.pila') }}">Ultimos Agregados</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('usuario.cola') ? 'active' : '' }}"
                            href="{{ route('usuario.cola') }}">Libros en Orden</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('usuario.arbol') ? 'active' : '' }}"
                            href="{{ route('usuario.arbol') }}">Buscar Libros</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('usuario.grafo') ? 'active' : '' }}"
                            href="{{ route('usuario.grafo') }}">Autores Relacionados</a></li>
                    </ul>
                </li>

                {{-- Carrito --}}
                <li class="nav-item">
                    <a class="nav-link position-relative {{ request()->routeIs('carrito.index') ? 'active' : '' }}"
                        href="{{ route('carrito.index') }}">
                        🛒
                        @php
                            $cantidadCarrito = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad');
                        @endphp
                        @if($cantidadCarrito > 0)
                            <span class="carrito-badge">{{ $cantidadCarrito }}</span>
                        @endif
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item {{ request()->routeIs('pedidos.historial') ? 'active' : '' }}"
                            href="{{ route('pedidos.historial') }}">Mis Pedidos</a></li>
                        <li><hr class="dropdown-divider" style="border-color:#8B2525"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item">Cerrar Sesion</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
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
</main>

<footer class="text-center py-3 mt-5">
    <small>Verso & Tinta &copy; {{ date('Y') }}</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>