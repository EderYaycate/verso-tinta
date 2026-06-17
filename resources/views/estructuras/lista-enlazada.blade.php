@extends('layouts.admin')
@section('content')

<h2 class="page-title mb-1">Catálogo de Libros</h2>
<div class="page-title-line mb-4"></div>
<p class="text-muted mb-1">Lista Enlazada — Libro {{ $actual['posicion'] }} de {{ $actual['total'] }}</p>

<div class="row g-4">
    {{-- Libro actual --}}
    <div class="col-lg-5">
        <div class="card-custom overflow-hidden">
            @if($actual['dato']['portada'])
                <img src="{{ asset('storage/'.$actual['dato']['portada']) }}" class="portada-img">
            @else
                <div class="portada-placeholder">📚</div>
            @endif
            <div class="p-4">
                <span class="badge badge-vino rounded-pill mb-2">{{ $actual['dato']['categoria'] }}</span>
                <h4 class="fw-bold mb-1" style="color:var(--vino-dark);font-family:Georgia,serif;">{{ $actual['dato']['titulo'] }}</h4>
                <p class="mb-2" style="color:var(--vino)">{{ $actual['dato']['autor'] }}</p>
                <p class="fw-bold mb-3" style="color:var(--vino);font-size:1.2rem;">S/ {{ number_format($actual['dato']['precio'], 2) }}</p>
                @if($actual['dato']['resumen'])
                    <p class="text-muted small mb-3">{{ $actual['dato']['resumen'] }}</p>
                @endif

                {{-- Acciones admin --}}
                <div class="d-flex gap-2">
                    <a href="{{ route('libros.edit', $actual['dato']['id']) }}"
                        class="btn btn-warning btn-sm">Editar</a>
                    <form method="POST" action="{{ route('libros.destroy', $actual['dato']['id']) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Eliminar este libro?')">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Navegación --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            @if($actual['anterior'])
                <a href="{{ route('estructuras.lista', $actual['anterior']) }}"
                    class="btn btn-vino">← Anterior</a>
            @else
                <span class="btn btn-secondary disabled">← Anterior</span>
            @endif

            <span class="text-muted small">{{ $actual['posicion'] }} / {{ $actual['total'] }}</span>

            @if($actual['siguiente'])
                <a href="{{ route('estructuras.lista', $actual['siguiente']) }}"
                    class="btn btn-vino">Siguiente →</a>
            @else
                <span class="btn btn-secondary disabled">Siguiente →</span>
            @endif
        </div>
    </div>

    {{-- Lista de todos los libros --}}
    <div class="col-lg-7">
        <div class="card-custom p-3" style="max-height:600px;overflow-y:auto;">
            <h6 class="fw-bold mb-3" style="color:var(--vino-dark)">Todos los libros</h6>
            @php $i = 0; @endphp
            @while($i < count($navegacion))
            <a href="{{ route('estructuras.lista', $navegacion[$i]['dato']['id']) }}"
                class="d-flex align-items-center gap-3 p-2 rounded mb-1 text-decoration-none"
                style="{{ $navegacion[$i]['dato']['id'] == $actual['dato']['id'] ? 'background:var(--crema);border-left:3px solid var(--vino);' : '' }}">
                <span class="count-badge">{{ $navegacion[$i]['posicion'] }}</span>
                @if($navegacion[$i]['dato']['portada'])
                    <img src="{{ asset('storage/'.$navegacion[$i]['dato']['portada']) }}"
                        style="width:40px;height:55px;object-fit:cover;border-radius:4px;">
                @else
                    <div style="width:40px;height:55px;background:var(--vino);border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;">📚</div>
                @endif
                <div>
                    <div class="fw-semibold small" style="color:var(--vino-dark)">{{ $navegacion[$i]['dato']['titulo'] }}</div>
                    <div class="small text-muted">{{ $navegacion[$i]['dato']['autor'] }}</div>
                </div>
            </a>
            @php $i++; @endphp
            @endwhile
        </div>
    </div>
</div>

@endsection