@extends('layouts.dashboard_admin')
@section('main')
    <div class="container">
        <header>
            <h1>REGISTRO DE PROYECTOS</h1>
            <h2>FUNDACIÓN ESCUELA TECNOLÓGICA DE NEIVA</h2>
            <img src="{{ asset('img/Logo-FET.png') }}" alt="Logo de la FET">

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
        <form
            action="@isset($proyecto)
        {{ route('proyectos.update', $proyecto) }}
        @else {{ route('proyectos.store') }}
        @endisset"
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
            <div class="group-form input-group" id="investigadoresContainer"
                style="display: flex; flex-wrap: wrap;gap: 10px">
                @if (isset($proyecto) && !empty($proyecto->investigadores))
                    @foreach ($proyecto->investigadores as $investigador)
                        <div class="investigador-input">
                            <input type="hidden" name="investigadores_ids[]" value="{{ $investigador->id }}">

                            <input type="text" value="{{ $investigador->nombre }}" readonly>
                            <button onclick="eliminarCampoInvestigador(event)" type="button" class="button"><i
                                    class="fa-solid fa-user-minus"></i></button>
                        </div>
                    @endforeach
                @endif
                <div class="investigador-input">
                    <input class="form-control" type="text" name="investigadores_nombres[]"
                        placeholder="Nombre del investigador">
                    <button type="button" class="button añadir-investigador"><i class="fa-solid fa-user-plus"></i></button>
                </div>
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
        // Añadir inputs para investigadores
        const container = document.getElementById('investigadoresContainer');
        const addButton = document.querySelector('.añadir-investigador');
        // const proyecto = json(proyecto);

        function agregarInvestigadorCampo() {

            const newInput = document.createElement('div');
            newInput.classList.add('investigador-input');
            newInput.innerHTML = `
            <input type="text" name="investigadores_nombres[]" placeholder="Nombre del investigador" required>
            <button type="button" class="button eliminar-investigador"><i class="fa-solid fa-user-minus"></i></button>
        `;
            container.appendChild(newInput);

            const deleteButton = newInput.querySelector('.eliminar-investigador');
            deleteButton.addEventListener('click', eliminarCampoInvestigador);
        }

        function eliminarCampoInvestigador(event) {
            // si se da click en el icono el parentElement pasa a ser el btn
            // no corresponde a container
            // container.removeChild(event.target.parentElement);
            const investigadorDiv = event.target.closest(".investigador-input");
            if(investigadorDiv && container.contains(investigadorDiv)){
                container.removeChild(investigadorDiv)
            }
        }

        addButton.addEventListener('click', agregarInvestigadorCampo);
    </script>
@endsection
