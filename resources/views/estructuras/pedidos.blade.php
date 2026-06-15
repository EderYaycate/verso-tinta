@extends('layouts.admin')
@section('content')

<h2 class="page-title mb-1">Pedidos</h2>
<div class="page-title-line mb-4"></div>

<div class="card-custom">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3">Libros</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                <tr>
                    <td class="px-4 py-3">{{ $pedido->id }}</td>
                    <td class="px-4 py-3">{{ $pedido->user->name }}</td>
                    <td class="px-4 py-3">{{ $pedido->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $pedido->items->count() }}</td>
                    <td class="px-4 py-3 fw-bold" style="color:var(--vino)">S/ {{ number_format($pedido->total, 2) }}</td>
                    <td class="px-4 py-3">
                        @php
                            $colores = [
                                'pendiente'  => 'warning',
                                'confirmado' => 'info',
                                'enviado'    => 'primary',
                                'entregado'  => 'success',
                            ];
                        @endphp
                        <span class="badge bg-{{ $colores[$pedido->estado] }}">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <form method="POST" action="{{ route('admin.pedidos.actualizar', $pedido) }}">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex gap-2">
                                <select name="estado" class="form-select form-select-sm">
                                    <option value="pendiente"  {{ $pedido->estado == 'pendiente'  ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $pedido->estado == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="enviado"    {{ $pedido->estado == 'enviado'    ? 'selected' : '' }}>Enviado</option>
                                    <option value="entregado"  {{ $pedido->estado == 'entregado'  ? 'selected' : '' }}>Entregado</option>
                                </select>
                                <button class="btn btn-sm btn-vino">OK</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">No hay pedidos aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection