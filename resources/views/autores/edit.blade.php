@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Editar Autor</h2>
            <form action="{{ route('autores.update', $autor) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $autor->nombre) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nacionalidad</label>
                    <input type="text" name="nacionalidad" value="{{ old('nacionalidad', $autor->nacionalidad) }}" class="form-control" required>
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