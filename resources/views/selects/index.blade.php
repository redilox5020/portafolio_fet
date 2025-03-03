<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar</title>
</head>
<body>
    <h1>Crear {{$select}}</h1>
    <form action="{{ route('tipologia.store') }}" method="post">
        @csrf
        <div>
            <label for="opcion">{{$select}}</label>
            <input type="text" name="opcion" required>
        </div>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
