@extends('layouts.admin')
@section('content')

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
            @php $i = 1; @endphp
            @forelse($inorden as $libro)
            <tr>
                <td>{{ $i }}</td>
                <td class="fw-semibold">{{ $libro['titulo'] }}</td>
                <td>{{ $libro['autor'] }}</td>
            </tr>
            @php $i++; @endphp
            @empty
            <tr>
                <td colspan="3" class="text-center">No hay libros registrados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection