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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <form id="formProyecto"
            action="@isset($proyecto){{ route('proyectos.update', $proyecto) }}@else{{ route('proyectos.store') }}@endisset"
            method="POST" enctype="multipart/form-data">
            @csrf
            @isset($proyecto)
                @method('PUT')
            @endisset
            <div class="group-form input-group">
                <label for="nombre">Nombre:</label>
                <input class="form-control" type="text" id="nombre" name="nombre"
                    value="{{ old('nombre', $proyecto->nombre ?? '') }}" required>
            </div>
            <div class="group-form input-group">
                <label for="objetivo_general">Objetivo General:</label>
                <input class="form-control" type="text" id="objetivo_general" name="objetivo_general"
                    value="{{ old('objetivo_general', $proyecto->objetivo_general ?? '') }}" required>
            </div>
            <div class="group-form input-group">
                <label for="programa_id">Programa:</label>
                <select class="form-select" id="programa_id" name="programa_id" required>
                    @foreach ($programas as $programa)
                        <option value="{{ $programa->id }}" @if (old('programa_id', $proyecto->programa->id ?? '') == $programa->id) selected @endif>
                            {{ $programa->nombre }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-programa"><i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="group-form input-group">
                <label for="procedencia_id">Procedencia:</label>
                <select class="form-select" id="procedencia_id" name="procedencia_id" required>
                    @foreach ($procedencias as $procedencia)
                        <option value="{{ $procedencia->id }}" @if (old('procedencia_id', $proyecto->procedencia->id ?? '') == $procedencia->id) selected @endif>
                            {{ $procedencia->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedencia"><i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="group-form input-group">
                <label for="procedencia_codigo_id">Procedencia Código:</label>
                <select class="form-select" id="procedencia_codigo_id" name="procedencia_codigo_id" required>
                    @foreach ($procedenciaCodigos as $procedenciaCodigo)
                        <option value="{{ $procedenciaCodigo->id }}" @if (old('procedencia_codigo_id', $proyecto->procedenciaCodigo->id ?? '') == $procedenciaCodigo->id) selected @endif>
                            {{ $procedenciaCodigo->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-procedenciaCodigo"><i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="group-form input-group">
                <label for="tipologia_id">Tipología:</label>
                <select class="form-select" id="tipologia_id" name="tipologia_id" required>
                    @foreach ($tipologias as $tipologia)
                        <option value="{{ $tipologia->id }}" @if (old('tipologia_id', $proyecto->tipologia->id ?? '') == $tipologia->id) selected @endif>
                            {{ $tipologia->opcion }}</option>
                    @endforeach
                </select>
                <button type="button" class="button" data-toggle="modal" data-target="#modal-tipologia"><i
                        class="fa-solid fa-plus"></i></button>
            </div>
            <div class="group-form container_grid" id="investigadoresContainer">
                @if (isset($proyecto) && !empty($proyecto->investigadores))
                    @foreach ($proyecto->investigadores as $index => $investigador)
                        <div class="input-group investigador-input">
                            <label for="investigadores_nombres[]">{{ $index + 1 }}</label>
                            <input type="hidden" name="investigadores_ids[]" value="{{ $investigador->id }}">

                            <input class="form-control" style="height: auto;" type="text"
                                value="{{ $investigador->nombre }}" readonly>
                            <button type="button" class="button eliminar-investigador">
                                <i class="fa-solid fa-user-minus"></i>
                            </button>
                        </div>
                    @endforeach
                @endif
                {{-- <select name="investigadores[]" multiple>
                @foreach ($proyecto->investigadores as $investigador)
                    <option value="{{ $investigador->id }}"
                        @if (in_array($investigador->id, old('investigadores', $proyecto->investigadores->pluck('id')->toArray())))
                            selected
                        @endif
                    >
                        {{ $investigador->nombre }}
                    </option>
                @endforeach
            </select> --}}
            </div>
            <div class="group-form input-group">
                <label for="investigadores_nombres[]">Investigador:</label>
                <input id="input_add_investigador" class="form-control" type="text" style="height: auto;"
                    name="investigadores_nombres[]" placeholder="Nombre del investigador">
                <button type="button" class="button añadir-investigador"><i class="fa-solid fa-user-plus"></i></button>
            </div>
            <div class="group-form input-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input class="form-control" type="date" id="fecha_inicio" name="fecha_inicio"
                    value="{{ old('fecha_inicio', $proyecto->fecha_inicio ?? '') }}" required>
            </div>
            <div class="group-form input-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input class="form-control" type="date" id="fecha_fin" name="fecha_fin"
                    value="{{ old('fecha_fin', $proyecto->fecha_fin ?? '') }}" required>
            </div>
            <div class="group-form input-group">
                <label for="costo">Costo:</label>
                <input class="form-control" type="number" step="0.01" id="costo" name="costo"
                    value="{{ old('costo', $proyecto->costo ?? '') }}" required>
            </div>
            <div class="group-form row">
                <div class="input-group col-auto">
                    <label for="pdf_file">Anexar PDF</label>
                    <input class="form-control" type="file" name="pdf_file" id="pdf_file" accept="application/pdf">

                </div>
                <div class="col-auto">
                    @if (isset($proyecto) && $proyecto->pdf_url)
                        <p>Archivo actual: <a href="{{ $proyecto->pdf_url }}" target="_blank">Ver PDF</a></p>
                    @endif

                </div>

            </div>
            <div class="group-form">

                <button class="btn btn-success" type="submit">{{ isset($proyecto) ? 'Actualizar' : 'Crear' }}
                    Proyecto</button>
            </div>
        </form>
        <a href="{{ route('inicio') }}"><i class="fa-solid fa-house"></i></a>
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
                addButton.addEventListener('click', () => {
                    if (Array.isArray(investigadores) && investigadores.length > 0 && !hrInserted) {
                        const separator = document.createElement('hr');
                        separator.style.gridColumn = '1 / -1';
                        container.appendChild(separator);
                        hrInserted = true;
                    }
                    const newInput = document.createElement('div');
                    newInput.classList.add('input-group', 'investigador-input');
                    newInput.innerHTML = `
                    <label for="investigadores_nombres[]">Nuevo</label>
                    <input class="form-control" style="height: auto;" type="text" name="investigadores_nombres[]" placeholder="Nombre del investigador" required>
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

                if (!hasError) form.submit();
            });
        });
    </script>
@endsection
