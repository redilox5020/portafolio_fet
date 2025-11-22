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
        <div id="session-alert" class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="productoTable" width="100%" cellspacing="0">
            <colgroup>
                @empty($proyecto)
                    <col style="width: 10%;">
                    <col style="width: 15%;">
                    <col style="width: 40%;">
                    <col style="width: 18%;">
                    <col style="width: 8%;">
                    <col style="width: 9%;">
                @else
                    <col style="width: 12%;">
                    <col style="width: 45%;">
                    <col style="width: 25%;">
                    <col style="width: 8%;">
                    <col style="width: 10%;">
                @endempty
            </colgroup>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Titulo</th>
                    @empty($proyecto)
                    <th>Proyecto</th>
                    @endempty
                    <th>Tipo</th>
                    <th>Recurso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
@push('style')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .titulo-proyectos {
            margin-top: 15px
        }
    </style>
@endpush
@push('scripts')
    <!-- Plugins Datatable -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let proyecto = @json($proyecto ?? null);
            console.log(proyecto)
            const table = $('#productoTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('productos.index') }}",
                    type: "GET",
                    data: function(d) {
                        if(proyecto != null) d.proyecto_id = proyecto.id
                    },
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Accept', 'application/json');
                    },
                    error: function(xhr) {
                        if (xhr.status === 401) {
                            alert('Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
                            window.location.href = '{{ route('login') }}';
                        } else {
                            console.error("Error desconocido en DataTables:", xhr);
                        }
                    }
                },
                columns: [{
                        data: 'codigo',
                        name: 'codigo'
                    },
                    {
                        data: 'titulo',
                        name: 'titulo',
                        orderable: true,
                        searchable: true
                    },
                    @empty($proyecto)
                    {
                        data: "proyecto_nombre",
                        name: 'proyecto',
                        orderable: false,
                        searchable: false
                    },
                    @endempty
                    {
                        data: "tipologia.opcion",
                        name: 'tipo',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'enlace',
                        name: 'recurso',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                    },
                    {
                        data: 'acciones',
                        name: 'acciones',
                        orderable: false,
                        searchable: false
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
                order: [
                    [0, 'desc']
                ],
            });
            $(document).on("click", ".delete-btn", function() {
                let userId = $(this).data("id");
                let deleteUrl = "{{ route('productos.delete', ':id') }}".replace(':id', userId);
                $("#deleteForm").attr("action", deleteUrl);
            });
        })
    </script>
@endpush
