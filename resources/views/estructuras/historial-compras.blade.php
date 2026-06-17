@extends('layouts.admin')
@section('content')

<h2 class="page-title mb-1">Historial de Compras</h2>
<div class="page-title-line mb-4"></div>
<p class="text-muted mb-4">Estadísticas de ventas agrupadas por día.</p>

@if(count($elementos) == 0)
    <div class="card-custom p-5 text-center text-muted">
        <div style="font-size:3rem">📊</div>
        <p class="mt-3">No hay compras registradas aún.</p>
    </div>
@else
    <div class="row g-4">
        @php $i = 0; @endphp
        @while($i < count($elementos))
        <div class="col-md-6">
            <div class="card-custom p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span style="background:var(--vino);color:#fff;padding:4px 14px;border-radius:20px;font-size:0.85rem;font-weight:600;">
                        📅 {{ $elementos[$i]['fecha'] }}
                    </span>
                    <span class="badge bg-secondary">{{ $elementos[$i]['pedidos'] }} pedido(s)</span>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <div style="background:var(--crema);border-radius:8px;padding:12px;">
                            <p class="small text-muted mb-1">Total recaudado</p>
                            <h5 class="fw-bold mb-0" style="color:var(--vino)">S/ {{ number_format($elementos[$i]['total'], 2) }}</h5>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:var(--crema);border-radius:8px;padding:12px;">
                            <p class="small text-muted mb-1">Libro más vendido</p>
                            <p class="fw-semibold mb-0 small" style="color:var(--vino-dark)">📖 {{ $elementos[$i]['mas_vendido'] }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="small text-muted mb-2 fw-semibold">Detalle de libros vendidos:</p>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th class="px-2 py-2">Libro</th>
                                    <th class="px-2 py-2 text-end">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $libros = $elementos[$i]['libros'];
                                    $titulos = array_keys($libros);
                                    $k = 0;
                                @endphp
                                @while($k < count($titulos))
                                <tr>
                                    <td class="px-2 py-2 small">{{ $titulos[$k] }}</td>
                                    <td class="px-2 py-2 text-end">
                                        <span class="badge badge-vino">{{ $libros[$titulos[$k]] }}</span>
                                    </td>
                                </tr>
                                @php $k++; @endphp
                                @endwhile
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @php $i++; @endphp
        @endwhile
    </div>
@endif

@endsection