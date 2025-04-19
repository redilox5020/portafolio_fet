@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 id="titulo-proyectos" class="h3 mb-2 text-gray-800">
                @if (request('codigo_grupo'))
                    Proyectos filtrados por grupo de códigos: <code>{{ request('codigo_grupo') }}</code>
                @elseif(request('programa_nombre') && request('anio'))
                    Proyectos de {{ request('programa_nombre') }} - Año {{ request('anio') }}
                @elseif(request('programa_nombre'))
                    Proyectos de {{ request('programa_nombre') }}
                @elseif(request('search'))
                    Proyectos filtrados por: <code>{{ request('search') }}</code>
                @else
                    Todos los proyectos
                @endif
            </h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="proyectosTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre del Proyecto</th>
                            <th>Programa</th>
                            <th>Duración</th>
                            <th>Costo (COP)</th>
                            <th>Fecha de publicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <a href="{{ route('inicio') }}" class="btn btn-secondary mt-3">Volver al inicio</a>

        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .titulo-proyectos {
            margin-top: 15px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const initialSearch = urlParams.get('search') || '';
            const titulo = $('#titulo-proyectos');
            let isInitialLoad = true;

            const table = $('#proyectosTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('proyectos') }}",
                    type: "GET",
                    data: function(d) {

                        if (isInitialLoad && initialSearch) {
                            d.search.value = initialSearch;
                            isInitialLoad = false;
                        }
                        @if (!is_null(request('programa')))
                            d.programa_id = "{{ request('programa') }}";
                        @endif

                        @if (!is_null(request('programa')) && !is_null(request('anio')))
                            d.anio = "{{ request('anio') }}";
                        @endif

                        @if (!is_null(request('codigo_grupo')))
                            d.codigo_grupo = "{{ request('codigo_grupo') }}";
                        @endif

                    }
                },
                columns: [{
                        data: 'codigo',
                        name: 'codigo'
                    },
                    {
                        data: 'nombre_link',
                        name: 'nombre',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'programa',
                        name: 'programa',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'duracion',
                        name: 'duracion'
                    },
                    {
                        data: 'costo_formateado',
                        name: 'costo',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'acciones',
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                lengthMenu: [
                    [10, 25, 50],
                    [10, 25, 50]
                ],
                pageLength: 10,
                searchDelay: 500,
                order: [
                    [5, 'desc']
                ],
            }).search(initialSearch);
            if (initialSearch) {
                updateTitleAndUrl(initialSearch);
            }

            function updateTitleAndUrl(searchValue) {
                const url = new URL(window.location);

                if (searchValue && searchValue.length >= 3) {
                    titulo.html(`Proyectos filtrados por: <code>${searchValue}</code>`);
                    url.searchParams.set('search', searchValue);
                } else {
                    // Restaurar título original basado en otros parámetros
                    @if (request('codigo_grupo'))
                        titulo.html(
                            `Proyectos filtrados por grupo de códigos: <code>{{ request('codigo_grupo') }}</code>`
                            );
                    @elseif (request('programa_nombre') && request('anio'))
                        titulo.html(`Proyectos de {{ request('programa_nombre') }} - Año {{ request('anio') }}`);
                    @elseif (request('programa_nombre'))
                        titulo.html(`Proyectos de {{ request('programa_nombre') }}`);
                    @else
                        titulo.text('Todos los proyectos');
                    @endif

                    url.searchParams.delete('search');
                }

                window.history.pushState({}, '', url);
            }

            // Escuchar el evento de búsqueda de DataTables; Incluye la accion de limpiar el input
            table.on('search.dt', function() {
                const searchValue = table.search();
                updateTitleAndUrl(searchValue);
            });

            // Manejar navegación con botones atrás/adelante
            window.addEventListener('popstate', function() {
                const newSearch = new URLSearchParams(window.location.search).get('search') || '';
                const currentSearch = table.search();

                if (newSearch !== currentSearch) {
                    table.search(newSearch).draw();
                    updateTitleAndUrl(newSearch);
                }
            });

            $(document).on("click", ".delete-btn", function() {
                let userId = $(this).data("id");
                let deleteUrl = "{{ route('proyectos.delete', ':id') }}".replace(':id', userId);
                $("#deleteForm").attr("action", deleteUrl);
            });
        });
    </script>
@endsection
