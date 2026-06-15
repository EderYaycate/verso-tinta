@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Autores</h2>
    <a href="{{ route('autores.create') }}" class="btn btn-vino px-4">+ Nuevo Autor</a>
</div>
<div class="card-custom overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Nombre</th>
                <th class="px-4 py-3">Nacionalidad</th>
                <th class="px-4 py-3">Libros</th>
                <th class="px-4 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($autores as $autor)
            <tr>
                <td class="px-4 py-3 text-muted">{{ $autor->id }}</td>
                <td class="px-4 py-3 fw-semibold">{{ $autor->nombre }}</td>
                <td class="px-4 py-3">🌍 {{ $autor->nacionalidad }}</td>
                <td class="px-4 py-3">
                    <span class="badge badge-vino rounded-pill">{{ $autor->libros_count }}</span>
                </td>
                <td class="px-4 py-3">
                    <a href="{{ route('autores.show', $autor) }}" class="btn btn-sm btn-outline-secondary me-1">Ver</a>
                    <a href="{{ route('autores.edit', $autor) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                    <form action="{{ route('autores.destroy', $autor) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar autor?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-5">No hay autores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection