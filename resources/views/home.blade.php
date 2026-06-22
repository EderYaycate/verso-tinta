<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --vino: #6B1C1C; --vino-dark: #3d0f0f; --vino-light: #8B2525; --crema: #f5f0e8; }
        body { background-color: var(--crema); font-family: 'Segoe UI', sans-serif; }
        .navbar-home { background-color: var(--vino-dark); border-bottom: 3px solid var(--vino); }
        .hero { background: linear-gradient(135deg, var(--vino-dark), var(--vino)); color: #fff; padding: 80px 0; }
        .hero h1 { font-family: Georgia, serif; font-size: 3rem; font-weight: 800; }
        .hero p { font-size: 1.2rem; color: #e8d5b0; }
        .btn-vino { background-color: var(--vino-light); color: #fff; border: none; padding: 12px 30px; font-size: 1rem; border-radius: 6px; }
        .btn-vino:hover { background-color: #a03030; color: #fff; }
        .section-title { color: var(--vino-dark); font-family: Georgia, serif; font-weight: 700; border-left: 4px solid var(--vino); padding-left: 12px; }
        .card-libro { background: #fff; border: none; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s; overflow: hidden; cursor: pointer; }
        .card-libro:hover { transform: translateY(-4px); }
        .card-libro img { width: 100%; height: 200px; object-fit: cover; }
        .card-libro .placeholder-img { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .badge-categoria { background-color: var(--vino); color: #fff; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; }
        .btn-carrito-nav { position: relative; color: #fff; font-size: 1.3rem; text-decoration: none; padding: 4px 10px; }
        .btn-carrito-nav:hover { color: #c9a87c; }
        footer { background-color: var(--vino-dark); color: #c9a87c; padding: 30px 0; margin-top: 60px; }
        .modal-header { background-color: var(--vino-dark); color: #fff; }
        .modal-header .btn-close { filter: invert(1); }
        .btn-nav-modal { background-color: var(--vino); color: #fff; border: none; padding: 8px 20px; border-radius: 6px; }
        .btn-nav-modal:hover { background-color: var(--vino-dark); color: #fff; }
        .btn-nav-modal:disabled { background-color: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>

@php
    $librosHome = \App\Models\Libro::with(['autor','categoria'])->latest()->take(6)->get();
    $librosData = $librosHome->map(fn($l) => [
        'id'        => $l->id,
        'titulo'    => $l->titulo,
        'autor'     => $l->autor->nombre,
        'categoria' => $l->categoria->nombre,
        'resumen'   => $l->resumen ?? '',
        'precio'    => $l->precio,
        'portada'   => $l->portada ? asset('storage/'.$l->portada) : null,
    ])->values()->toArray();
    $esUsuario   = auth()->check() && auth()->user()->hasRole('usuario');
    $esAdmin     = auth()->check() && auth()->user()->hasRole('admin');
    $csrfToken   = csrf_token();
    $carritoRuta = $esUsuario ? url('/carrito/agregar') : '';
    $loginRuta   = url('/login');
@endphp

<nav class="navbar navbar-expand-sm navbar-home py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div>
                <span style="display:block;font-size:1rem;font-weight:800;color:#fff;font-family:Georgia,serif;line-height:1">VERSO & TINTA</span>
                <span style="display:block;font-size:0.6rem;color:#c9a87c;letter-spacing:2px">LIBRERÍA LITERARIA</span>
            </div>
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            @auth
                @if(auth()->user()->hasRole('usuario'))
                    <a href="{{ route('carrito.index') }}" class="btn-carrito-nav">
                        🛒
                        @php $cant = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad'); @endphp
                        @if($cant > 0)
                            <span style="position:absolute;top:0;right:0;background:#e74c3c;color:#fff;border-radius:50%;width:16px;height:16px;font-size:0.6rem;display:flex;align-items:center;justify-content:center;font-weight:700;">{{ $cant }}</span>
                        @endif
                    </a>
                @elseif(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-sm btn-outline-light px-3">📦 Pedidos</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-light px-3">Salir</button>
                </form>
            @else
                <a href="{{ url('/login') }}?redirect={{ urlencode(url('/carrito')) }}" class="btn-carrito-nav">🛒</a>
                <a href="{{ url('/login') }}" class="btn btn-sm btn-outline-light px-3">Iniciar Sesión</a>
                <a href="{{ url('/register') }}" class="btn btn-sm btn-vino px-3">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h1>Verso & Tinta</h1>
        <p class="mb-4">Tu librería literaria — descubre, explora y gestiona el mundo de los libros</p>
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ url('/libros') }}" class="btn btn-vino me-2">Panel Admin</a>
            @else
                <a href="{{ url('/usuario/catalogo-libros') }}" class="btn btn-vino me-2">Ver Catálogo</a>
            @endif
        @else
            <a href="{{ url('/login') }}" class="btn btn-vino me-2">Acceder a la librería completa</a>
        @endauth
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">📚</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Gestión de Libros</h5>
                <p class="text-muted">Registra y administra tu colección completa con portadas, resúmenes y autores.</p>
            </div>
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">✍️</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Autores</h5>
                <p class="text-muted">Mantén un registro detallado de todos los autores y su bibliografía.</p>
            </div>
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">🏷️</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Categorías</h5>
                <p class="text-muted">Organiza los libros por géneros y categorías para una búsqueda más fácil.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="catalogo" style="background:#fff">
    <div class="container">
        <h2 class="section-title mb-4">Catálogo de Libros</h2>
        <div class="row g-4">
            @php $idx = 0; @endphp
            @forelse($librosHome as $libro)
            <div class="col-sm-6 col-lg-4">
                <div class="card-libro h-100" data-idx="{{ $idx }}">
                    @if($libro->portada)
                        <img src="{{ asset('storage/'.$libro->portada) }}" alt="{{ $libro->titulo }}">
                    @else
                        <div class="placeholder-img">📚</div>
                    @endif
                    <div class="p-3">
                        <span class="badge-categoria mb-2 d-inline-block">{{ $libro->categoria->nombre }}</span>
                        <h6 class="fw-bold mb-1">{{ $libro->titulo }}</h6>
                        <p class="small mb-1" style="color:var(--vino)">{{ $libro->autor->nombre }}</p>
                        <p class="text-muted small mb-2">{{ Str::limit($libro->resumen, 80) }}</p>
                        <p class="fw-bold mb-0" style="color:var(--vino)">S/ {{ number_format($libro->precio, 2) }}</p>
                    </div>
                </div>
            </div>
            @php $idx++; @endphp
            @empty
            <div class="col-12 text-center text-muted py-5">
                <p>No hay libros registrados aún.</p>
                <a href="{{ url('/login') }}" class="btn btn-vino">Iniciar sesión para agregar</a>
            </div>
            @endforelse
        </div>
    </div>
</section>

<div class="modal fade" id="modalLibro" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-5 text-center">
                        <img id="modalPortada" src="" style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div class="col-md-7">
                        <span id="modalCategoria" class="badge mb-2" style="background:#6B1C1C;color:#fff;"></span>
                        <h4 id="modalTituloDetalle" style="color:#3d0f0f;font-family:Georgia,serif;"></h4>
                        <p id="modalAutor" style="color:#6B1C1C;font-weight:600;"></p>
                        <h5 id="modalPrecio" style="color:#6B1C1C;font-weight:700;" class="mb-3"></h5>
                        <p id="modalResumen" class="text-muted small mb-3"></p>
                        <div id="modalAcciones"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn-nav-modal" id="btnAnterior" onclick="navegarModal(-1)">← Anterior</button>
                <span id="modalPosicion" class="text-muted small"></span>
                <button class="btn-nav-modal" id="btnSiguiente" onclick="navegarModal(1)">Siguiente →</button>
            </div>
        </div>
    </div>
</div>

<footer class="text-center">
    <p class="mb-1" style="font-family:Georgia,serif;font-size:1.1rem">Verso & Tinta</p>
    <small>© {{ date('Y') }} — Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
/**
 * @var array  $librosData
 * @var bool   $esUsuario
 * @var bool   $esAdmin
 * @var string $csrfToken
 * @var string $carritoRuta
 * @var string $loginRuta
 */
?>
<script>
    var libros       = <?php echo json_encode($librosData); ?>;
    var esUsuario    = <?php echo $esUsuario ? 'true' : 'false'; ?>;
    var esAdmin      = <?php echo $esAdmin ? 'true' : 'false'; ?>;
    var csrfToken    = '<?php echo $csrfToken; ?>';
    var carritoUrl   = '<?php echo $carritoRuta; ?>';
    var loginUrl     = '<?php echo $loginRuta; ?>';
    var indiceActual = 0;
    var modal        = new bootstrap.Modal(document.getElementById('modalLibro'));

    document.querySelectorAll('.card-libro').forEach(function(card) {
        card.addEventListener('click', function() {
            abrirModal(parseInt(this.getAttribute('data-idx')));
        });
    });

    function abrirModal(idx) {
        indiceActual = idx;
        mostrarLibro();
        modal.show();
    }

    function mostrarLibro() {
        var libro = libros[indiceActual];

        document.getElementById('modalTitulo').textContent       = libro.titulo;
        document.getElementById('modalTituloDetalle').textContent = libro.titulo;
        document.getElementById('modalAutor').textContent         = libro.autor;
        document.getElementById('modalCategoria').textContent     = libro.categoria;
        document.getElementById('modalPrecio').textContent        = 'S/ ' + parseFloat(libro.precio).toFixed(2);
        document.getElementById('modalResumen').textContent       = libro.resumen || '';
        document.getElementById('modalPosicion').textContent      = (indiceActual + 1) + ' / ' + libros.length;

        var portadaEl = document.getElementById('modalPortada');
        portadaEl.style.display = libro.portada ? 'block' : 'none';
        if (libro.portada) portadaEl.src = libro.portada;

        document.getElementById('btnAnterior').disabled = indiceActual === 0;
        document.getElementById('btnSiguiente').disabled = indiceActual === libros.length - 1;

        var librosDelAutor = [];
        var i = 0;
        while (i < libros.length) {
            if (libros[i].autor === libro.autor) librosDelAutor.push(i);
            i++;
        }

        var listaHtml = '<p style="font-size:0.82rem;font-weight:600;color:#3d0f0f;margin-bottom:8px;">Más libros de ' + libro.autor + ':</p>';

        if (librosDelAutor.length <= 1) {
            listaHtml += '<p style="font-size:0.78rem;color:#888;margin:0;">No hay otros libros de este autor.</p>';
        } else {
            var j = 0;
            while (j < librosDelAutor.length) {
                var idx2      = librosDelAutor[j];
                var esActual  = idx2 === indiceActual;
                var bgColor   = esActual ? '#f5f0e8' : '#fff';
                var border    = esActual ? 'border-left:3px solid #6B1C1C;' : '';
                var imgHtml   = libros[idx2].portada
                    ? '<img src="' + libros[idx2].portada + '" style="width:35px;height:50px;object-fit:cover;border-radius:4px;flex-shrink:0;">'
                    : '<div style="width:35px;height:50px;background:#6B1C1C;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;flex-shrink:0;">📚</div>';
                listaHtml +=
                    '<div onclick="cambiarLibro(' + idx2 + ')" style="display:flex;align-items:center;gap:10px;padding:6px 8px;border-radius:6px;cursor:pointer;background:' + bgColor + ';' + border + 'margin-bottom:4px;">' +
                    imgHtml +
                    '<div><div style="font-size:0.82rem;font-weight:600;color:#3d0f0f;">' + libros[idx2].titulo + '</div>' +
                    '<div style="font-size:0.75rem;color:#6B1C1C;font-weight:600;">' + libros[idx2].autor + '</div></div></div>';
                j++;
            }
        }

        var otrosCount = libros.filter(function(l) { return l.autor !== libro.autor; }).length;
        if (otrosCount > 0) {
            listaHtml += '<p style="font-size:0.78rem;color:#888;margin-top:8px;margin-bottom:0;">+ ' + otrosCount + ' libro(s) de otros autores.</p>';
        }

        var accionesHtml = '';
        if (esUsuario) {
            accionesHtml =
                '<form method="POST" action="' + carritoUrl + '">' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="libro_id" value="' + libro.id + '">' +
                '<button type="submit" style="background:#6B1C1C;color:#fff;border:none;border-radius:6px;padding:10px 20px;width:100%;font-size:1rem;">Agregar al carrito</button>' +
                '</form>';
        } else if (esAdmin) {
            accionesHtml =
                '<a href="/libros/' + libro.id + '/edit" style="background:#ffc107;color:#000;border-radius:6px;padding:10px 20px;text-decoration:none;display:inline-block;margin-right:8px;">Editar</a>' +
                '<form method="POST" action="/libros/' + libro.id + '" style="display:inline;">' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="_method" value="DELETE">' +
                '<button type="submit" style="background:#dc3545;color:#fff;border:none;border-radius:6px;padding:10px 20px;" onclick="return confirm(\'¿Eliminar?\')">Eliminar</button>' +
                '</form>';
        } else {
            accionesHtml = '<a href="' + loginUrl + '" style="background:#6B1C1C;color:#fff;border-radius:6px;padding:10px 20px;text-decoration:none;display:block;text-align:center;">Inicia sesión para comprar</a>';
        }

        document.getElementById('modalAcciones').innerHTML =
            accionesHtml +
            '<div style="max-height:180px;overflow-y:auto;margin-top:12px;">' + listaHtml + '</div>';
    }

    function cambiarLibro(idx) { indiceActual = idx; mostrarLibro(); }
    function navegarModal(dir) { indiceActual += dir; mostrarLibro(); }
</script>
</body>
</html><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verso & Tinta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --vino: #6B1C1C; --vino-dark: #3d0f0f; --vino-light: #8B2525; --crema: #f5f0e8; }
        body { background-color: var(--crema); font-family: 'Segoe UI', sans-serif; }
        .navbar-home { background-color: var(--vino-dark); border-bottom: 3px solid var(--vino); }
        .hero { background: linear-gradient(135deg, var(--vino-dark), var(--vino)); color: #fff; padding: 80px 0; }
        .hero h1 { font-family: Georgia, serif; font-size: 3rem; font-weight: 800; }
        .hero p { font-size: 1.2rem; color: #e8d5b0; }
        .btn-vino { background-color: var(--vino-light); color: #fff; border: none; padding: 12px 30px; font-size: 1rem; border-radius: 6px; }
        .btn-vino:hover { background-color: #a03030; color: #fff; }
        .section-title { color: var(--vino-dark); font-family: Georgia, serif; font-weight: 700; border-left: 4px solid var(--vino); padding-left: 12px; }
        .card-libro { background: #fff; border: none; border-radius: 10px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); transition: transform 0.2s; overflow: hidden; cursor: pointer; }
        .card-libro:hover { transform: translateY(-4px); }
        .card-libro img { width: 100%; height: 200px; object-fit: cover; }
        .card-libro .placeholder-img { width: 100%; height: 200px; background: linear-gradient(135deg, var(--vino-dark), var(--vino)); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .badge-categoria { background-color: var(--vino); color: #fff; font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; }
        .btn-carrito-nav { position: relative; color: #fff; font-size: 1.3rem; text-decoration: none; padding: 4px 10px; }
        .btn-carrito-nav:hover { color: #c9a87c; }
        footer { background-color: var(--vino-dark); color: #c9a87c; padding: 30px 0; margin-top: 60px; }
        .modal-header { background-color: var(--vino-dark); color: #fff; }
        .modal-header .btn-close { filter: invert(1); }
        .btn-nav-modal { background-color: var(--vino); color: #fff; border: none; padding: 8px 20px; border-radius: 6px; }
        .btn-nav-modal:hover { background-color: var(--vino-dark); color: #fff; }
        .btn-nav-modal:disabled { background-color: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>

@php
    $librosHome = \App\Models\Libro::with(['autor','categoria'])->latest()->take(6)->get();
    $librosData = $librosHome->map(fn($l) => [
        'id'        => $l->id,
        'titulo'    => $l->titulo,
        'autor'     => $l->autor->nombre,
        'categoria' => $l->categoria->nombre,
        'resumen'   => $l->resumen ?? '',
        'precio'    => $l->precio,
        'portada'   => $l->portada ? asset('storage/'.$l->portada) : null,
    ])->values()->toArray();
    $esUsuario   = auth()->check() && auth()->user()->hasRole('usuario');
    $esAdmin     = auth()->check() && auth()->user()->hasRole('admin');
    $csrfToken   = csrf_token();
    $carritoRuta = $esUsuario ? url('/carrito/agregar') : '';
    $loginRuta   = url('/login');
@endphp

<nav class="navbar navbar-expand-sm navbar-home py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <div>
                <span style="display:block;font-size:1rem;font-weight:800;color:#fff;font-family:Georgia,serif;line-height:1">VERSO & TINTA</span>
                <span style="display:block;font-size:0.6rem;color:#c9a87c;letter-spacing:2px">LIBRERÍA LITERARIA</span>
            </div>
        </a>
        <div class="ms-auto d-flex align-items-center gap-2">
            @auth
                @if(auth()->user()->hasRole('usuario'))
                    <a href="{{ route('carrito.index') }}" class="btn-carrito-nav">
                        🛒
                        @php $cant = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad'); @endphp
                        @if($cant > 0)
                            <span style="position:absolute;top:0;right:0;background:#e74c3c;color:#fff;border-radius:50%;width:16px;height:16px;font-size:0.6rem;display:flex;align-items:center;justify-content:center;font-weight:700;">{{ $cant }}</span>
                        @endif
                    </a>
                @elseif(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-sm btn-outline-light px-3">📦 Pedidos</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-sm btn-outline-light px-3">Salir</button>
                </form>
            @else
                <a href="{{ url('/login') }}?redirect={{ urlencode(url('/carrito')) }}" class="btn-carrito-nav">🛒</a>
                <a href="{{ url('/login') }}" class="btn btn-sm btn-outline-light px-3">Iniciar Sesión</a>
                <a href="{{ url('/register') }}" class="btn btn-sm btn-vino px-3">Registrarse</a>
            @endauth
        </div>
    </div>
</nav>

<section class="hero text-center">
    <div class="container">
        <h1>Verso & Tinta</h1>
        <p class="mb-4">Tu librería literaria — descubre, explora y gestiona el mundo de los libros</p>
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ url('/libros') }}" class="btn btn-vino me-2">Panel Admin</a>
            @else
                <a href="{{ url('/usuario/catalogo-libros') }}" class="btn btn-vino me-2">Ver Catálogo</a>
            @endif
        @else
            <a href="{{ url('/login') }}" class="btn btn-vino me-2">Acceder a la librería completa</a>
        @endauth
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">📚</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Gestión de Libros</h5>
                <p class="text-muted">Registra y administra tu colección completa con portadas, resúmenes y autores.</p>
            </div>
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">✍️</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Autores</h5>
                <p class="text-muted">Mantén un registro detallado de todos los autores y su bibliografía.</p>
            </div>
            <div class="col-md-4">
                <div style="font-size:2.5rem;margin-bottom:15px">🏷️</div>
                <h5 style="color:var(--vino-dark);font-weight:700">Categorías</h5>
                <p class="text-muted">Organiza los libros por géneros y categorías para una búsqueda más fácil.</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" id="catalogo" style="background:#fff">
    <div class="container">
        <h2 class="section-title mb-4">Catálogo de Libros</h2>
        <div class="row g-4">
            @php $idx = 0; @endphp
            @forelse($librosHome as $libro)
            <div class="col-sm-6 col-lg-4">
                <div class="card-libro h-100" data-idx="{{ $idx }}">
                    @if($libro->portada)
                        <img src="{{ asset('storage/'.$libro->portada) }}" alt="{{ $libro->titulo }}">
                    @else
                        <div class="placeholder-img">📚</div>
                    @endif
                    <div class="p-3">
                        <span class="badge-categoria mb-2 d-inline-block">{{ $libro->categoria->nombre }}</span>
                        <h6 class="fw-bold mb-1">{{ $libro->titulo }}</h6>
                        <p class="small mb-1" style="color:var(--vino)">{{ $libro->autor->nombre }}</p>
                        <p class="text-muted small mb-2">{{ Str::limit($libro->resumen, 80) }}</p>
                        <p class="fw-bold mb-0" style="color:var(--vino)">S/ {{ number_format($libro->precio, 2) }}</p>
                    </div>
                </div>
            </div>
            @php $idx++; @endphp
            @empty
            <div class="col-12 text-center text-muted py-5">
                <p>No hay libros registrados aún.</p>
                <a href="{{ url('/login') }}" class="btn btn-vino">Iniciar sesión para agregar</a>
            </div>
            @endforelse
        </div>
    </div>
</section>

<div class="modal fade" id="modalLibro" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-5 text-center">
                        <img id="modalPortada" src="" style="width:100%;max-height:300px;object-fit:cover;border-radius:8px;">
                    </div>
                    <div class="col-md-7">
                        <span id="modalCategoria" class="badge mb-2" style="background:#6B1C1C;color:#fff;"></span>
                        <h4 id="modalTituloDetalle" style="color:#3d0f0f;font-family:Georgia,serif;"></h4>
                        <p id="modalAutor" style="color:#6B1C1C;font-weight:600;"></p>
                        <h5 id="modalPrecio" style="color:#6B1C1C;font-weight:700;" class="mb-3"></h5>
                        <p id="modalResumen" class="text-muted small mb-3"></p>
                        <div id="modalAcciones"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn-nav-modal" id="btnAnterior" onclick="navegarModal(-1)">← Anterior</button>
                <span id="modalPosicion" class="text-muted small"></span>
                <button class="btn-nav-modal" id="btnSiguiente" onclick="navegarModal(1)">Siguiente →</button>
            </div>
        </div>
    </div>
</div>

<footer class="text-center">
    <p class="mb-1" style="font-family:Georgia,serif;font-size:1.1rem">Verso & Tinta</p>
    <small>© {{ date('Y') }} — Todos los derechos reservados</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php
/**
 * @var array  $librosData
 * @var bool   $esUsuario
 * @var bool   $esAdmin
 * @var string $csrfToken
 * @var string $carritoRuta
 * @var string $loginRuta
 */
?>
<script>
    var libros       = <?php echo json_encode($librosData); ?>;
    var esUsuario    = <?php echo $esUsuario ? 'true' : 'false'; ?>;
    var esAdmin      = <?php echo $esAdmin ? 'true' : 'false'; ?>;
    var csrfToken    = '<?php echo $csrfToken; ?>';
    var carritoUrl   = '<?php echo $carritoRuta; ?>';
    var loginUrl     = '<?php echo $loginRuta; ?>';
    var indiceActual = 0;
    var modal        = new bootstrap.Modal(document.getElementById('modalLibro'));

    document.querySelectorAll('.card-libro').forEach(function(card) {
        card.addEventListener('click', function() {
            abrirModal(parseInt(this.getAttribute('data-idx')));
        });
    });

    function abrirModal(idx) {
        indiceActual = idx;
        mostrarLibro();
        modal.show();
    }

    function mostrarLibro() {
        var libro = libros[indiceActual];

        document.getElementById('modalTitulo').textContent       = libro.titulo;
        document.getElementById('modalTituloDetalle').textContent = libro.titulo;
        document.getElementById('modalAutor').textContent         = libro.autor;
        document.getElementById('modalCategoria').textContent     = libro.categoria;
        document.getElementById('modalPrecio').textContent        = 'S/ ' + parseFloat(libro.precio).toFixed(2);
        document.getElementById('modalResumen').textContent       = libro.resumen || '';
        document.getElementById('modalPosicion').textContent      = (indiceActual + 1) + ' / ' + libros.length;

        var portadaEl = document.getElementById('modalPortada');
        portadaEl.style.display = libro.portada ? 'block' : 'none';
        if (libro.portada) portadaEl.src = libro.portada;

        document.getElementById('btnAnterior').disabled = indiceActual === 0;
        document.getElementById('btnSiguiente').disabled = indiceActual === libros.length - 1;

        var librosDelAutor = [];
        var i = 0;
        while (i < libros.length) {
            if (libros[i].autor === libro.autor) librosDelAutor.push(i);
            i++;
        }

        var listaHtml = '<p style="font-size:0.82rem;font-weight:600;color:#3d0f0f;margin-bottom:8px;">Más libros de ' + libro.autor + ':</p>';

        if (librosDelAutor.length <= 1) {
            listaHtml += '<p style="font-size:0.78rem;color:#888;margin:0;">No hay otros libros de este autor.</p>';
        } else {
            var j = 0;
            while (j < librosDelAutor.length) {
                var idx2      = librosDelAutor[j];
                var esActual  = idx2 === indiceActual;
                var bgColor   = esActual ? '#f5f0e8' : '#fff';
                var border    = esActual ? 'border-left:3px solid #6B1C1C;' : '';
                var imgHtml   = libros[idx2].portada
                    ? '<img src="' + libros[idx2].portada + '" style="width:35px;height:50px;object-fit:cover;border-radius:4px;flex-shrink:0;">'
                    : '<div style="width:35px;height:50px;background:#6B1C1C;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;flex-shrink:0;">📚</div>';
                listaHtml +=
                    '<div onclick="cambiarLibro(' + idx2 + ')" style="display:flex;align-items:center;gap:10px;padding:6px 8px;border-radius:6px;cursor:pointer;background:' + bgColor + ';' + border + 'margin-bottom:4px;">' +
                    imgHtml +
                    '<div><div style="font-size:0.82rem;font-weight:600;color:#3d0f0f;">' + libros[idx2].titulo + '</div>' +
                    '<div style="font-size:0.75rem;color:#6B1C1C;font-weight:600;">' + libros[idx2].autor + '</div></div></div>';
                j++;
            }
        }

        var otrosCount = libros.filter(function(l) { return l.autor !== libro.autor; }).length;
        if (otrosCount > 0) {
            listaHtml += '<p style="font-size:0.78rem;color:#888;margin-top:8px;margin-bottom:0;">+ ' + otrosCount + ' libro(s) de otros autores.</p>';
        }

        var accionesHtml = '';
        if (esUsuario) {
            accionesHtml =
                '<form method="POST" action="' + carritoUrl + '">' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="libro_id" value="' + libro.id + '">' +
                '<button type="submit" style="background:#6B1C1C;color:#fff;border:none;border-radius:6px;padding:10px 20px;width:100%;font-size:1rem;">Agregar al carrito</button>' +
                '</form>';
        } else if (esAdmin) {
            accionesHtml =
                '<a href="/libros/' + libro.id + '/edit" style="background:#ffc107;color:#000;border-radius:6px;padding:10px 20px;text-decoration:none;display:inline-block;margin-right:8px;">Editar</a>' +
                '<form method="POST" action="/libros/' + libro.id + '" style="display:inline;">' +
                '<input type="hidden" name="_token" value="' + csrfToken + '">' +
                '<input type="hidden" name="_method" value="DELETE">' +
                '<button type="submit" style="background:#dc3545;color:#fff;border:none;border-radius:6px;padding:10px 20px;" onclick="return confirm(\'¿Eliminar?\')">Eliminar</button>' +
                '</form>';
        } else {
            accionesHtml = '<a href="' + loginUrl + '" style="background:#6B1C1C;color:#fff;border-radius:6px;padding:10px 20px;text-decoration:none;display:block;text-align:center;">Inicia sesión para comprar</a>';
        }

        document.getElementById('modalAcciones').innerHTML =
            accionesHtml +
            '<div style="max-height:180px;overflow-y:auto;margin-top:12px;">' + listaHtml + '</div>';
    }

    function cambiarLibro(idx) { indiceActual = idx; mostrarLibro(); }
    function navegarModal(dir) { indiceActual += dir; mostrarLibro(); }
</script>
</body>
</html>