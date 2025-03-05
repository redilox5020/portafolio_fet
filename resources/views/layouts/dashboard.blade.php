<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programas</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    @yield("css")
</head>
<body>
    <header>
        <h1>FUNDACIÓN ESCUELA TECNOLÓGICA DE NEIVA - FET</h1>
        <h2>VICERRECTORÍA DE INVESTIGACIÓN Y EXTENSIÓN</h2>
    </header>
    <section class="info">
        <div style="display: flex;gap: 10px;justify-content: space-between; align-items: center">
            <div>
                <h2>Buscar Codigo</h2>
                <form class="row g-3" action="{{route('proyectos.por.grupo.codigo')}}" method="get">
                    <div class="col-auto form-floating">
                        <select class="form-select" id="programa_sufijo" name="programa_sufijo" required>
                            @foreach($programas as $programa)
                            <option value="{{ $programa->sufijo }}">{{ $programa->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="programa_sufijo">Programa:</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="procedencia_codigo_id" name="procedencia_codigo_id" required>
                            @foreach($procedenciaCodigos as $procedenciaCodigo)
                            <option value="{{ $procedenciaCodigo->id }}">{{ $procedenciaCodigo->opcion }}</option>
                            @endforeach
                        </select>
                        <label for="procedencia_codigo_id">Procedencia Código:</label>
                    </div>
                    <div class="col-auto form-floating">
                        <select class="form-select" id="tipologia_id" name="tipologia_id" required>
                            @foreach($tipologias as $tipologia)
                            <option value="{{ $tipologia->id }}">{{ $tipologia->opcion }}</option>
                            @endforeach
                        </select>
                        <label for="tipologia_id">Tipología:</label>
                    </div>
                    <div class="col-auto form-floating">
                        <input class="form-control w-100" type="number" id="anio" name="anio" min="2010" max="2100" step="1" placeholder="2025" value="{{date('Y')}}">
                        <label for="anio">Año: </label>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-dark h-100" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
            <div style="margin: 0 auto;">
                <h2>Buscar</h2>
                <form action="{{route('proyectos.busqueda')}}" method="get">
                    <div class="input-group">
                        <input class="form-control" type="text" name="search" value="{{ request('search') }}" minlength="4" required placeholder="Ingresa una palabra clave">
                        <button class="btn btn-dark h-100" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>


    @yield("main")


    @yield("scripts")
</body>
</html>
