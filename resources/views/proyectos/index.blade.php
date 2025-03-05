@extends("layouts.dashboard")
@section("main")
@if (isset($programa))
    <h3 class="titulo-proyectos">Proyectos de {{ $programa->nombre }} @isset($anio) - Año {{ $anio }} @endisset</h3>
@elseif (isset($search))
    <h3 class="titulo-proyectos">Proyectos filtrados por: <code>{{ $search }}</code></h3>
@elseif (isset($codigo))
    <h3 class="titulo-proyectos">Proyectos filtrados por grupo de códigos: <code>{{ $codigo }}</code></h3>
@else
    <h3 class="titulo-proyectos">Todos los proyectos</h3>
@endif

<section class="table-container">
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

</section>
{{ $proyectos->links('pagination::bootstrap-4') }}
<a href="{{route('inicio')}}">ir a inicio</a>

@endsection
@section("css")
<style>
    .titulo-proyectos{
        margin-top: 15px
    }
</style>
@endsection
{{-- @extends("layouts.dashboard")
@section("main")
@endsection
@section('css')
@endsection
@section('scripts')
@endsection --}}
