@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Editar Autor</h2>
            <form action="{{ url('autores/'.$autor->id.'/actualizar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $autor->nombre) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nacionalidad</label>
                    <input type="text" name="nacionalidad" value="{{ old('nacionalidad', $autor->nacionalidad) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto del autor</label>
                    @if($autor->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$autor->foto) }}"
                                style="width:80px;height:80px;object-fit:cover;border-radius:50%;">
                            <p class="small text-muted mt-1">Foto actual — sube una nueva para reemplazarla</p>
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4">Actualizar</button>
                    <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection