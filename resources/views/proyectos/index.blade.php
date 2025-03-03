<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
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
    </style>
</head>
<body>
    @if (!isset($programa))
        <h1>Todos los proyectos</h1>
    @else
        <h1> Proyectos de {{ $programa->nombre }} @if(isset($anio)) - Año {{ $anio }} @endif</h1>
    @endif
    <table>
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Nombre del Proyecto</th>
                <th>Duracion</th>
                <th>Costo (COP)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectos as $proyecto)
                <tr>
                    <td>{{$proyecto->codigo}}</td>
                    <td>
                        <a href="{{ route('proyecto.por.codigo', $proyecto->codigo) }}">
                            {{ $proyecto->nombre }}
                        </a>
                    </td>
                    <td>{{ $proyecto->duracion }}</td>
                    <td>${{ number_format($proyecto->costo, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{route('proyectos.edit', $proyecto->codigo)}}">Editar</a>
                        <a href="#">Eliminar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $proyectos->links('pagination::bootstrap-4') }}
    <a href="{{route('inicio')}}">ir a inicio</a>
</body>
</html>
