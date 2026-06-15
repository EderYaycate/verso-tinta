@extends('layouts.usuario')
@section('content')

<h2 class="page-title mb-1">Mi Carrito</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>

@if($items->isEmpty())
    <div class="text-center py-5">
        <div style="font-size:4rem;">🛒</div>
        <h5 class="mt-3 text-muted">Tu carrito está vacío</h5>
        <a href="{{ route('usuario.lista') }}" class="btn btn-vino mt-3">Ver Catálogo</a>
    </div>
@else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-custom p-4">
                @foreach($items as $item)
                <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    @if($item->libro->portada)
                        <img src="{{ asset('storage/'.$item->libro->portada) }}"
                            style="width:70px;height:90px;object-fit:cover;border-radius:6px;">
                    @else
                        <div style="width:70px;height:90px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));border-radius:6px;"></div>
                    @endif
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1" style="color:var(--vino-dark)">{{ $item->libro->titulo }}</h6>
                        <p class="small text-muted mb-1">{{ $item->libro->autor->nombre }}</p>
                        <p class="fw-bold mb-0" style="color:var(--vino)">S/ {{ number_format($item->libro->precio, 2) }}</p>
                    </div>
                    <div style="width:120px;">
                        <form method="POST" action="{{ route('carrito.actualizar', $item) }}">
                            @csrf
                            @method('PATCH')
                            <div class="input-group input-group-sm">
                                <input type="number" name="cantidad" value="{{ $item->cantidad }}"
                                    min="1" class="form-control text-center"
                                    onchange="this.form.submit()">
                            </div>
                        </form>
                    </div>
                    <div style="width:80px;" class="text-end">
                        <p class="fw-bold mb-1">S/ {{ number_format($item->libro->precio * $item->cantidad, 2) }}</p>
                        <form method="POST" action="{{ route('carrito.eliminar', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">✕</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-custom p-4">
                <h5 class="fw-bold mb-3" style="color:var(--vino-dark)">Resumen</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>S/ {{ number_format($total, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Envío</span>
                    <span class="text-success">Gratis</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span style="color:var(--vino);font-size:1.2rem;">S/ {{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-vino w-100">
                    Proceder al Checkout
                </a>
                <a href="{{ route('usuario.lista') }}" class="btn btn-outline-secondary w-100 mt-2">
                    Seguir Comprando
                </a>
            </div>
        </div>
    </div>
@endif

@endsection