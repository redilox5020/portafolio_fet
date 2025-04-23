@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h1 class="m-0" style="font-size: 1.25rem;font-size: clamp(1.25rem, 1rem + 1.25vw, 2.5rem);">
                {{ ucfirst(mb_strtolower($proyecto->nombre)) }}</h1>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-white"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink"
                    style="">
                    <div class="dropdown-header">Acciones:</div>
                    @if ($proyecto->investigadoresHistoricos->isNotEmpty())
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historicoModal">
                            <i class="fa-solid fa-clock-rotate-left fa-sm fa-fw mr-2 text-gray-400"></i>
                            Historico de Investigadores
                        </a>
                    @endif
                    <a class="dropdown-item" href="{{ route('proyectos.edit', $proyecto->codigo) }}">
                        <i class="fa-solid fa-pen-to-square fa-sm fa-fw mr-2 text-gray-400"></i>
                        Editar Proyecto
                    </a>
                    <a class="dropdown-item delete-btn" data-id="{{ $proyecto->codigo }}" data-toggle="modal"
                        data-target="#deleteModal" href="#">
                        <i class="fa-solid fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                        Eliminar Proyecto
                    </a>
                </div>
            </div>
        </div>
        <div id="container-main" class="card-body">
            <table class="table table-sm table-borderless table-hover">
                <tbody>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Objetivo general</div>
                        </td>
                        <td>
                            {{ $proyecto->objetivo_general }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Programa</div>
                        </td>
                        <td>
                            {{ $proyecto->programa->nombre }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Procedencia</div>
                        </td>
                        <td>
                            {{ $proyecto->procedencia->opcion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Tipologia</div>
                        </td>
                        <td>
                            {{ $proyecto->tipologia->opcion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Duracion</div>
                        </td>
                        <td>
                            {{ $proyecto->duracion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Costo</div>
                        </td>
                        <td>
                            ${{ number_format($proyecto->costo, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Año</div>
                        </td>
                        <td>
                            {{ $proyecto->anio }}
                        </td>
                    </tr>
                    @if ($proyecto->pdf_url)
                        <tr>
                            <td>
                                <div class="font-weight-bold">Url fichero</div>
                            </td>
                            <td>
                                <a href="{{ $proyecto->pdf_url }}" target="_blank"
                                    rel="noopener noreferrer">{{ $proyecto->pdf_url }}</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($proyecto->investigadores->isNotEmpty())
                @php
                    $indexInvestigadores = 1;
                @endphp

                <h3 class="mb-4 text-secondary font-weight-bold">Investigadores Activos</h3>

                <div id="container-investigadores-activos" class="row">
                    @foreach ($proyecto->investigadores as $investigador)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-user mr-2"></i> Investigador {{ $indexInvestigadores }}
                                    </h5>
                                    <p class="card-text text-muted mb-0">{{ $investigador->nombre }}</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $indexInvestigadores++;
                        @endphp
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="card border-info shadow mb-4">
        <div class="card-header p-2 bg-info text-white">
            <h6 class="m-0 font-weight-bold">Ficheros en este proyecto:</h6>
        </div>
        @if ($proyecto->pdf_url)
                <div id="loader-container" style="display: none;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                    <p class="text-center mt-2">Cargando metadatos del PDF...</p>
                </div>
                <div id="pdf-metadata-container" class="card-body p-0" data-url="{{ $proyecto->pdf_url }}"></div>
        @else
                <div class="card-body p-3">
                    No hay ficheros asociados a este proyecto.
                </div>
        @endif
    </div>
    @if ($proyecto->investigadoresHistoricos->isNotEmpty())
        <div class="modal fade" id="historicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Investigadores Historicos</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="alert" class="alert alert-dismissible fade show d-none" role="alert">
                            <span class="alert-message" style="white-space: pre-line;line-height: 1.3;"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Duración</th>
                                        <th>Revinculado?</th>
                                        <th>Seleccion</th>
                                    </tr>
                                </thead>
                                <tbody id="historicoTable">
                                    @foreach ($proyecto->investigadoresHistoricos as $investigador)
                                        @php
                                            $inicio = \Carbon\Carbon::parse($investigador->pivot->created_at);
                                            $fin = \Carbon\Carbon::parse($investigador->pivot->deleted_at);
                                            $duracion = $inicio->diffForHumans($fin, true);
                                        @endphp
                                        <tr data-pivot-id="{{ $investigador->pivot->id }}" data-investigador-id="{{ $investigador->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $investigador->nombre }}</td>
                                            <td>{{ $inicio->format('d/m/Y') }}</td>
                                            <td>{{ $fin->format('d/m/Y') }}</td>
                                            <td>{{ $duracion }}</td>
                                            <td>{{ in_array($investigador->id, $proyecto->investigadores()->pluck('investigadores.id')->toArray())? "si": "no" }}</td>
                                            <td>
                                                {{-- eliminar investigador por medio de un checkbox para poder seleccionar varios en caso de eliminacion multiple --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                    value="{{ $investigador->pivot->id }}"
                                                    data-investigador-id="{{ $investigador->id }}"
                                                    id="investigador-{{ $investigador->pivot->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="selectAllCheckbox">
                            <label class="form-check-label" for="selectAllCheckbox">
                                Seleccionar todos
                            </label>
                        </div>
                        <button id="reactivateButton" type="submit" class="btn btn-success btn-sm">
                            Reactivar
                        </button>
                        <button id="deleteButton" type="submit" class="btn btn-danger btn-sm">
                            Eliminar
                        </button>

                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('css')
@endsection
@section('scripts')
<script>
    window.appData = {
        indexActual : @json($indexInvestigadores ?? 1),
        csrf: '{{ csrf_token() }}',
        rutas: {
            eliminar: @json(route('proyectos.delete', ['id' => '__ID__'])),
            reactivar: '{{ route('investigadores.historicos.reactivar', $proyecto->id) }}',
            eliminarRegistroHistorico: '{{ route('investigadores.historicos.delete') }}'
        }
    };
</script>
@vite('resources/js/mostrar_proyecto.js')
@endsection
