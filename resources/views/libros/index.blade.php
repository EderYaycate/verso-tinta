@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Libros</h2>
    <a href="{{ route('libros.create') }}" class="btn btn-vino px-4">+ Nuevo Libro</a>
</div>
<div class="row g-4">
    @forelse($libros as $libro)
    <div class="col-sm-6 col-lg-4">
        <div class="card-custom h-100">
            @if($libro->portada)
                <div style="width:100%;height:220px;background:#f5f0e8;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                    <img src="{{ asset('storage/'.$libro->portada) }}"
                        style="width:100%;height:220px;object-fit:contain;">
                </div>
            @else
                <div class="portada-placeholder"></div>
            @endif
            <div class="p-3">
                <h5 class="fw-bold mb-1">{{ $libro->titulo }}</h5>
                <p class="small mb-1" style="color: var(--vino)"> {{ $libro->autor->nombre }}</p>
                <p class="small mb-2 text-muted"> {{ $libro->categoria->nombre }}</p>
                <p class="text-muted small mb-3">{{ Str::limit($libro->resumen, 80) }}</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('libros.show', $libro) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                    <a href="{{ route('libros.edit', $libro) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('libros.destroy', $libro) }}" method="POST" onsubmit="return confirm('¿Eliminar libro?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">No hay libros registrados.</div>
    @endforelse
</div>
@endsection