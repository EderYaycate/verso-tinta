@extends('layouts.admin')
@section('content')
@php
/** @var array $aristas */
/** @var array $fotosAutores */
/** @var array $idsAutores */
/** @var array $librosAutores */
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="page-title mb-0">Autores Destacados</h2>
    <a href="{{ route('autores.create') }}" class="btn btn-vino">+ Nuevo Autor</a>
</div>

<div class="row g-4 justify-content-center">
    @php $autoresKeys = array_keys($aristas); $i = 0; @endphp
    @while($i < count($autoresKeys))
        @php $autor = $autoresKeys[$i]; $conexiones = $aristas[$autor]; @endphp
        @if(count($conexiones) > 0)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
            <div onclick="abrirModal('{{ addslashes($autor) }}')" style="cursor:pointer;">
                @if(isset($fotosAutores[$autor]) && $fotosAutores[$autor])
                    <img src="{{ asset('storage/'.$fotosAutores[$autor]) }}"
                        style="width:110px;height:110px;object-fit:cover;border-radius:50%;border:3px solid var(--vino);margin-bottom:10px;transition:transform 0.2s;"
                        onmouseover="this.style.transform='scale(1.05)'"
                        onmouseout="this.style.transform='scale(1)'">
                @else
                    <div style="width:110px;height:110px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 10px;border:3px solid var(--vino);">✍️</div>
                @endif
                <p class="fw-bold mb-0" style="font-size:0.85rem;color:var(--vino-dark);">{{ $autor }}</p>
            </div>
            <div class="mt-2 d-flex gap-1 justify-content-center">
                @if(isset($idsAutores[$autor]))
                    <a href="{{ url('autores/'.$idsAutores[$autor].'/actualizar-autor') }}" class="btn btn-sm btn-warning">Editar</a>
                    <form method="POST" action="{{ url('autores/'.$idsAutores[$autor].'/eliminar') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                @endif
            </div>
        </div>
        @endif
    @php $i++; @endphp
    @endwhile
</div>

<div class="modal fade" id="modalAutor" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background:var(--vino-dark);color:#fff;">
                <h5 class="modal-title" id="modalNombre"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <img id="modalFoto" src="" style="width:150px;height:150px;object-fit:cover;border-radius:50%;border:4px solid var(--vino);display:none;">
                        <div id="modalFotoPlaceholder" style="width:150px;height:150px;background:linear-gradient(135deg,var(--vino-dark),var(--vino));border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:3rem;margin:0 auto;">✍️</div>
                        <h5 id="modalNombreDetalle" class="mt-3 fw-bold" style="color:var(--vino-dark);font-family:Georgia,serif;"></h5>
                        <div id="modalGeneros" class="d-flex flex-wrap gap-1 justify-content-center mt-2"></div>
                        <div class="mt-3" id="modalBotonesAdmin"></div>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav nav-tabs mb-3" id="modalTabs">
                            <li class="nav-item">
                                <button class="nav-link active" onclick="mostrarTab('biografia', this)">📖 Biografía</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" onclick="mostrarTab('relacionados', this)">🔗 Relacionados</button>
                            </li>
                        </ul>
                        <div id="tabBiografia"></div>
                        <div id="tabRelacionados" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script id="datos-blade" type="application/json">
{
    "aristas":      {!! json_encode($aristas) !!},
    "fotosAutores": {!! json_encode($fotosAutores) !!},
    "idsAutores":   {!! json_encode($idsAutores) !!},
    "librosAutores":{!! json_encode($librosAutores) !!}
}
</script>

<script>
var _d            = JSON.parse(document.getElementById('datos-blade').textContent);
var datosAutores  = _d.aristas;
var fotosAutores  = _d.fotosAutores;
var idsAutores    = _d.idsAutores;
var librosAutores = _d.librosAutores;
var modal = new bootstrap.Modal(document.getElementById('modalAutor'));

function mostrarTab(tab, btn) {
    document.getElementById('tabBiografia').style.display    = tab === 'biografia'   ? 'block' : 'none';
    document.getElementById('tabRelacionados').style.display = tab === 'relacionados' ? 'block' : 'none';
    document.querySelectorAll('#modalTabs .nav-link').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');
}

function abrirModal(autor) {
    var conexiones = datosAutores[autor] || [];
    var foto       = fotosAutores[autor] || null;
    var id         = idsAutores[autor] || null;
    var datos      = librosAutores[autor] || {};
    var biografia  = datos.biografia || '';

    document.getElementById('modalNombre').textContent        = autor;
    document.getElementById('modalNombreDetalle').textContent = autor;

    var fotoEl = document.getElementById('modalFoto');
    var placeholderEl = document.getElementById('modalFotoPlaceholder');
    if (foto) {
        fotoEl.src = '/storage/' + foto;
        fotoEl.style.display = 'block';
        placeholderEl.style.display = 'none';
    } else {
        fotoEl.style.display = 'none';
        placeholderEl.style.display = 'flex';
    }

    var generos = [];
    var i = 0;
    while (i < conexiones.length) {
        if (generos.indexOf(conexiones[i].categoria) === -1) generos.push(conexiones[i].categoria);
        i++;
    }
    var generosHtml = '';
    var g = 0;
    while (g < generos.length) {
        generosHtml += '<span class="badge" style="background:#6B1C1C;color:#fff;">' + generos[g] + '</span>';
        g++;
    }
    document.getElementById('modalGeneros').innerHTML = generosHtml;

    if (id) {
        document.getElementById('modalBotonesAdmin').innerHTML =
            '<a href="/autores/' + id + '/actualizar-autor" class="btn btn-sm btn-warning me-1">Editar</a>';
    }

    var bioHtml = biografia
        ? '<p style="color:#555;font-size:0.9rem;line-height:1.6;">' + biografia + '</p>'
        : '<p class="text-muted small">No hay biografía registrada.</p>';
    document.getElementById('tabBiografia').innerHTML = bioHtml;

    var relacionadosHtml = '';
    var j = 0;
    while (j < conexiones.length) {
        var destino     = conexiones[j].destino;
        var fotoDestino = fotosAutores[destino] || null;
        var idDestino   = idsAutores[destino] || null;
        var imgHtml = fotoDestino
            ? '<img src="/storage/' + fotoDestino + '" style="width:45px;height:45px;object-fit:cover;border-radius:50%;border:2px solid #6B1C1C;flex-shrink:0;">'
            : '<div style="width:45px;height:45px;background:linear-gradient(135deg,#3d0f0f,#6B1C1C);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0;">✍️</div>';
        var editarHtml = idDestino
            ? '<a href="/autores/' + idDestino + '/actualizar-autor" class="btn btn-sm btn-warning py-0 px-1 ms-auto" style="font-size:0.7rem;">Editar</a>'
            : '';
        relacionadosHtml +=
            '<div style="display:flex;align-items:center;gap:12px;padding:8px;border-bottom:1px solid #f0e8e0;">' +
            imgHtml +
            '<div style="flex-grow:1;"><div style="font-weight:600;color:#3d0f0f;">' + destino + '</div>' +
            '<span style="font-size:0.75rem;background:#f5f0e8;color:#3d0f0f;padding:2px 8px;border-radius:10px;">' + conexiones[j].categoria + '</span>' +
            '</div>' + editarHtml + '</div>';
        j++;
    }
    document.getElementById('tabRelacionados').innerHTML = relacionadosHtml;

    document.getElementById('tabBiografia').style.display    = 'block';
    document.getElementById('tabRelacionados').style.display = 'none';
    document.querySelectorAll('#modalTabs .nav-link').forEach(function(btn, idx) {
        btn.classList.toggle('active', idx === 0);
    });

    modal.show();
}
</script>
@endsection