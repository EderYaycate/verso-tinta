<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo — Verso & Tinta</title>
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
        .section-title { color: var(--vino-dark); font-family: Georgia, serif; font-weight: 700; border-left: 4px solid var(--vino); padding-left: 12px; }
        .btn-vino { background-color: var(--vino); color: #fff; border: none; }
        .btn-vino:hover { background-color: var(--vino-light); color: #fff; }
        .card-libro { background: #fff; border: none; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s; overflow: hidden; }
        .card-libro:hover { transform: translateY(-4px); }
        .card-libro img { width: 100%; height: 200px; object-fit: cover; }
        .placeholder-img { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .badge-categoria { background-color: var(--vino); color: #fff; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; }
        .filter-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); padding: 20px; margin-bottom: 30px; }
        .form-control:focus, .form-select:focus { border-color: var(--vino); box-shadow: 0 0 0 0.2rem rgba(107,28,28,0.2); }
        footer { background-color: var(--vino-dark); color: #c9a87c; padding: 20px 0; margin-top: 60px; }
    </style>
</head>
<body>

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
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light">← Inicio</a>
            <a href="{{ route('login') }}" class="btn btn-sm btn-vino">Iniciar Sesión</a>
        </div>
    </div>
</nav>

<main class="container py-5">
    <h2 class="section-title mb-4">Catálogo de Libros</h2>

    {{-- FILTROS — FLUJO SECUNDARIO --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('catalogo') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold"> Buscar por título</label>
                <input type="text" name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Ej: Cien años...">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold"> Filtrar por categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold"> Filtrar por autor</label>
                <select name="autor_id" class="form-select">
                    <option value="">Todos los autores</option>
                    @foreach($autores as $autor)
                        <option value="{{ $autor->id }}" {{ request('autor_id') == $autor->id ? 'selected' : '' }}>
                            {{ $autor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-vino w-100">Buscar</button>
                <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- RESULTADOS --}}
    <p class="text-muted mb-3">
        Mostrando <strong>{{ $libros->count() }}</strong> libro(s)
        @if(request('buscar')) con título "<strong>{{ request('buscar') }}</strong>" @endif
        @if(request('categoria_id')) en la categoría "<strong>{{ $categorias->find(request('categoria_id'))->nombre ?? '' }}</strong>" @endif
        @if(request('autor_id')) del autor "<strong>{{ $autores->find(request('autor_id'))->nombre ?? '' }}</strong>" @endif
    </p>

    <div class="row g-4">
        @forelse($libros as $libro)
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
                    <p class="small mb-1" style="color:var(--vino)"> {{ $libro->autor->nombre }}</p>
                    <p class="text-muted small">{{ Str::limit($libro->resumen, 90) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No se encontraron libros con esos filtros.</p>
            <a href="{{ route('catalogo') }}" class="btn btn-vino">Ver todos</a>
        </div>
        @endforelse
    </div>
</main>

<footer class="text-center">
    <small> Verso & Tinta © {{ date('Y') }}</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>