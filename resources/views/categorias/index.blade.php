@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Categorías</h2>
    <a href="{{ route('categorias.create') }}" class="btn btn-vino px-4">+ Nueva Categoría</a>
</div>
<div class="card-custom overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Descripción</th>
                <th class="px-4 py-3">Libros</th>
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
            <tr>
                <td class="px-4 py-3 text-muted">{{ $categoria->id }}</td>
                <td class="px-4 py-3 fw-semibold">{{ $categoria->nombre }}</td>
                <td class="px-4 py-3">{{ Str::limit($categoria->descripcion, 60) }}</td>
                <td class="px-4 py-3">
                    <span class="badge badge-vino rounded-pill">{{ $categoria->libros_count }}</span>
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('categorias.show', $categoria) }}" class="btn btn-sm btn-outline-secondary me-1">Ver</a>
                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar categoría?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-5">No hay categorías registradas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection