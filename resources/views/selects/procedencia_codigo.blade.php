@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="h3 mb-2 text-gray-800">Procedencia Codigo Opciones</h3>
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
                <div id="session-alert" class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="procedenciaCodigoTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Opcion</th>
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
            margin-top: 15px
        }
    </style>
@endsection
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const table = $('#procedenciaCodigoTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('procedencia.codigo.index') }}",
                    type: "GET"
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'opcion',
                        name: 'opcion',
                        orderable: true,
                        searchable: true
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
                order: [
                    [0, 'desc']
                ],
            });
            $(document).on("click", ".delete-btn", function() {
                let userId = $(this).data("id");
                let deleteUrl = "{{ route('procedencia.codigo.delete', ':id') }}".replace(':id', userId);
                $("#deleteForm").attr("action", deleteUrl);
            });
        })

    </script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
