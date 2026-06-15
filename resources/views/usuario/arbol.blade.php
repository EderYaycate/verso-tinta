@extends('layouts.usuario')
@section('content')
<h2 class="page-title mb-1">Buscar Libros</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>
<p class="text-muted mb-4">Libros ordenados alfabeticamente por titulo.</p>

<div class="row g-3">
    @php $i = 0; @endphp
    @while($i < count($inorden))
    <div class="col-md-6">
        <div class="card-custom p-3 d-flex align-items-center gap-3">
            <span class="count-badge">{{ $i + 1 }}</span>
            <div>
                <div class="fw-bold">{{ $inorden[$i]['titulo'] }}</div>
                <div class="small" style="color:var(--vino)">{{ $inorden[$i]['autor'] }}</div>
            </div>
        </div>
    </div>
    @php $i++; @endphp
    @endwhile
</div>
@endsection