@extends('layouts.usuario')
@section('content')

<h2 class="page-title mb-1">Mis Pedidos</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>

@if($pedidos->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem;">📦</div>
        <h5 class="mt-3 text-muted">Aún no tienes pedidos</h5>
        <a href="{{ route('usuario.lista') }}" class="btn btn-vino mt-3">Ver Catálogo</a>
    </div>
@else
    <div class="card-custom">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Libros</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                    <tr>
                        <td class="px-4 py-3">{{ $pedido->id }}</td>
                        <td class="px-4 py-3">{{ $pedido->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">{{ $pedido->items->count() }} libro(s)</td>
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
                            <a href="{{ route('pedidos.show', $pedido) }}"
                                class="btn btn-sm btn-outline-secondary">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection