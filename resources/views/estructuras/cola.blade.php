@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Cola - Solicitudes de Libros</h2>
</div>
<p class="text-muted mb-4">Estructura FIFO - El primer libro agregado es el primero en atenderse.</p>

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
                        <span class="badge badge-vino rounded-pill">Frente</span>
                    @elseif($i === count($elementos) - 1)
                        <span class="badge bg-secondary rounded-pill">Final</span>
                    @else
                        {{ $i + 1 }}
                    @endif
                </td>
                <td class="px-4 py-3 fw-semibold">{{ $elemento['titulo'] }}</td>
                <td class="px-4 py-3">{{ $elemento['autor'] }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="text-center py-4 text-muted">No hay libros en la cola.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection