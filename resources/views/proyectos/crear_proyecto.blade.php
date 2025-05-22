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
                <select class="form-select @error('procedencia_id') is-invalid @enderror" id="procedencia_id"
                    name="procedencia_id" required>
                    <option value="" disabled
                        {{ old('procedencia_id', $proyecto->procedencia->id ?? '') == '' ? 'selected' : '' }}>
                        -- Selecciona una procedencia --
                    </option>
                    @foreach ($procedencias as $procedencia)
                        <option value="{{ $procedencia->id }}" @selected(old('procedencia_id', $proyecto->procedencia->id ?? '') == $procedencia->id)>
                            {{ $procedencia->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedencia"><i
                        class="fa-solid fa-plus"></i></button>
                @error('procedencia_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="group-form input-group">
                <label for="procedencia_codigo_id">Procedencia Código:</label>
                <select class="form-select @error('procedencia_codigo_id') is-invalid @enderror" id="procedencia_codigo_id"
                    name="procedencia_codigo_id" required>
                    <option value="" disabled
                        {{ old('procedencia_codigo_id', $proyecto->procedenciaCodigo->id ?? '') == '' ? 'selected' : '' }}>
                        -- Selecciona un codigo de procedencia --
                    </option>
                    @foreach ($procedenciaCodigos as $procedenciaCodigo)
                        <option value="{{ $procedenciaCodigo->id }}" @selected(old('procedencia_codigo_id', $proyecto->procedenciaCodigo->id ?? '') == $procedenciaCodigo->id)>
                            {{ $procedenciaCodigo->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedenciaCodigo"><i
                        class="fa-solid fa-plus"></i></button>
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
            @php
                $investigadoresOld = old('investigadores_nombres', []);
            @endphp
            <div class="group-form container_grid" id="investigadoresContainer">
                @if (isset($proyecto) && !empty($proyecto->investigadores))
                    @foreach ($proyecto->investigadores as $index => $investigador)
                        @php $inputId = 'investigador_' . $investigador->id; @endphp
                        <div class="input-group investigador-input">
                            <label for="{{ $inputId }}">{{ $index + 1 }}</label>
                            <input type="hidden" name="investigadores_ids[]" value="{{ $investigador->id }}">

                            <input id="{{ $inputId }}" class="form-control" style="height: auto;" type="text"
                                value="{{ $investigador->nombre }}" readonly>
                            <button type="button" class="button eliminar-investigador">
                                <i class="fa-solid fa-user-minus"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
                {{-- cuando salta una validacion en el backend --}}
                @if (!empty($proyecto->investigadores) && count($investigadoresOld) > 1)
                    <hr style="grid-column: 1 / -1;">
                @endif
                @foreach ($investigadoresOld as $index => $nombre)
                    @continue($index === 0)
                    @php $inputId = 'investigador_' . $index; @endphp
                    <div class="input-group investigador-input">
                        <label for="{{ $inputId }}">Nuevo {{ $index + 1 }}</label>
                        <input id="{{ $inputId }}" class="form-control @error("investigadores_nombres.$index") is-invalid @enderror"
                            style="height: auto;" type="text" name="investigadores_nombres[]"
                            value="{{ $nombre }}" placeholder="Nombre del investigador">

                        <button type="button" class="button eliminar-investigador">
                            <i class="fa-solid fa-user-minus"></i>
                        </button>
                        @error("investigadores_nombres.$index")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                @endforeach
            </div>
            <div class="group-form input-group">
                <label for="input_add_investigador">Investigador:</label>
                <input id="input_add_investigador"
                    class="form-control @error('investigadores_nombres.0') is-invalid @enderror" type="text"
                    style="height: auto;" name="investigadores_nombres[]" value="{{ old('investigadores_nombres.0') }}"
                    placeholder="Nombre y apellido del investigador">
                <button type="button" class="button añadir-investigador"><i class="fa-solid fa-user-plus"></i></button>
                @error('investigadores_nombres.0')
                    <div class="invalid-feedback">{{ $message }}</div>
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
                        <option value="cloudinary">Cloudinary (proveedor externo)</option>
                        <option value="local">Almacenamiento local (laravel storage)</option>
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
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('investigadoresContainer');
            const addButton = document.querySelector('.añadir-investigador');
            const form = document.getElementById('formProyecto');
            let hrInserted = false;
            let investigadores = @json($proyecto->investigadores ?? []);

            // Añadir un nuevo campo de investigador
            if (addButton) {
                let contador = 1;
                addButton.addEventListener('click', () => {
                    if (Array.isArray(investigadores) && investigadores.length > 0 && !hrInserted) {
                        const separator = document.createElement('hr');
                        separator.style.gridColumn = '1 / -1';
                        container.appendChild(separator);
                        hrInserted = true;
                    }
                    const newInput = document.createElement('div');
                    newInput.classList.add('input-group', 'investigador-input');

                    const idInput = `nuevo_investigador_${contador++}`;

                    newInput.innerHTML = `
                    <label for="${idInput}">Nuevo ${contador}</label>
                    <input id="${idInput}" class="form-control" style="height: auto;" type="text" name="investigadores_nombres[]" placeholder="Nombre y apellido del investigador" required>
                    <button type="button" class="button eliminar-investigador">
                        <i class="fa-solid fa-user-minus"></i>
                    </button>
                `;
                    container.appendChild(newInput);
                });
            }

            // Delegación de eventos para eliminar investigadores
            container.addEventListener('click', function(event) {
                if (event.target.closest('.eliminar-investigador')) {
                    const investigadorDiv = event.target.closest('.investigador-input');
                    if (investigadorDiv && container.contains(investigadorDiv)) {
                        container.removeChild(investigadorDiv);
                    }
                }
            });

            // Validar investigadores antes de enviar el formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const inputs = container.querySelectorAll('input[name="investigadores_nombres[]"]');
                const inputAddInvestigador = document.getElementById('input_add_investigador');
                const nombres = new Set();
                let hasError = false;

                const investigadoresExistentes = investigadores.map(i => i.nombre.trim().toLowerCase());

                const validarInput = (input, esOpcional = false) => {
                    const valor = input.value.trim().toLowerCase();
                    if (valor === '' && esOpcional) {
                        return true;
                    }
                    if (valor === '') {
                        alert("No se permiten nombres de investigadores vacíos.");
                        input.focus();
                        return false;
                    }
                    if (nombres.has(valor)) {
                        alert(`El investigador "${input.value}" ya fue agregado.`);
                        input.focus();
                        return false;
                    }
                    if (investigadoresExistentes.includes(valor)) {
                        alert(`El investigador "${input.value}" ya existe en este proyecto.`);
                        input.focus();
                        return false;
                    }
                    nombres.add(valor);
                    return true;
                }

                if (!validarInput(inputAddInvestigador, true)) {
                    hasError = true;
                }
                inputs.forEach(input => {
                    if (!validarInput(input)) {
                        hasError = true;
                    }
                })

                if (!hasError) {
                    document.getElementById('loader-overlay').classList.add('show');
                    form.submit();
                }
            });
        });
    </script>
@endsection
