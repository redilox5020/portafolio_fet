@extends("layouts.dashboard_admin")
@section("main")
<header>
    <h1>FUNDACIÓN ESCUELA TECNOLÓGICA DE NEIVA - FET</h1>
    <h2>VICERRECTORÍA DE INVESTIGACIÓN Y EXTENSIÓN</h2>
</header>
<section class="info">
    <div>
        <form class="search-form" action="{{route('proyectos.por.grupo.codigo')}}" method="get">
            <h2>Buscar Código</h2>
            <div class="form-group">
                <label for="programa_sufijo">Programa:</label>
                <select class="form-select" id="programa_sufijo" name="programa_sufijo" required>
                    @foreach($programas as $programa)
                    <option value="{{ $programa->sufijo }}">{{ $programa->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="procedencia_codigo_id">Procedencia Código:</label>
                <select class="form-select" id="procedencia_codigo_id" name="procedencia_codigo_id" required>
                    @foreach($procedenciaCodigos as $procedenciaCodigo)
                    <option value="{{ $procedenciaCodigo->id }}">{{ $procedenciaCodigo->opcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipologia_id">Tipología:</label>
                <select class="form-select" id="tipologia_id" name="tipologia_id" required>
                    @foreach($tipologias as $tipologia)
                    <option value="{{ $tipologia->id }}">{{ $tipologia->opcion }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="anio">Año:</label>
                <input class="form-control" type="number" id="anio" name="anio" min="2010" max="2100" step="1" placeholder="2025" value="{{date('Y')}}">
            </div>
            <div class="form-group">
                <button class="btn btn-dark" type="submit">Buscar</button>
            </div>
        </form>
    </div>
</section>
<section class="table-container">
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
                        <strong>{{ $dato->programa->nombre }}</strong>
                    </a>
                </td>
                <td>{{ $totalesPorPrograma[$dato->programa_id] }}</td>
            </tr>
            @php
            $currentPrograma = $dato->programa->nombre;
            @endphp
            @endif
            @if ($dato->anio)
            <tr style="background-color: #f2f2f2;">
                <td class="subcategoria">
                    <a href="{{ route('proyectos.por.anio', ['programa'=> $dato->programa->id, 'anio'=> $dato->anio]) }}">{{ $dato->anio }}</a>
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
</section>
<a href="{{route('proyectos.store')}}">Registrar Proyecto</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
<style>
    .search-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 10px;
        align-items: center
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    .form-group:last-child{
        align-self: end;
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
    th {
        background-color: #4CAF50;
        background: #8bc34a;
    }
</style>
@endsection
@section('scripts')
<script></script>
@endsection
