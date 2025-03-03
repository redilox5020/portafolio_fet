<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mostrar proyecto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div>
        <h1>{{$proyecto->nombre}}</h1>
        <p>{{$proyecto->objetivo_general}}</p>
        <p><Strong>Programa</Strong>: {{$proyecto->programa->nombre}}</p>
        <p><Strong>Procedencia</Strong>: {{$proyecto->procedencia->opcion}}</p>
        <p><Strong>Tipologia</Strong>: {{$proyecto->tipologia->opcion}}</p>
        <p><Strong>Duracion</Strong>: {{$proyecto->duracion}}</p>
        <p><Strong>Costo</Strong>: ${{ number_format($proyecto->costo, 2, ',', '.') }}</p>
        @php
         $indexInvestigadores = 1;
        @endphp
        @foreach($proyecto->investigadores as $investigador)
            <p><Strong>Investigador {{$indexInvestigadores}}</Strong>: {{$investigador->nombre}}</p>
            @php
                $indexInvestigadores++;
            @endphp
        @endforeach
    </div>
    <a href="{{route('inicio')}}">ir a inicio</a>
</body>
</html>
