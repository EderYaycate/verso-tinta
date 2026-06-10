@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Nuevo Libro</h2>
            <form action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="form-control" required>
                    @error('titulo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Resumen</label>
                    <textarea name="resumen" rows="4" class="form-control" required>{{ old('resumen') }}</textarea>
                    @error('resumen')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Portada (imagen)</label>
                    <input type="file" name="portada" accept="image/*" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Autor</label>
                    <select name="autor_id" class="form-select" required>
                        <option value="">-- Selecciona un autor --</option>
                        @foreach($autores as $autor)
                            <option value="{{ $autor->id }}" {{ old('autor_id') == $autor->id ? 'selected' : '' }}>{{ $autor->nombre }}</option>
                        @endforeach
                    </select>
                    @error('autor_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vino px-4">Guardar</button>
                    <a href="{{ route('libros.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection