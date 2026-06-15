@extends('layouts.usuario')
@section('content')
<h2 class="page-title mb-1">Autores Relacionados</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>
<p class="text-muted mb-4">Autores que comparten la misma categoria de libros.</p>

<div class="row g-4">
    @php $autores = array_keys($aristas); $i = 0; @endphp
    @while($i < count($autores))
        @php $autor = $autores[$i]; $conexiones = $aristas[$autor]; @endphp
        @if(count($conexiones) > 0)
        <div class="col-md-6">
            <div class="card-custom p-3">
                <h6 class="fw-bold mb-2" style="color:var(--vino-dark)">{{ $autor }}</h6>
                @php $j = 0; @endphp
                @while($j < count($conexiones))
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span style="color:var(--vino)">&#8594;</span>
                    <span class="small">{{ $conexiones[$j]['destino'] }}</span>
                    <span class="badge badge-vino rounded-pill ms-auto">{{ $conexiones[$j]['categoria'] }}</span>
                </div>
                @php $j++; @endphp
                @endwhile
            </div>
        </div>
        @endif
    @php $i++; @endphp
    @endwhile
</div>
@endsection