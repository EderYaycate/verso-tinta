@extends('layouts.admin')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Editar Libro</h2>
            <form action="{{ route('libros.update', $libro) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $libro->titulo) }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Resumen</label>
                    <textarea name="resumen" rows="4" class="form-control" required>{{ old('resumen', $libro->resumen) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Precio (S/)</label>
                    <input type="number" name="precio" value="{{ old('precio', $libro->precio) }}"
                        class="form-control" step="0.01" min="0" required>
                    @error('precio')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Portada actual</label>
                    @if($libro->portada)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$libro->portada) }}" style="width:80px;height:110px;object-fit:cover;border-radius:8px;">
                        </div>
                    @endif
                    <input type="file" name="portada" accept="image/*" class="form-control">
                    <div class="form-text">Deja vacío para mantener la portada actual.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Autor</label>
                    <select name="autor_id" class="form-select" required>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id }}" {{ $libro->autor_id == $autor->id ? 'selected' : '' }}>{{ $autor->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ $libro->categoria_id == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-warning px-4">Actualizar</button>
                    <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection