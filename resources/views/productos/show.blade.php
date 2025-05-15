@extends('layouts.dashboard_admin')
@section('main')
<div class="container mt-5">

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h1 class="m-0" style="font-size: 1.25rem;font-size: clamp(1.25rem, 1rem + 1.25vw, 2.5rem);">
                {{ ucfirst(mb_strtolower($producto->titulo)) }}</h1>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <strong>Proyecto:</strong>
                <span>{{ $producto->proyecto->nombre ?? 'N/A' }}</span>
            </div>

            <div class="mb-3">
                <strong>Tipología:</strong>
                <span>{{ $producto->tipologia->opcion ?? 'N/A' }}</span>
            </div>

            <div class="mb-3">
                <strong>Descripción:</strong>
                <p>{{ $producto->descripcion ?? 'Sin descripción disponible.' }}</p>
            </div>

            @if ($producto->enlace)
                <div class="mb-3">
                    <strong>Enlace:</strong>
                    <a href="{{ $producto->enlace }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        Ver Producto
                    </a>
                </div>
            @endif

            <div class="mb-4">
                <strong>Autores:</strong>
                @if ($producto->autores->isNotEmpty())
                    <ul class="list-group mt-2">
                        @foreach ($producto->autores as $investigador)
                            <li class="list-group-item">
                                {{ $investigador->nombre }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No hay autores asociados.</p>
                @endif
            </div>

            <a href="{{ route('proyecto.por.codigo', $producto->proyecto->codigo) }}" class="btn btn-success">
                Volver a la lista de productos
            </a>
        </div>
    </div>
</div>
@endsection
@section('scripts')

@endsection
