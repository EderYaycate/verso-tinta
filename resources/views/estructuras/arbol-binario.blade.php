@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Arbol Binario - Busqueda de Libros</h2>
</div>
<p class="text-muted mb-4">Arbol binario de busqueda - Los libros se ordenan alfabeticamente por titulo.</p>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Recorrido Inorden</h5>
            <p class="text-muted small mb-3">Izquierda - Raiz - Derecha (orden alfabetico)</p>
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inorden as $i => $elemento)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $elemento['titulo'] }}</td>
                        <td>{{ $elemento['autor'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Sin datos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Recorrido Preorden</h5>
            <p class="text-muted small mb-3">Raiz - Izquierda - Derecha</p>
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($preorden as $i => $elemento)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $elemento['titulo'] }}</td>
                        <td>{{ $elemento['autor'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Sin datos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Recorrido Postorden</h5>
            <p class="text-muted small mb-3">Izquierda - Derecha - Raiz</p>
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($postorden as $i => $elemento)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $elemento['titulo'] }}</td>
                        <td>{{ $elemento['autor'] }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Sin datos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection