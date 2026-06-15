@extends('layouts.usuario')
@section('content')

<div class="d-flex align-items-center gap-3 mb-1">
    <a href="{{ route('pedidos.historial') }}" class="btn btn-sm btn-outline-secondary">← Volver</a>
    <h2 class="page-title mb-0">Pedido #{{ $pedido->id }}</h2>
</div>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);margin-left:90px;"></div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card-custom p-4 mb-4">
            <h5 class="fw-bold mb-3" style="color:var(--vino-dark)">Libros</h5>
            @foreach($pedido->items as $item)
            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                @if($item->libro->portada)
                    <img src="{{ asset('storage/'.$item->libro->portada) }}"
                        style="width:60px;height:80px;object-fit:cover;border-radius:6px;">
                @else
                    <div style="width:60px;height:80px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));border-radius:6px;"></div>
                @endif
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1" style="color:var(--vino-dark)">{{ $item->libro->titulo }}</h6>
                    <p class="small text-muted mb-0">{{ $item->libro->autor->nombre }}</p>
                </div>
                <div class="text-end">
                    <p class="small text-muted mb-0">{{ $item->cantidad }} x S/ {{ number_format($item->precio, 2) }}</p>
                    <p class="fw-bold mb-0" style="color:var(--vino)">S/ {{ number_format($item->precio * $item->cantidad, 2) }}</p>
                </div>
            </div>
            @endforeach
            <div class="d-flex justify-content-end mt-3">
                <div class="text-end">
                    <p class="text-muted mb-1">Total del pedido</p>
                    <h4 class="fw-bold" style="color:var(--vino)">S/ {{ number_format($pedido->total, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card-custom p-4">
            <h5 class="fw-bold mb-3" style="color:var(--vino-dark)">Datos de Entrega</h5>
            <p class="small text-muted mb-1">Dirección</p>
            <p class="fw-semibold mb-3">{{ $pedido->direccion }}</p>
            @if($pedido->referencia)
                <p class="small text-muted mb-1">Referencia</p>
                <p class="fw-semibold mb-3">{{ $pedido->referencia }}</p>
            @endif
            <p class="small text-muted mb-1">Teléfono</p>
            <p class="fw-semibold mb-3">{{ $pedido->telefono }}</p>
            <p class="small text-muted mb-1">Estado</p>
            @php
                $colores = [
                    'pendiente'  => 'warning',
                    'confirmado' => 'info',
                    'enviado'    => 'primary',
                    'entregado'  => 'success',
                ];
            @endphp
            <span class="badge bg-{{ $colores[$pedido->estado] }} fs-6">
                {{ ucfirst($pedido->estado) }}
            </span>
            <p class="small text-muted mt-3 mb-0">Fecha del pedido</p>
            <p class="fw-semibold">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</div>

@endsection