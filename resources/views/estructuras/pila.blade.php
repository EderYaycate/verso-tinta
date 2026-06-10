@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Pila - Historial de Libros</h2>
</div>
<p class="text-muted mb-4">Estructura LIFO - El ultimo libro agregado es el primero en mostrarse.</p>

<div class="card-custom overflow-hidden">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="px-4 py-3">Posicion</th>
                <th class="px-4 py-3">Titulo</th>
                <th class="px-4 py-3">Autor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($elementos as $i => $elemento)
            <tr>
                <td class="px-4 py-3">
                    @if($i === 0)
                        <span class="badge badge-vino rounded-pill">Tope</span>
                    @else
                        {{ $i + 1 }}
                    @endif
                </td>
                <td class="px-4 py-3 fw-semibold">{{ $elemento['titulo'] }}</td>
                <td class="px-4 py-3">{{ $elemento['autor'] }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center py-4 text-muted">No hay libros en la pila.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection