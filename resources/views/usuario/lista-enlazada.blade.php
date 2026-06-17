@extends('layouts.usuario')
@section('content')

<h2 class="page-title mb-1">Catálogo de Libros</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>

{{-- Filtros --}}
<div class="card-custom p-4 mb-4">
    <form method="GET" action="{{ route('usuario.lista') }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Buscar por título</label>
                <input type="text" name="buscar" class="form-control"
                    placeholder="Ej: Cien años..."
                    value="{{ request('buscar') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Filtrar por categoría</label>
                <select name="categoria_id" class="form-select">
                    <option value="">Todas las categorías</option>
                    @php $ci = 0; @endphp
                    @while($ci < count($categorias))
                        <option value="{{ $categorias[$ci]->id }}" {{ request('categoria_id') == $categorias[$ci]->id ? 'selected' : '' }}>
                            {{ $categorias[$ci]->nombre }}
                        </option>
                    @php $ci++; @endphp
                    @endwhile
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Filtrar por autor</label>
                <select name="autor_id" class="form-select">
                    <option value="">Todos los autores</option>
                    @php $ai = 0; @endphp
                    @while($ai < count($autores))
                        <option value="{{ $autores[$ai]->id }}" {{ request('autor_id') == $autores[$ai]->id ? 'selected' : '' }}>
                            {{ $autores[$ai]->nombre }}
                        </option>
                    @php $ai++; @endphp
                    @endwhile
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-vino w-100">Buscar</button>
                <a href="{{ route('usuario.lista') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
            </div>
        </div>
    </form>
</div>

<p class="mb-3 text-muted">Mostrando <strong style="color:var(--vino-dark)">{{ count($navegacion) }}</strong> libro(s)</p>

<style>
    .libro-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .libro-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(107,28,28,0.15);
    }
    .libro-portada { width: 100%; height: 220px; object-fit: cover; }
    .libro-placeholder {
        width: 100%; height: 220px;
        background: linear-gradient(160deg, var(--vino-dark) 0%, var(--vino) 100%);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,0.2); font-size: 4rem;
    }
    .libro-badge {
        position: absolute; top: 10px; left: 10px;
        background-color: var(--vino); color: #fff;
        font-size: 0.7rem; font-weight: 600;
        padding: 3px 10px; border-radius: 4px;
        letter-spacing: 0.5px; text-transform: uppercase;
    }
    .libro-info {
        padding: 12px 10px 16px;
        text-align: center;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .libro-titulo {
        font-size: 0.88rem; font-weight: 700;
        color: var(--vino-dark); font-family: Georgia, serif;
        line-height: 1.3; margin-bottom: 4px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .libro-autor { font-size: 0.78rem; color: #888; margin-bottom: 6px; }
    .libro-precio { font-size: 1rem; font-weight: 700; color: var(--vino); margin-bottom: 10px; }
    .btn-carrito {
        background-color: var(--vino); color: #fff;
        border: none; border-radius: 6px;
        font-size: 0.8rem; padding: 6px 12px;
        width: 100%; transition: background 0.2s;
    }
    .btn-carrito:hover { background-color: var(--vino-dark); color: #fff; }
    @media (min-width: 1200px) { .col-xl-2-4 { width: 20%; } }
</style>

<div class="row g-3">
    @php $i = 0; @endphp
    @while($i < count($navegacion))
    <div class="col-6 col-sm-4 col-md-3 col-xl-2-4">
        <div class="libro-card">
            <div style="position:relative;">
                @if($navegacion[$i]['dato']['portada'])
                    <img src="{{ asset('storage/'.$navegacion[$i]['dato']['portada']) }}" class="libro-portada">
                @else
                    <div class="libro-placeholder">&#128218;</div>
                @endif
                <span class="libro-badge">{{ $navegacion[$i]['dato']['categoria'] }}</span>
            </div>
            <div class="libro-info">
                <div>
                    <div class="libro-titulo">{{ $navegacion[$i]['dato']['titulo'] }}</div>
                    <p class="libro-autor">{{ $navegacion[$i]['dato']['autor'] }}</p>
                </div>
                <div>
                    <p class="libro-precio">S/ {{ number_format($navegacion[$i]['dato']['precio'], 2) }}</p>
                    <form method="POST" action="{{ route('carrito.agregar') }}">
                        @csrf
                        <input type="hidden" name="libro_id" value="{{ $navegacion[$i]['dato']['id'] }}">
                        <button type="submit" class="btn-carrito">🛒 Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @php $i++; @endphp
    @endwhile
</div>

@endsection