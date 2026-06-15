@extends('layouts.usuario')
@section('content')

<h2 class="page-title mb-1">Checkout</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card-custom p-4">
            <h5 class="fw-bold mb-4" style="color:var(--vino-dark)">Datos de Entrega</h5>
            <form method="POST" action="{{ route('pedidos.confirmar') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Dirección de entrega</label>
                    <input type="text" name="direccion"
                        class="form-control @error('direccion') is-invalid @enderror"
                        placeholder="Ej: Av. Larco 123, Miraflores"
                        value="{{ old('direccion') }}">
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Referencia <span class="text-muted fw-normal">(opcional)</span></label>
                    <input type="text" name="referencia"
                        class="form-control"
                        placeholder="Ej: Frente al parque"
                        value="{{ old('referencia') }}">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Teléfono de contacto</label>
                    <input type="text" name="telefono"
                        class="form-control @error('telefono') is-invalid @enderror"
                        placeholder="Ej: 999 888 777"
                        value="{{ old('telefono') }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-vino w-100">Confirmar Pedido</button>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-custom p-4">
            <h5 class="fw-bold mb-3" style="color:var(--vino-dark)">Tu Pedido</h5>
            @foreach($items as $item)
            <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                <div>
                    <p class="mb-0 fw-semibold small">{{ $item->libro->titulo }}</p>
                    <p class="mb-0 text-muted small">Cant: {{ $item->cantidad }}</p>
                </div>
                <span class="fw-bold" style="color:var(--vino)">
                    S/ {{ number_format($item->libro->precio * $item->cantidad, 2) }}
                </span>
            </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span style="color:var(--vino);font-size:1.2rem;">S/ {{ number_format($total, 2) }}</span>
            </div>
        </div>
    </div>
</div>

@endsection