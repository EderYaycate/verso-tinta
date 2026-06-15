@extends('layouts.usuario')
@section('content')
<h2 class="page-title mb-1">Libros en Orden de Registro</h2>
<div class="mb-4" style="height:3px;width:40px;background:var(--vino);"></div>
<p class="text-muted mb-4">Libros en el orden en que fueron registrados en el sistema.</p>

<div class="card-custom p-3">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Autor</th>
            </tr>
        </thead>
        <tbody>
            @php $i = 0; @endphp
            @while($i < count($elementos))
            <tr>
                <td>{{ $i + 1 }}</td>
                <td class="fw-semibold">{{ $elementos[$i]['titulo'] }}</td>
                <td>{{ $elementos[$i]['autor'] }}</td>
            </tr>
            @php $i++; @endphp
            @endwhile
        </tbody>
    </table>
</div>
@endsection