<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Proyecto</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>{{isset($proyecto)?'Actualizar':'Crear'}} Proyecto</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="@isset($proyecto)
        {{ route('proyectos.update', $proyecto) }}
        @else {{ route('proyectos.store') }}
        @endisset" method="POST">
        @csrf
        @isset($proyecto)
            @method('PUT')
        @endisset
        <div>
            <label for="nombre">Nombre:</label>
            <input  type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $proyecto->nombre ?? '') }}"
                    required>
        </div>
        <div>
            <label for="objetivo_general">Objetivo General:</label>
            <input  type="text"
                    id="objetivo_general"
                    name="objetivo_general"
                    value="{{ old('objetivo_general', $proyecto->objetivo_general ?? '') }}"
                    required>
        </div>
        <div>
            <label for="programa_id">Programa:</label>
            <select id="programa_id" name="programa_id" required>
                @foreach($programas as $programa)
                    <option value="{{ $programa->id }}"
                            @if (old('programa_id', $proyecto->programa->id?? '') == $programa->id)
                            selected
                            @endif>{{ $programa->nombre }}</option>
                @endforeach
            </select>
            <button type="button" id="abrirModalPrograma">+</button>
        </div>
        <div>
            <label for="procedencia_id">Procedencia:</label>
            <select id="procedencia_id" name="procedencia_id" required>
                @foreach($procedencias as $procedencia)
                    <option value="{{ $procedencia->id }}"
                        @if (old('procedencia_id', $proyecto->procedencia->id?? '') == $procedencia->id)
                        selected
                        @endif>{{ $procedencia->opcion }}</option>
                @endforeach
            </select>
            <button type="button" id="abrirModalProcedencia">+</button>
        </div>
        <div>
            <label for="procedencia_codigo_id">Procedencia Código:</label>
            <select id="procedencia_codigo_id" name="procedencia_codigo_id" required>
                @foreach($procedenciaCodigos as $procedenciaCodigo)
                    <option value="{{ $procedenciaCodigo->id }}"
                        @if (old('procedencia_codigo_id', $proyecto->procedenciaCodigo->id?? '') == $procedenciaCodigo->id)
                        selected
                        @endif>{{ $procedenciaCodigo->opcion }}</option>
                @endforeach
            </select>
            <button type="button" id="abrirModalProcedenciaCodigo">+</button>
        </div>
        <div>
            <label for="tipologia_id">Tipología:</label>
            <select id="tipologia_id" name="tipologia_id" required>
                @foreach($tipologias as $tipologia)
                    <option value="{{ $tipologia->id }}"
                        @if (old('tipologia_id', $proyecto->tipologia->id?? '') == $tipologia->id)
                        selected
                        @endif>{{ $tipologia->opcion }}</option>
                @endforeach
            </select>
            <button type="button" id="abrirModalTipologia">+</button>
        </div>
        <div id="investigadoresContainer" style="display: flex; flex-wrap: wrap;gap: 10px">
            @if (isset($proyecto) && !empty($proyecto->investigadores))
                @foreach ($proyecto->investigadores as $investigador)
                <div class="investigador-input">
                    <input type="hidden" name="investigadores_ids[]" value="{{$investigador->id}}">

                    <input type="text" value="{{$investigador->nombre}}" readonly>
                    <button onclick="eliminarCampoInvestigador(event)" type="button" class="eliminar-investigador">-</button>
                </div>
                @endforeach
            @endif
            <div class="investigador-input">
                <input type="text" name="investigadores_nombres[]" placeholder="Nombre del investigador">
                <button type="button" class="añadir-investigador">+</button>
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
        <div>
            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input  type="date"
                    id="fecha_inicio"
                    name="fecha_inicio"
                    value="{{ old('fecha_inicio', $proyecto->fecha_inicio ?? '') }}"
                    required>
        </div>
        <div>
            <label for="fecha_fin">Fecha de Fin:</label>
            <input  type="date"
                    id="fecha_fin"
                    name="fecha_fin"
                    value="{{ old('fecha_fin', $proyecto->fecha_fin ?? '') }}"
                    required>
        </div>
        <div>
            <label for="anio">Selecciona un año:</label>
            <input  type="number"
                    id="anio"
                    name="anio"
                    min="2010" max="2100" step="1"
                    placeholder="2025"
                    value="{{ old('anio', $proyecto->anio ?? date('Y')) }}">
        </div>
        <div>
            <label for="costo">Costo:</label>
            <input  type="number" step="0.01" id="costo" name="costo"
                    value="{{ old('costo', $proyecto->costo ?? '')}}"
                    required>
        </div>
        <button type="submit">{{isset($proyecto)?'Actualizar':'Crear'}} Proyecto</button>
    </form>
    <a href="{{route('inicio')}}">ir a inicio</a>

    <!-- Modal genérico para agregar tipología -->
    @include('components.opcion-select', [
        'modalId' => 'tipologia',
        'title' => 'Tipología',
        'routeName' => 'tipologia'
    ])

    <!-- Modal genérico para agregar otra opción -->
    @include('components.opcion-select', [
        'modalId' => 'procedencia',
        'title' => 'Procedencia',
        'routeName' => 'procedencia'
    ])

    @include('components.opcion-select', [
        'modalId' => 'procedenciaCodigo',
        'title' => 'Procedencia_Codigo',
        'routeName' => 'procedencia.codigo'
    ])

    @include('components.opcion-select', [
        'modalId' => 'programa',
        'title' => 'Programa',
        'routeName' => 'programa'
    ])

    {{-- <script src="{{ asset('js/script.js') }}"></script> --}}
    <script>
        // Script para manejar el modal
        function abrirModal(modalId) {
            const modal = document.getElementById(`modal-${modalId}`);
            modal.style.display = "block";
        }

        function cerrarModal(modalId) {
            const modal = document.getElementById(`modal-${modalId}`);
            modal.style.display = "none";
        }

        // Asignar eventos a los botones de apertura y cierre
        document.getElementById('abrirModalTipologia').onclick = function() {
            abrirModal('tipologia');
        };
        document.getElementById('abrirModalProcedencia').onclick = function() {
            abrirModal('procedencia');
        };
        document.getElementById('abrirModalProcedenciaCodigo').onclick = function() {
            abrirModal('procedenciaCodigo');
        };
        document.getElementById('abrirModalPrograma').onclick = function() {
            abrirModal('programa');
        };
        document.querySelectorAll('.close').forEach(function(closeBtn) {
            closeBtn.onclick = function() {
                const modalId = this.closest('.modal').id.replace('modal-', '');
                cerrarModal(modalId);
            };
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                const modalId = event.target.id.replace('modal-', '');
                cerrarModal(modalId);
            }
        };

        // Añadir inputs para investigadores
        const container = document.getElementById('investigadoresContainer');
        const addButton = document.querySelector('.añadir-investigador');
        // const proyecto = json(proyecto);

        function agregarInvestigadorCampo() {

            const newInput = document.createElement('div');
            newInput.classList.add('investigador-input');
            newInput.innerHTML = `
                <input type="text" name="investigadores_nombres[]" placeholder="Nombre del investigador" required>
                <button type="button" class="eliminar-investigador">-</button>
            `;
            container.appendChild(newInput);

            const deleteButton = newInput.querySelector('.eliminar-investigador');
            deleteButton.addEventListener('click', eliminarCampoInvestigador);
        }

        function eliminarCampoInvestigador(event) {
                container.removeChild(event.target.parentElement);
            }

        addButton.addEventListener('click', agregarInvestigadorCampo);
    </script>
</body>
</html>
