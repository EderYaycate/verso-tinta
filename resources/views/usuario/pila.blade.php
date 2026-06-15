@extends('layouts.usuario')
@section('content')
<h2 class="page-title mb-1">Ultimos Libros Agregados</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>
<p class="text-muted mb-4">Los 8 libros mas recientes agregados al sistema.</p>

<div class="row g-4">
    @php $i = 0; @endphp
    @while($i < count($elementos))
    <div class="col-sm-6 col-lg-3">
        <div class="card-custom h-100">
            @if($elementos[$i]['portada'])
                <img src="{{ asset('storage/'.$elementos[$i]['portada']) }}" class="portada-img">
            @else
                <div class="portada-placeholder"></div>
            @endif
            <div class="p-3">
                <span class="badge bg-secondary rounded-pill mb-2"># {{ $i + 1 }}</span>
                <h6 class="fw-bold mb-1">{{ $elementos[$i]['titulo'] }}</h6>
                <p class="small mb-0" style="color:var(--vino)">{{ $elementos[$i]['autor'] }}</p>
            </div>
        </div>
    </div>
    @php $i++; @endphp
    @endwhile
</div>
@endsection