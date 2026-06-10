@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Tabla Hash - Busqueda por ID</h2>
</div>
<p class="text-muted mb-4">Estructura de acceso directo - Busqueda rapida de libros mediante funcion hash aplicada al ID.</p>

<div class="card-custom overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="px-4 py-3">Indice Hash</th>
                <th class="px-4 py-3">ID Libro</th>
                <th class="px-4 py-3">Titulo</th>
                <th class="px-4 py-3">Autor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($elementos as $elemento)
            <tr>
                <td class="px-4 py-3">
                    <span class="badge badge-vino rounded-pill">{{ $elemento['indice'] }}</span>
                </td>
                <td class="px-4 py-3">{{ $elemento['clave'] }}</td>
                <td class="px-4 py-3 fw-semibold">{{ $elemento['dato']['titulo'] }}</td>
                <td class="px-4 py-3">{{ $elemento['dato']['autor'] }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-4 text-muted">No hay libros en la tabla hash.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection