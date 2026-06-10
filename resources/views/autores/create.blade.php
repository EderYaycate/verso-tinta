@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card-custom p-4">
            <h2 class="page-title mb-4">Nuevo Autor</h2>
            <form action="{{ route('autores.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                    @error('nombre')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nacionalidad</label>
                    <input type="text" name="nacionalidad" value="{{ old('nacionalidad') }}" class="form-control" required>
                    @error('nacionalidad')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-vino px-4">Guardar</button>
                    <a href="{{ route('autores.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection