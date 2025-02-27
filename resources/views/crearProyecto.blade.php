<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Proyecto</title>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
        <h1>Crear Proyecto</h1>
        <form action="{{ route('proyectos.store') }}" method="POST">
            @csrf
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="objetivo_general">Objetivo General:</label>
                <input type="text" id="objetivo_general" name="objetivo_general" required>
            </div>
            <div>
                <label for="programa_id">Programa:</label>
                <select id="programa_id" name="programa_id" required>
                    @foreach($programas as $programa)
                        <option value="{{ $programa->id }}">{{ $programa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="procedencia_id">Procedencia:</label>
                <select id="procedencia_id" name="procedencia_id" required>
                    @foreach($procedencias as $procedencia)
                        <option value="{{ $procedencia->id }}">{{ $procedencia->opcion }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="procedencia_codigo_id">Procedencia Código:</label>
                <select id="procedencia_codigo_id" name="procedencia_codigo_id" required>
                    @foreach($procedenciaCodigos as $procedenciaCodigo)
                        <option value="{{ $procedenciaCodigo->id }}">{{ $procedenciaCodigo->opcion }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tipologia_id">Tipología:</label>
                <select id="tipologia_id" name="tipologia_id" required>
                    @foreach($tipologias as $tipologia)
                        <option value="{{ $tipologia->id }}">{{ $tipologia->opcion }}</option>
                    @endforeach
                </select>
            </div>
            <div id="investigadoresContainer">
                <div class="investigador-input">
                    <input type="text" name="investigadores[]" placeholder="Nombre del investigador" required>
                    <button type="button" class="añadir-investigador">+</button>
                </div>
            </div>
            <div>
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div>
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>
            <div>
                <label for="costo">Costo:</label>
                <input type="number" step="0.01" id="costo" name="costo" required>
            </div>
            <button type="submit">Crear Proyecto</button>
        </form>

        <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
