@extends('layouts.admin')
@section('content')

<div class="card-custom overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Titulo</th>
                <th class="px-4 py-3">Autor</th>
                <th class="px-4 py-3">Categoria</th>
            </tr>
        </thead>
        <tbody>
            @forelse($elementos as $i => $elemento)
            <tr>
                <td class="px-4 py-3">{{ $i + 1 }}</td>
                <td class="px-4 py-3 fw-semibold">{{ $elemento['titulo'] }}</td>
                <td class="px-4 py-3">{{ $elemento['autor'] }}</td>
                <td class="px-4 py-3">{{ $elemento['categoria'] }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center py-4 text-muted">No hay libros registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection