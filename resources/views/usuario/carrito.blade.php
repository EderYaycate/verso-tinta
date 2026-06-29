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

                @php
                    $mensajeWsp  = 'Hola! Quiero consultar mi pedido en Verso %26 Tinta.%0A';
                    $mensajeWsp .= 'Cliente: ' . urlencode(auth()->user()->name) . '%0A';
                    $mensajeWsp .= 'Total: S/ ' . number_format($total, 2) . '%0A';
                    $mensajeWsp .= 'Libros:%0A';
                    $wi = 0;
                    while ($wi < count($items->all())) {
                        $it = $items->all()[$wi];
                        $mensajeWsp .= '- ' . urlencode($it->libro->titulo) . ' x' . $it->cantidad . ' (S/ ' . number_format($it->libro->precio * $it->cantidad, 2) . ')%0A';
                        $wi++;
                    }
                    $numeroWsp = '51944780846';
                @endphp

                <a href="https://wa.me/{{ $numeroWsp }}?text={{ $mensajeWsp }}"
                   target="_blank"
                   class="btn w-100 mt-2 d-flex align-items-center justify-content-center gap-2"
                   style="background:#25D366;color:#fff;font-weight:600;border:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                    </svg>
                    Consultar pedido por WhatsApp
                </a>
            </div>
        </div>
    </div>
@endif

@endsection