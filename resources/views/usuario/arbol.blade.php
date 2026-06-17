@extends('layouts.usuario')
@section('content')
<h2 class="page-title mb-1">Libros A-Z</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>
<p class="text-muted mb-4">Libros ordenados alfabéticamente por título.</p>

<style>
    .libro-card-az {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    .libro-card-az:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(107,28,28,0.15);
    }
    .libro-portada-az { width: 100%; height: 200px; object-fit: cover; }
    .libro-placeholder-az {
        width: 100%; height: 200px;
        background: linear-gradient(160deg, var(--vino-dark), var(--vino));
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; color: rgba(255,255,255,0.3);
    }
    .numero-badge {
        position: absolute; top: 10px; left: 10px;
        background: var(--vino); color: #fff;
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; font-weight: 700;
    }
    @media (min-width: 1200px) { .col-xl-2-4 { width: 20%; } }
</style>

<div class="row g-3">
    @php $i = 0; @endphp
    @while($i < count($inorden))
    <div class="col-6 col-sm-4 col-md-3 col-xl-2-4">
        <div class="libro-card-az">
            <div style="position:relative;">
                @if($inorden[$i]['portada'])
                    <img src="{{ asset('storage/'.$inorden[$i]['portada']) }}" class="libro-portada-az">
                @else
                    <div class="libro-placeholder-az">📚</div>
                @endif
                <span class="numero-badge">{{ $i + 1 }}</span>
            </div>
            <div class="p-3 text-center">
                <div class="fw-bold mb-1" style="font-size:0.88rem;color:var(--vino-dark);font-family:Georgia,serif;">{{ $inorden[$i]['titulo'] }}</div>
                <div class="small" style="color:#888">{{ $inorden[$i]['autor'] }}</div>
            </div>
        </div>
    </div>
    @php $i++; @endphp
    @endwhile
</div>
@endsection