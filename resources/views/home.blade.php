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
        .navbar-home { background-color: var(--vino-dark); border-bottom: 3px solid var(--vino); }
        .hero { background: linear-gradient(135deg, var(--vino-dark), var(--vino)); color: #fff; padding: 80px 0; }
        .hero h1 { font-family: Georgia, serif; font-size: 3rem; font-weight: 800; }
        .hero p { font-size: 1.2rem; color: #e8d5b0; }
        .btn-vino { background-color: var(--vino-light); color: #fff; border: none; padding: 12px 30px; font-size: 1rem; border-radius: 6px; }
        .btn-vino:hover { background-color: #a03030; color: #fff; }
        .section-title { color: var(--vino-dark); font-family: Georgia, serif; font-weight: 700; border-left: 4px solid var(--vino); padding-left: 12px; }
        .card-libro { background: #fff; border: none; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s; overflow: hidden; }
        .card-libro:hover { transform: translateY(-4px); box-shadow: 0 8px 25px rgba(61,15,15,0.15); }
        .card-libro img { width: 100%; height: 200px; object-fit: cover; }
        .card-libro .placeholder-img { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .badge-categoria { background-color: var(--vino); color: #fff; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; }
        .feature-icon { font-size: 2.5rem; margin-bottom: 15px; }
        footer { background-color: var(--vino-dark); color: #c9a87c; padding: 30px 0; margin-top: 60px; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-sm navbar-home py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span style="font-size:1.5rem"></span>
            <div>
                <span style="display:block;font-size:1rem;font-weight:800;color:#fff;font-family:Georgia,serif;line-height:1">VERSO & TINTA</span>
                <span style="display:block;font-size:0.6rem;color:#c9a87c;letter-spacing:2px">LIBRERÍA LITERARIA</span>
            </div>
        </a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-3">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn btn-sm btn-vino px-3">Registrarse</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero text-center">
    <div class="container">
        <h1>Verso & Tinta</h1>
        <p class="mb-4">Tu librería literaria — descubre, explora y gestiona el mundo de los libros</p>
        <a href="{{ route('login') }}" class="btn btn-vino me-2">Entrar al sistema</a>
        <a href="{{ route('catalogo') }}" class="btn btn-outline-light">Ver catálogo</a>
    </div>
</section>

{{-- FEATURES --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="feature-icon"></div>
                <h5 style="color:var(--vino-dark);font-weight:700">Gestión de Libros</h5>
                <p class="text-muted">Registra y administra tu colección completa con portadas, resúmenes y autores.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon"></div>
                <h5 style="color:var(--vino-dark);font-weight:700">Autores</h5>
                <p class="text-muted">Mantén un registro detallado de todos los autores y su bibliografía.</p>
            </div>
            <div class="col-md-4">
                <div class="feature-icon"></div>
                <h5 style="color:var(--vino-dark);font-weight:700">Categorías</h5>
                <p class="text-muted">Organiza los libros por géneros y categorías para una búsqueda más fácil.</p>
            </div>
        </div>
    </div>
</section>

{{-- CATÁLOGO PÚBLICO --}}
<section class="py-5" id="catalogo" style="background:#fff">
    <div class="container">
        <h2 class="section-title mb-4">Catálogo de Libros</h2>
        <div class="row g-4">
            @forelse(\App\Models\Libro::with(['autor','categoria'])->latest()->take(6)->get() as $libro)
            <div class="col-sm-6 col-lg-4">
                <div class="card-libro h-100">
                    @if($libro->portada)
                        <img src="{{ asset('storage/'.$libro->portada) }}" alt="{{ $libro->titulo }}">
                    @else
                        <div class="placeholder-img"></div>
                    @endif
                    <div class="p-3">
                        <span class="badge-categoria mb-2 d-inline-block">{{ $libro->categoria->nombre }}</span>
                        <h6 class="fw-bold mb-1">{{ $libro->titulo }}</h6>
                        <p class="small mb-1" style="color:var(--vino)">{{ $libro->autor->nombre }}</p>
                        <p class="text-muted small">{{ Str::limit($libro->resumen, 80) }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">
                <p>No hay libros registrados aún.</p>
                <a href="{{ route('login') }}" class="btn btn-vino">Iniciar sesión para agregar</a>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="text-center">
    <p class="mb-1" style="font-family:Georgia,serif;font-size:1.1rem">Verso & Tinta</p>
    <small>© {{ date('Y') }} — Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>