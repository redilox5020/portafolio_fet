@extends('layouts.dashboard_admin')
@section('main')
    <div class="container_register">

        <header>
            <div class="item item-1">
                <h1>REGISTRO DE PROYECTOS</h1>
            </div>
            <div class="item item-2">
                <h2>FUNDACIÓN ESCUELA TECNOLÓGICA DE NEIVA</h2>
            </div>
            <div class="item item-3"><img src="{{ asset('img/Logo-FET.png') }}" alt="Logo de la FET"></div>
        </header>

        @if (session('success'))
            <div id="session-alert" class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form id="formProyecto" style="position: relative;"
        action="@isset($proyecto){{ route('proyectos.update', $proyecto) }}@else{{ route('proyectos.store') }}@endisset"
        method="POST" enctype="multipart/form-data">
            <div id="loader-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center rounded"
                style="z-index: 1050;  background-color: rgba(255,255,255,0.75);">
                <div class="text-center" style="transform: translateY(-40px);">
                    <div class="spinner-border text-success" role="status" style="width: 4rem; height: 4rem;"></div>
                    <div class="mt-3 text-success fw-bold">Subiendo archivo, por favor espera...</div>
                </div>
            </div>
            @csrf
            @isset($proyecto)
                @method('PUT')
            @endisset
            <div class="group-form input-group">
                <label for="nombre">Nombre:</label>
                <input class="form-control @error('nombre') is-invalid @enderror" type="text" id="nombre"
                    name="nombre" value="{{ old('nombre', $proyecto->nombre ?? '') }}" placeholder="Escribe un nombre creativo y representativo para su proyecto" required>
                @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="objetivo_general">Objetivo General:</label>
                <input class="form-control @error('objetivo_general') is-invalid @enderror" type="text"
                    id="objetivo_general" name="objetivo_general"
                    value="{{ old('objetivo_general', $proyecto->objetivo_general ?? '') }}" placeholder="¿Cuál es el propósito central de este proyecto?" required>
                @error('objetivo_general')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="programa_id">Programa:</label>
                <select class="form-select @error('programa_id') is-invalid @enderror" id="programa_id" name="programa_id"
                    required>
                    <option value="" disabled
                        {{ old('programa_id', $proyecto->programa->id ?? '') == '' ? 'selected' : '' }}>
                        -- Selecciona un programa --
                    </option>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}" @selected(old('programa_id', $proyecto->programa->id ?? '') == $programa->id)
                            >{{ $programa->nombre }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-programa"><i
                        class="fa-solid fa-plus"></i></button>
                @error('programa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="procedencia_id">Procedencia:</label>
                <select class="form-select @error('procedencia_id') is-invalid @enderror"
                        id="procedencia_id" name="procedencia_id" required>
                    <option value="" disabled selected>-- Selecciona una procedencia --</option>
                    @foreach ($procedencias as $procedencia)
                        <option value="{{ $procedencia->id }}"
                            @selected(old('procedencia_id', $proyecto->procedencia_id ?? '') == $procedencia->id)>
                            {{ $procedencia->opcion }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedencia">
                    <i class="fa-solid fa-plus"></i>
                </button>
                @error('procedencia_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="group-form input-group">
                <label for="procedencia_detalle_id">Detalle procedencia:</label>
                <select class="form-select @error('procedencia_codigo_id') is-invalid @enderror"
                        id="procedencia_detalle_id"
                        name="procedencia_detalle_id"
                        data-old-value="{{ old('procedencia_detalle_id', $proyecto->procedencia_detalle_id ?? '') }}"
                        data-parent="procedencia_id" required disabled>
                    <option value="" disabled selected>-- Primero selecciona una procedencia --</option>
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedenciaCodigo">
                    <i class="fa-solid fa-plus"></i>
                </button>
                @error('procedencia_codigo_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="group-form input-group">
                <label for="tipologia_id">Tipología:</label>
                <select class="form-select @error('tipologia_id') is-invalid @enderror" id="tipologia_id"
                    name="tipologia_id" data-model="proyecto" required>
                    <option value="" disabled
                        {{ old('tipologia_id', $proyecto->tipologia->id ?? '') == '' ? 'selected' : '' }}>
                        -- Selecciona una tipología --
                    </option>
                    @foreach ($tipologias as $tipologia)
                        <option value="{{ $tipologia->id }}" @selected(old('tipologia_id', $proyecto->tipologia->id ?? '') == $tipologia->id)>
                            {{ $tipologia->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-tipologia"><i
                        class="fa-solid fa-plus"></i></button>
                @error('procedencia_codigo_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="investigadores_select">Investigador(es):</label>

                <select class_form-select"
                        id="investigadores_select"
                        name="investigadores_ids[]"
                        multiple="multiple"
                        required>
                    @if (isset($proyecto) && $proyecto->investigadores)
                        @foreach ($proyecto->investigadores as $investigador)
                            <option value="{{ $investigador->id }}" selected>
                                {{ $investigador->nombre }} ({{ $investigador->documento ?? 'N/A' }})
                            </option>
                        @endforeach
                    @endif

                    @if (old('investigadores_ids'))
                        @foreach (old('investigadores_ids') as $investigadorId)
                            {{-- Evitar duplicados si ya estaba en el modo edición --}}
                            @if (isset($proyecto) && $proyecto->investigadores->contains($investigadorId))
                                @continue
                            @endif

                            @isset($investigadoresOld) {{-- El controlador debe pasar esto --}}
                                @php $investigador = $investigadoresOld->firstWhere('id', $investigadorId); @endphp
                                @if($investigador)
                                <option value="{{ $investigador->id }}" selected>
                                    {{ $investigador->nombre }} ({{ $investigador->documento ?? 'N/A' }})
                                </option>
                                @endif
                            @endisset
                        @endforeach
                    @endif

                </select>

                @error('investigadores_ids')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                @error('investigadores_ids.*')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input class="form-control @error('fecha_inicio') is-invalid @enderror" type="date" id="fecha_inicio"
                    name="fecha_inicio" value="{{ old('fecha_inicio', isset($proyecto) && $proyecto->fecha_inicio ? $proyecto->fecha_inicio->format('Y-m-d') : '') }}" required>
                @error('fecha_inicio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input class="form-control @error('fecha_fin') is-invalid @enderror" type="date" id="fecha_fin"
                    name="fecha_fin" value="{{ old('fecha_fin', isset($proyecto) && $proyecto->fecha_fin ? $proyecto->fecha_fin->format('Y-m-d') : '') }}" required>
                @error('fecha_fin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="costo">Costo:</label>
                <input class="form-control @error('costo') is-invalid @enderror" type="number" step="0.01"
                    id="costo" name="costo" value="{{ old('costo', $proyecto->costo ?? '') }}" placeholder="¿Cuál es el presupuesto aproximado para poner en marcha su proyecto?" required>
                @error('costo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form row">
                <div class="input-group col-auto">
                    <label for="pdf_file">Anexar PDF</label>
                    <input class="form-control @error('pdf_file') is-invalid @enderror" type="file" name="pdf_file"
                        id="pdf_file" accept="application/pdf">
                    <input class="form-control" type="text" name="descripcion_archivo" placeholder="Descripción" />
                    @error('pdf_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-auto">
                    @if (isset($proyecto) && $proyecto->pdf_url)
                        <p>Archivo actual: <a href="{{ $proyecto->pdf_url }}" target="_blank">Ver PDF</a></p>
                    @endif

                </div>

            </div>
            <div class="group-form">
                <div class="input-group">
                    <label for="storage_type" class="form-label">Destino del archivo:</label>
                    <select name="driver" id="storage_type" class="form-select" required>
                        <option value="cloudinary" {{ old('driver') == 'cloudinary' ? 'selected' : '' }}>Cloudinary (proveedor externo)</option>
                        <option value="local" {{ old('driver', 'local') == 'local' ? 'selected' : '' }}>Almacenamiento local</option>
                    </select>
                </div>
                <div class="form-text text-muted">
                    Seleccione dónde desea almacenar el archivo PDF del proyecto
                </div>
            </div>
            <div class="group-form d-flex justify-content-between align-items-center">
                <button class="btn btn-success" type="submit">{{ isset($proyecto) ? 'Actualizar' : 'Crear' }} Proyecto</button>
                <a href="{{ route('inicio') }}"><i class="fa-solid fa-house"></i></a>
            </div>
        </form>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('submit', function(e) {
            if (e.target.id === 'formProyecto') {
                 document.getElementById('loader-overlay').classList.add('show');
            }
        });

        // Inicialización de Select2
        $(document).ready(function() {
            $('#investigadores_select').select2({
                theme: "bootstrap-5",
                placeholder: 'Busca un investigador por nombre o documento',
                allowClear: true,
                ajax: {
                    url: "{{ route('investigador.search') }}", //
                    dataType: 'json',
                    delay: 250, // Esperar 250ms antes de buscar
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        console.log(data, params)
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                language: {
                    // Traducciones básicas
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        return 'Por favor, introduce ' + remainingChars + ' o más caracteres';
                    }
                }
            });
        });
    </script>
@endsection
