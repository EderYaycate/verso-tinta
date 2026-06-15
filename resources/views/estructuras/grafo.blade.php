@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Vertices - Autores</h5>
            <table class="table table-sm table-hover mb-0">
                <thead><tr><th>#</th><th>Autor</th></tr></thead>
                <tbody>
                    @php $i = 0; @endphp
                    @while($i < count($vertices))
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-semibold">{{ $vertices[$i] }}</td>
                    </tr>
                    @php $i++; @endphp
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-custom p-3">
            <h5 class="fw-bold mb-3" style="color: var(--vino-dark)">Aristas - Relaciones entre Autores</h5>
            <table class="table table-sm table-hover mb-0">
                <thead><tr><th>Autor</th><th>Conectado con</th><th>Categoria compartida</th></tr></thead>
                <tbody>
                    @php $hayAristas = false; @endphp
                    @php $autores = array_keys($aristas); @endphp
                    @php $i = 0; @endphp
                    @while($i < count($autores))
                        @php $autor = $autores[$i]; $conexiones = $aristas[$autor]; @endphp
                        @if(count($conexiones) > 0)
                            @php $hayAristas = true; $j = 0; @endphp
                            @while($j < count($conexiones))
                            <tr>
                                <td class="fw-semibold">{{ $autor }}</td>
                                <td>{{ $conexiones[$j]['destino'] }}</td>
                                <td><span class="badge badge-vino rounded-pill">{{ $conexiones[$j]['categoria'] }}</span></td>
                            </tr>
                            @php $j++; @endphp
                            @endwhile
                        @endif
                    @php $i++; @endphp
                    @endwhile
                    @if(!$hayAristas)
                    <tr><td colspan="3" class="text-center text-muted">No hay relaciones entre autores.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection