@extends("layouts.dashboard_admin")
@section("main")
<header>
    <h1>FUNDACIÓN ESCUELA TECNOLÓGICA DE NEIVA - FET</h1>
    <h2>VICERRECTORÍA DE INVESTIGACIÓN Y EXTENSIÓN</h2>
</header>
<!-- Formulario de Búsqueda -->
<section class="info mb-4">
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
                <label for="procedencia_id">Procedencia:</label>
                <select class="form-select" id="procedencia_id" name="procedencia_id" required>
                    @foreach($procedencias as $procedencia)
                    <option value="{{ $procedencia->id }}">{{ $procedencia->opcion }}</option>
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
<!-- Tabs de Navegación -->
<div class="mb-4 border-bottom">
    <ul class="nav nav-tabs" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-toggle="tab" data-target="#general" type="button" role="tab">
                <i class="fas fa-chart-line me-2"></i>General
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="programas-tab" data-toggle="tab" data-target="#programas" type="button" role="tab">
                <i class="fas fa-graduation-cap me-2"></i>Programas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="investigadores-tab" data-toggle="tab" data-target="#investigadores" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Investigadores
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="recursos-tab" data-toggle="tab" data-target="#recursos" type="button" role="tab">
                <i class="fas fa-file-alt me-2"></i>Recursos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tabla-tab" data-toggle="tab" data-target="#tabla" type="button" role="tab">
                <i class="fas fa-table me-2"></i>Tabla Resumen
            </button>
        </li>
    </ul>
</div>

<!-- Contenido de los Tabs -->
<div class="tab-content" id="dashboardTabsContent">

    <!-- TAB: GENERAL -->
    <div class="tab-pane fade show active" id="general" role="tabpanel">


        <!-- KPIs Principales -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proyectos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGeneral }}</div>
                                <small class="text-muted">Proyectos activos</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-folder fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Investigadores</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $investigadoresActivos }}</div>
                                <small class="text-muted">Investigadores activos</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Productos Generados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productosGenerados }}</div>
                                <small class="text-muted">Productos científicos</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-award fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Inversión Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($inversionTotal / 1000000, 1) }}M</div>
                                <small class="text-muted">En proyectos activos</small>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos Generales -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Proyectos por Año</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartProyectosPorAnio" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Distribución por Tipología</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartTipologia" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Proyectos por Procedencia</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartProcedencia" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: PROGRAMAS -->
    <div class="tab-pane fade" id="programas" role="tabpanel">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Proyectos por Programa</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartProgramas" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Inversión por Programa</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartInversion" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Productos por Tipo</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartProductos" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: INVESTIGADORES -->
    <div class="tab-pane fade" id="investigadores" role="tabpanel">
        <!-- KPIs de Investigadores -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Investigadores</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInvestigadores }}</div>
                        <small class="text-muted">En base de datos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Investigadores Activos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $investigadoresActivos }}</div>
                        <small class="text-muted">Con proyectos vigentes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Histórico Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $investigadoresHistoricos }}</div>
                        <small class="text-muted">{{ $investigadoresRevinculados }} revinculados</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos de Investigadores -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Evolución de Investigadores</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartEvolucionInvestigadores" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

<div class="row">
    <!-- Gráfico más pequeño -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Estado de Investigadores</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="chartEstadoInvestigadores" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Métricas más amplias -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Métricas de Trazabilidad</h6>
            </div>
            <div class="card-body">
                <!-- Grid de métricas -->
                <div class="row">
                    <!-- Revinculados -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-primary text-white rounded">
                            <h2 class="font-weight-bold mb-0">{{ $investigadoresRevinculados }}</h2>
                            <small>Revinculados</small>
                            <div class="mt-2 d-flex justify-content-around">
                                <span class="badge badge-light">
                                    {{ $investigadoresHistoricos > 0 ? round(($investigadoresRevinculados / $investigadoresHistoricos) * 100) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Solo Históricos (nunca regresaron) -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="text-center p-3 bg-warning text-white rounded">
                            <h2 class="font-weight-bold mb-0">{{ $investigadoresHistoricos - $investigadoresRevinculados }}</h2>
                            <small>Solo Históricos</small>
                            <div class="mt-2 d-flex justify-content-around">
                                <span class="badge badge-light">No revinculados</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total Participaciones -->
                    <div class="col-md-6 col-sm-12 mb-3">
                        <div class="text-center p-3 bg-success text-white rounded">
                            <h2 class="font-weight-bold mb-0">{{ $totalParticipaciones }}</h2>
                            <small>Total de Participaciones</small>
                            <div class="mt-2 d-flex justify-content-around">
                                <span class="badge badge-light">
                                    <i class="fas fa-check-circle"></i> {{ $participacionesActivas }}
                                </span>
                                <span class="badge badge-light">
                                    <i class="fas fa-history"></i> {{ $participacionesHistoricas }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Promedios -->
                    <div class="col-md-6 mb-3">
                        <div class="text-center p-3 bg-info text-white rounded">
                            <h3 class="font-weight-bold mb-0">{{ $promedioProyectosPorInvestigador }}</h3>
                            <small>Proyectos/Investigador</small>
                            <div class="mt-1">
                                <small class="badge badge-light">Activos</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="text-center p-3 bg-secondary text-white rounded">
                            <h3 class="font-weight-bold mb-0">{{ $promedioParticipacionesHistoricas }}</h3>
                            <small>Participaciones/Histórico</small>
                            <div class="mt-1">
                                <small class="badge badge-light">Promedio</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nota explicativa -->
                <div class="alert alert-info mt-3 mb-0" role="alert">
                    <small>
                        <i class="fas fa-info-circle"></i>
                        <strong>Nota:</strong> Un investigador puede tener múltiples participaciones en diferentes proyectos.
                        Los históricos son aquellos que alguna vez fueron desvinculados.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Top 10 Investigadores -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Top 10 Investigadores más Activos</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Investigador</th>
                                        <th class="text-center">Proyectos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topInvestigadores as $index => $investigador)
                                    <tr>
                                        <td class="font-weight-bold">{{ $index + 1 }}</td>
                                        <td>{{ $investigador->nombre }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-success badge-pill">{{ $investigador->proyectos }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: RECURSOS -->
    <div class="tab-pane fade" id="recursos" role="tabpanel">
        <!-- KPIs de Archivos -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Archivos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $archivosStats['total'] }}</div>
                        <small class="text-muted">Documentos almacenados</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Cloudinary</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $archivosStats['cloudinary'] }}</div>
                        <small class="text-muted">Archivos en la nube</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Local</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $archivosStats['local'] }}</div>
                        <small class="text-muted">Almacenamiento local</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tamaño Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @php
                                $size = $archivosStats['tamanioTotal'];
                                $units = ['B', 'KB', 'MB', 'GB'];
                                $i = 0;
                                while ($size > 1024 && $i < count($units) - 1) {
                                    $size /= 1024;
                                    $i++;
                                }
                                echo number_format($size, 2) . ' ' . $units[$i];
                            @endphp
                        </div>
                        <small class="text-muted">Espacio utilizado</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos de Recursos -->
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Archivos por Almacenamiento</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartArchivos" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Archivos por Entidad</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartArchivosPorEntidad" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Archivos más Grandes -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Archivos más Grandes</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Tipo</th>
                                        <th>Destino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $archivosGrandes = DB::table('archivos')
                                            ->orderByDesc('tamanio')
                                            ->limit(10)
                                            ->get();
                                    @endphp
                                    @foreach($archivosGrandes as $archivo)
                                    <tr>
                                        <td>{{ $archivo->nombre_original }}</td>
                                        <td>
                                            @php
                                                $size = $archivo->tamanio;
                                                $units = ['B', 'KB', 'MB', 'GB'];
                                                $i = 0;
                                                while ($size > 1024 && $i < count($units) - 1) {
                                                    $size /= 1024;
                                                    $i++;
                                                }
                                                echo number_format($size, 2) . ' ' . $units[$i];
                                            @endphp
                                        </td>
                                        <td>{{ strtoupper(pathinfo($archivo->nombre_original, PATHINFO_EXTENSION)) }}</td>
                                        <td><span class="badge badge-{{ $archivo->driver == 'cloudinary' ? 'success' : 'warning' }}">{{ ucfirst($archivo->driver) }}</span></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: TABLA RESUMEN -->
    <div class="tab-pane fade" id="tabla" role="tabpanel">
        <section class="table-container">
            <table class="table table-striped">
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
    </div>
</div>

<div class="mt-4">
    <a href="{{route('proyectos.store')}}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Registrar Proyecto
    </a>
</div>

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
    .nav-tabs .nav-link {
        color: #6c757d;
    }
    .nav-tabs .nav-link.active {
        color: #4CAF50;
        border-color: #dee2e6 #dee2e6 #fff;
        border-bottom: 2px solid #4CAF50;
    }
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard-charts.js') }}"></script>
<script>
    $(document).ready(function() {
        const dashboardData = {
            proyectosPorAnio: @json($proyectosPorAnio),
            proyectosPorTipologia: @json($proyectosPorTipologia),
            proyectosPorProcedencia: @json($proyectosPorProcedencia),
            programasData: @json($programasData),
            productosPorTipo: @json($productosPorTipo),
            evolucionInvestigadores: @json($evolucionInvestigadores),
            investigadoresActivos: {{ $investigadoresActivos }},
            investigadoresHistoricos: {{ $investigadoresHistoricos }},
            investigadoresRevinculados: {{ $investigadoresRevinculados }},
            archivosCloudinary: {{ $archivosStats['cloudinary'] }},
            archivosLocal: {{ $archivosStats['local'] }},
            archivosPorProyecto: {{ $archivosStats['porProyecto'] }},
            archivosPorProducto: {{ $archivosStats['porProducto'] }}
        };

        let programasChartLoaded = false;
        let investigadoresChartLoaded = false;
        let recursosChartLoaded = false;

        setTimeout(function() {
            initDashboardCharts(dashboardData);
        }, 100);

        $('#programas-tab').on('shown.bs.tab', function (e) {
            if (!programasChartLoaded) {
                setTimeout(function() {
                    crearGraficoProgramas(dashboardData.programasData);
                    crearGraficoInversion(dashboardData.programasData);
                    crearGraficoProductos(dashboardData.productosPorTipo);
                    programasChartLoaded = true;
                }, 100);
            }
        });

        $('#investigadores-tab').on('shown.bs.tab', function (e) {
            if (!investigadoresChartLoaded) {
                setTimeout(function() {
                    crearGraficoEvolucionInvestigadores(dashboardData.evolucionInvestigadores);
                    crearGraficoEstadoInvestigadores(
                        dashboardData.investigadoresActivos,
                        dashboardData.investigadoresHistoricos,
                        dashboardData.investigadoresRevinculados
                    );
                    investigadoresChartLoaded = true;
                }, 100);
            }
        });

        $('#recursos-tab').on('shown.bs.tab', function (e) {
            if (!recursosChartLoaded) {
                setTimeout(function() {
                    crearGraficoArchivos(
                        dashboardData.archivosCloudinary,
                        dashboardData.archivosLocal
                    );
                    crearGraficoArchivosPorEntidad(
                        dashboardData.archivosPorProyecto,
                        dashboardData.archivosPorProducto
                    );
                    recursosChartLoaded = true;
                }, 100);
            }
        });
    });
</script>
@endsection
