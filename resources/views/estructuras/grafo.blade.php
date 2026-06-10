@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Relacion de Autores</h2>
</div>
<p class="text-muted mb-4">Grafo no dirigido - Autores conectados por compartir la misma categoria de libros.</p>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Vertices - Autores</h5>
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vertices as $i => $vertice)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $vertice }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="text-center text-muted">Sin autores registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Aristas - Relaciones entre Autores</h5>
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Autor</th>
                        <th>Conectado con</th>
                        <th>Categoria compartida</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aristas as $autor => $conexiones)
                        @if(count($conexiones) > 0)
                            @foreach($conexiones as $conexion)
                            <tr>
                                <td class="fw-semibold">{{ $autor }}</td>
                                <td>{{ $conexion['destino'] }}</td>
                                <td>
                                    <span class="badge badge-vino rounded-pill">{{ $conexion['categoria'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No hay relaciones entre autores.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection