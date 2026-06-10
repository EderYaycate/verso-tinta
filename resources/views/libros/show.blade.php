@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card-custom p-4">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    @if($libro->portada)
                        <img src="{{ asset('storage/'.$libro->portada) }}" style="width:100%;max-width:200px;height:280px;object-fit:cover;border-radius:10px;box-shadow:0 4px 15px rgba(0,0,0,0.2)">
                    @else
                        <div style="width:100%;max-width:200px;height:280px;background:linear-gradient(135deg,#3d0f0f,#6B1C1C);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:4rem;margin:auto">📖</div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h2 class="page-title mb-2">{{ $libro->titulo }}</h2>
                    <p class="mb-1"><span class="fw-semibold">Autor:</span> {{ $libro->autor->nombre }}</p>
                    <p class="mb-1"><span class="fw-semibold">Nacionalidad:</span> {{ $libro->autor->nacionalidad }}</p>
                    <p class="mb-3"><span class="fw-semibold">Categoría:</span> {{ $libro->categoria->nombre }}</p>
                    <hr>
                    <h6 class="fw-bold">Resumen</h6>
                    <p class="text-muted">{{ $libro->resumen }}</p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('libros.edit', $libro) }}" class="btn btn-warning">Editar</a>
                        <a href="{{ route('libros.index') }}" class="btn btn-secondary">← Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection