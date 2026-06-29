@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Editar Autor Destacado</h2>

            <div class="text-center mb-4">
                @if($autor->foto)
                    <img src="{{ asset('storage/'.$autor->foto) }}"
                        style="width:120px;height:120px;object-fit:cover;border-radius:50%;margin-bottom:12px;">
                @else
                    <div style="width:120px;height:120px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.5rem;margin:0 auto 12px;">✍️</div>
                @endif
            </div>

            <form action="{{ url('autores/'.$autor->id.'/actualizar-autor') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ $autor->nombre }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nacionalidad</label>
                    <input type="text" name="nacionalidad" value="{{ $autor->nacionalidad }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Biografía</label>
                    <textarea name="biografia" class="form-control" rows="4"
                        placeholder="Escribe una breve biografía del autor...">{{ $autor->biografia }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto del autor</label>
                    @if($autor->foto)
                        <p class="small text-muted">Foto actual — sube una nueva para reemplazarla</p>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4">Actualizar</button>
                    <a href="{{ route('estructuras.grafo') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection