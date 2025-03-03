<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programas</title>
    <!-- Custom fonts for this template-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .subcategoria {
            padding-left: 20px;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        a:hover {
            text-decoration: underline;
        }

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
            max-width: max-content;
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
    <div style="display: flex; justify-content: space-between">
        <h1>Programas</h1>
        <button type="button" id="abrirModal">Buscar Proyectos</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Programas</th>
                <th>Cuenta de Proyectos</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentPrograma = null;
            @endphp
            @foreach($datos as $dato)
                @if ($dato->programa->nombre != $currentPrograma)
                    <tr>
                        <td>
                            <a href="{{ route('proyectos.por.programa', $dato->programa->id) }}">
                                <strong>
                                    {{ $dato->programa->nombre }}
                                </strong>
                            </a>
                        </td>
                        <td>{{ $totalesPorPrograma[$dato->programa_id] }}</td>
                    </tr>
                    @php
                        $currentPrograma = $dato->programa->nombre;
                    @endphp
                @endif
                @if ($dato->anio)
                    <tr>
                        <td class="subcategoria">
                            <a href="{{ route('proyectos.por.anio',
                                ['programa'=> $dato->programa->id, 'anio'=> $dato->anio]
                                ) }}">{{ $dato->anio }}</a>
                        </td>
                        <td>{{ $dato->cuenta_de_programa }}</td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td>
                    <a href="{{ route('proyectos')}}">
                        <strong>Total Resultado</strong>
                    </a>
                </td>
                <td>{{ $totalGeneral }}</td>
            </tr>
        </tbody>
    </table>
    {{-- {{ $datos->links('pagination::bootstrap-4') }} --}}
    <a href="{{route('proyectos.store')}}">Registrar Proyecto</a>
    <div class="modal">
        <div class="modal-content">
            <div style="display: flex;gap: 10px;flex-direction: row-reverse;">
                <div>
                    <h2>Buscar Codigo</h2>
                    <form action="{{route('proyectos.por.grupo.codigo')}}" method="get">
                        <div>
                            <label for="programa_sufijo">Programa:</label>
                            <select id="programa_sufijo" name="programa_sufijo" required>
                                @foreach($programas as $programa)
                                    <option value="{{ $programa->sufijo }}">{{ $programa->nombre }}</option>
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
                        <div>
                            <label for="anio">Selecciona un año:</label>
                            <input type="number" id="anio" name="anio" min="2010" max="2100" step="1" placeholder="2025" value="{{date('Y')}}">
                        </div>
                        <button type="submit">Buscar</button>
                    </form>
                </div>
                <div>
                    <h2>Buscar</h2>
                    <form action="{{route('proyectos.busqueda')}}" method="get">
                        <input type="text" name="search" value="{{ request('search') }}" minlength="4" required placeholder="Ingresa una palabra clave">
                        <button type="submit">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let modal = document.querySelector('.modal');
        let btnAbrir = document.getElementById('abrirModal');

        btnAbrir.onclick = ()=>{
            modal.style.display = 'block';
        }

        window.onclick = (event) => {
            if(event.target.classList.contains('modal')){
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>
