@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-custom p-4">
            <h2 class="page-title mb-2">{{ $autor->nombre }}</h2>
            <p class="text-muted mb-4">🌍 {{ $autor->nacionalidad }}</p>
            <h5 class="fw-bold mb-3" style="color: var(--vino)">Libros de este autor</h5>
            @forelse($autor->libros as $libro)
            <div class="d-flex align-items-center gap-3 border rounded p-3 mb-3">
                @if($libro->portada)
                    <img src="{{ asset('storage/'.$libro->portada) }}" style="width:50px;height:70px;object-fit:cover;border-radius:6px;">
                @else
                    <div style="width:50px;height:70px;background:#6B1C1C;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff">📖</div>
                @endif
                <div>
                    <p class="fw-semibold mb-0">{{ $libro->titulo }}</p>
                    <p class="text-muted small mb-0">{{ Str::limit($libro->resumen, 80) }}</p>
                </div>
            </div>
            @empty
            <p class="text-muted">Este autor no tiene libros registrados.</p>
            @endforelse
            <a href="{{ route('autores.index') }}" class="btn btn-secondary mt-3">← Volver</a>
        </div>
    </div>
</div>
@endsection