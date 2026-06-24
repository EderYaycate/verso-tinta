@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Autores Destacados</h2>
    <a href="{{ route('autores.create') }}" class="btn btn-vino">+ Nuevo Autor</a>
</div>

<div class="row g-4 mb-5">
    @php $autoresKeys = array_keys($aristas); $i = 0; @endphp
    @while($i < count($autoresKeys))
        @php $autor = $autoresKeys[$i]; $conexiones = $aristas[$autor]; @endphp
        @if(count($conexiones) > 0)
        <div class="col-md-6 col-lg-4">
            <div class="card-custom overflow-hidden">
                @if(isset($fotosAutores[$autor]) && $fotosAutores[$autor])
                    <img src="{{ asset('storage/'.$fotosAutores[$autor]) }}"
                        style="width:100%;height:160px;object-fit:cover;">
                @else
                    <div style="width:100%;height:160px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));display:flex;align-items:center;justify-content:center;font-size:2.5rem;">✍️</div>
                @endif

                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0" style="color:var(--vino-dark);font-family:Georgia,serif;font-size:1rem;">{{ $autor }}</h6>
                        <div class="d-flex gap-1">
                            @if(isset($idsAutores[$autor]))
                                <a href="{{ route('autores.edit', $idsAutores[$autor]) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form method="POST" action="{{ route('autores.destroy', $idsAutores[$autor]) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    @php
                        $generos = [];
                        $j = 0;
                        while ($j < count($conexiones)) {
                            $cat = $conexiones[$j]['categoria'];
                            if (!in_array($cat, $generos)) $generos[] = $cat;
                            $j++;
                        }
                    @endphp
                    <div class="mb-3">
                        <p class="small fw-semibold text-muted mb-1">⭐ Destaca en:</p>
                        <div class="d-flex flex-wrap gap-1">
                            @php $g = 0; @endphp
                            @while($g < count($generos))
                                <span class="badge badge-vino">{{ $generos[$g] }}</span>
                            @php $g++; @endphp
                            @endwhile
                        </div>
                    </div>

                    <div>
                        <p class="small fw-semibold text-muted mb-1">🔗 Relacionado con:</p>
                        @php $j = 0; @endphp
                        @while($j < count($conexiones))
                        <div class="d-flex align-items-center gap-2 mb-1 py-1" style="border-bottom:1px solid #f0e8e0;">
                            <span style="color:var(--vino);font-size:0.8rem;">&#8594;</span>
                            <span class="small fw-semibold">{{ $conexiones[$j]['destino'] }}</span>
                            <span class="badge rounded-pill ms-auto" style="background:var(--crema);color:var(--vino-dark);font-size:0.7rem;">{{ $conexiones[$j]['categoria'] }}</span>
                        </div>
                        @php $j++; @endphp
                        @endwhile
                    </div>
                </div>
            </div>
        </div>
        @endif
    @php $i++; @endphp
    @endwhile
</div>
@endsection