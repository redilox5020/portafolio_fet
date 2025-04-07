@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1>{{ $proyecto->nombre }}</h1>
        </div>
        <div class="card-body">
            <p>{{ $proyecto->objetivo_general }}</p>
            <p><Strong>Programa:</Strong> {{ $proyecto->programa->nombre }}</p>
            <p><Strong>Procedencia:</Strong> {{ $proyecto->procedencia->opcion }}</p>
            <p><Strong>Tipologia:</Strong> {{ $proyecto->tipologia->opcion }}</p>
            <p><Strong>Duracion:</Strong> {{ $proyecto->duracion }}</p>
            <p><Strong>Costo:</Strong> ${{ number_format($proyecto->costo, 2, ',', '.') }}</p>
            <p><strong>Año:</strong> {{ $proyecto->anio }}</p>
            @php
                $indexInvestigadores = 1;
            @endphp
            <ul class="list-group list-group-flush">
            @foreach ($proyecto->investigadores as $investigador)
                <li class="list-group-item"><Strong>Investigador {{ $indexInvestigadores }}</Strong>: {{ $investigador->nombre }}</li>
                @php
                    $indexInvestigadores++;
                    @endphp
            @endforeach
            </ul>

            @if ($proyecto->pdf_url)
                <p style="display: flex; gap:10px; align-items: center"><Strong>Archivo actual: </Strong><a href="{{ $proyecto->pdf_url }}" target="_blank"><i style="font-size: 40px; color: red" class="fa-solid fa-file-pdf"></i></a></p>
            @endif
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('scripts')
@endsection
