<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard FET</title>

    <!-- Custom fonts for this template-->
    <!--<link href="{{asset("vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <style>
        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: -1px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .input-group>.form-control, .input-group>.form-select {
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            min-width: 0;
        }
        .form-select {
            display: block;
            width: 100%;
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .form-select:focus {
            color: #6e707e;
            background-color: #fff;
            border-color: #bac8f3;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .form-control[type="file"]:not(:disabled):not([readonly]) {
            cursor: pointer;
        }

        .form-control[type="file"]:focus {
            color: #6e707e;
            background-color: #fff;
            border-color: #bac8f3;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-control[type="file"]::file-selector-button,
        .form-control[type="file"]::-webkit-file-upload-button {
            padding: 0.375rem 0.75rem;
            margin: -0.375rem -0.75rem;
            margin-right: 0.75rem;
            color: #31633c;
            font-weight: bold;
            background-color: #e5f5e5;
            border: 0;
            border-right: 1px solid #ced4da;
            border-radius: 0;
            transition: background-color 0.15s ease-in-out;
            pointer-events: none;
        }

        .form-control[type="file"]:hover:not(:disabled):not([readonly])::file-selector-button,
        .form-control[type="file"]:hover:not(:disabled):not([readonly])::-webkit-file-upload-button {
            background-color: #d7e9d7;
        }
        /* GAP para Bootstrap 4.6 — Estilo moderno inspirado en BS5 */
        .gap-0 { gap: 0 !important; }
        .gap-1 { gap: 0.25rem !important; } /* 4px */
        .gap-2 { gap: 0.5rem !important; }  /* 8px */
        .gap-3 { gap: 1rem !important; }    /* 16px */
        .gap-4 { gap: 1.5rem !important; }  /* 24px */
        .gap-5 { gap: 3rem !important; }    /* 48px */

        .row-gap-1 { row-gap: 0.25rem !important; }
        .row-gap-2 { row-gap: 0.5rem !important; }
        .row-gap-3 { row-gap: 1rem !important; }
        .row-gap-4 { row-gap: 1.5rem !important; }
        .row-gap-5 { row-gap: 3rem !important; }

        .column-gap-1 { column-gap: 0.25rem !important; }
        .column-gap-2 { column-gap: 0.5rem !important; }
        .column-gap-3 { column-gap: 1rem !important; }
        .column-gap-4 { column-gap: 1.5rem !important; }
        .column-gap-5 { column-gap: 3rem !important; }
        .form-check {
            display: block;
            min-height: 1.5rem;
            padding-left: 1.5em;
            margin-bottom: .125rem;
        }
        .form-check-input:checked[type=radio] {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e")
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-check-input[type=radio] {
            border-radius: 50%;
        }
        .form-check .form-check-input {
            float: left;
            margin-left: -1.5em;
        }

        .form-check-input {
            width: 1em;
            height: 1em;
            margin-top: .25em;
            vertical-align: top;
            background-color: #fff;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            border: 1px solid rgba(0, 0, 0, .25);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
        .badge{
            color: #fff
        }

        hr {
            margin: 1rem 0;
            color: inherit;
            background-color: currentColor;
            border: 0;
            opacity: .25;
        }

        hr:not([size]) {
            height: 1px;
        }
        /* label Form */
        .group-form {
            padding: 10px 0;
            font-weight: 600;
        }

        .group-form label {
            background-color: #ededed;
            padding: 5px;
            text-align: center;
            border: 1px solid #cdd3d9;
            border-radius: 5px 0 0 5px;
            margin: 0;
            width: clamp(106px, 25%, 180px);
            overflow-wrap: break-word;
            word-break: break-word;
        }
        .form-control {height: auto !important;}
    </style>

    <link href="{{asset("css/sb-admin-2.min.css")}}" rel="stylesheet">

    @yield("css")


</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <img src="{{ asset("img/Logo-lg-FET-sidebar.png") }}" alt="" width="100%">
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('inicio')}}">
                <i class="fa-solid fa-backward"></i>
                <span>Dashboard</span></a>
        </li>

        @can('admin-access')
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Usuarios
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('users')}}">
                <i class="fa-solid fa-users"></i>
                <span>Listar Usuarios</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{route('investigador.index')}}">
                <i class="fa-solid fa-users"></i>
                <span>Investigadores</span></a>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Rutas y Permisos
        </div>
        <li class="nav-item">
            <a class="nav-link" href="{{route('roles.index')}}">
                <i class="fa-solid fa-table-list"></i>
                <span>Gestión Roles</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('routes.index')}}">
                <i class="fa-solid fa-table-list"></i>
                <span>Gestión Rutas</span></a>
        </li>
        @endcan
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Proyectos
        </div>


        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <span>Tipologia</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">CRUD Tipologia: </h6>
                    <a class="collapse-item" href="{{route('tipologia.index')}}">Listar</a>
                    @can('tipologia.create')
                    <a class="collapse-item" data-toggle="modal" data-target="#modal-tipologia">Crear</a>
                    @endcan
                </div>
            </div>
        </li>


        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseTwo">
                <span>Procedencia</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">CRUD Procedencia: </h6>
                    <a class="collapse-item" href="{{route('procedencia.index')}}">Listar</a>
                    @can('procedencia.create')
                    <a class="collapse-item" data-toggle="modal" data-target="#modal-procedencia">Crear</a>
                    @endcan
                </div>
            </div>
        </li>


        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
                aria-expanded="true" aria-controls="collapseTwo">
                <span>Procedencia Codigo</span>
            </a>
            <div id="collapseFour" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">CRUD Procedencia Codigo: </h6>
                    <a class="collapse-item" href="{{route('procedencia.codigo.index')}}">Listar</a>
                    @can('procedencia.codigo.create')
                    <a class="collapse-item" data-toggle="modal" data-target="#modal-procedenciaCodigo">Crear</a>
                    @endcan
                </div>
            </div>
        </li>


        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
                aria-expanded="true" aria-controls="collapseTwo">
                <span>Programa</span>
            </a>
            <div id="collapseFive" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">CRUD Programa: </h6>
                    <a class="collapse-item" href="{{route('programa.index')}}">Listar</a>
                    @can('programa.create')
                    <a class="collapse-item" data-toggle="modal" data-target="#modal-programa">Crear</a>
                    @endcan
                </div>
            </div>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('proyectos')}}">
                <i class="fa-solid fa-table-list"></i>
                <span>Listar Proyectos</span></a>
        </li>
        @can("proyecto.create")
        <li class="nav-item">
            <a class="nav-link" href="{{route('proyectos.store')}}">
                <i class="fa-solid fa-plus"></i>
                <span>Crear Proyecto</span></a>
        </li>

        @endcan

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form action="{{route("proyectos")}}"
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input name="search" class="form-control bg-light border-0 small" placeholder="Ingresa su busqueda ..."
                               aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>



                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           @if(auth()->check())
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                            @endif
                            <img class="img-profile rounded-circle"
                                 src="{{asset("img/undraw_profile.svg")}}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('user.edit', auth()->user()->id) }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cerrar sesión
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                @yield("main")


                <!-- Modal genérico para agregar tipología -->
                @include('components.opcion-select', [
                    'modalId' => 'tipologia',
                    'title' => 'Tipología',
                    'routeName' => 'tipologia',
                    'selectName' => 'tipologia_id',
                    'dataTableId' => 'tipologiaTable'
                ])

                <!-- Modal genérico para agregar otra opción -->
                @include('components.opcion-select', [
                    'modalId' => 'procedencia',
                    'title' => 'Procedencia',
                    'routeName' => 'procedencia',
                    'selectName' => 'procedencia_id',
                    'dataTableId' => 'procedenciaTable'
                ])

                @include('components.opcion-select', [
                    'modalId' => 'procedenciaCodigo',
                    'title' => 'Procedencia_Codigo',
                    'routeName' => 'procedencia.codigo',
                    'selectName' => 'procedencia_codigo_id',
                    'dataTableId' => 'procedenciaCodigoTable'
                ])

                @include('components.opcion-select', [
                    'modalId' => 'programa',
                    'title' => 'Programa',
                    'routeName' => 'programa',
                    'selectName' => 'programa_id',
                    'dataTableId' => 'programaTable'
                ])

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; {{ config('app.name') }} {{ date('Y') }} </span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Listo para salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione “Cerrar sesión” a continuación si está listo para finalizar su sesión actual.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{route("logout")}}">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>
<!--  Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            Estas seguro que deseas eliminar este registro
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
            <form id="deleteForm" action="#" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
</div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="{{asset("vendor/jquery/jquery.min.js")}}"></script>
<script src="{{asset("vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset("vendor/jquery-easing/jquery.easing.min.js")}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset("js/sb-admin-2.min.js")}}"></script>
<script>
$(document).ready(function () {
    $.fn.tooltip.Constructor.Default = {
        ...$.fn.tooltip.Constructor.Default,
        trigger: 'hover',
        delay: { show: 150, hide: 100 },
        boundary: 'window'
    };

    const initTooltips = (context) => {
        $(context).find('[data-toggle="tooltip"]').each(function() {
            const $el = $(this);
            $el.tooltip('dispose');
            $el.tooltip({
                title: $el.attr('data-original-title') || $el.attr('title')
            });
        });
    };

    initTooltips(document);

    $(document).on('draw.dt', function(e, settings) {
        setTimeout(() => initTooltips(settings.nTable), 50);
    });

    $(document).on('mouseenter', '[data-toggle="tooltip"]', function() {
        $(this).tooltip('show');
    });
    $('.ajax-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let modalId = form.data('modal');
        let selectName = form.data('select');
        let tableId = form.data('table');
        let formData = form.serialize();

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            success: function (response) {
                let $alert = $('#alert-' + modalId);
                $alert.removeClass('d-none alert-danger')
                      .addClass('alert-success alert-dismissible fade show');
                $alert.find('.alert-message').text(response.success);

                setTimeout(function () {
                    $alert.fadeOut(500);
                    // $alert.addClass('d-none'); viene siendo lo mismo pero sin transicion
                }, 3000);

                let nuevaOpcion = response.data;
                if (selectName) {
                    let $select = $('select[name="' + selectName + '"]');
                    if ($select.length) {
                        $select.append(new Option(nuevaOpcion.label, nuevaOpcion.id));
                    }
                }
                if (tableId && $.fn.DataTable && $.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable().ajax.reload(null, false, ()=>{
                        initTooltips('#' + tableId);
                    });
                }
                form[0].reset();
            },
            error: function (xhr) {
                let $alert = $('#alert-' + modalId);
                $alert.removeClass('d-none alert-success')
                      .addClass('alert-danger alert-dismissible fade show');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function (key, value) {
                        errorMessages += value + '\n';
                    });
                    $alert.find('.alert-message').text(errorMessages);
                } else {
                    $alert.find('.alert-message').text('Error en la petición AJAX');
                }
            }
        });
    });

    // ocultar los alert despues de 3 segundos
    let $alert = $('#session-alert');
    if ($alert.length) {
        /*
        Se puede enviar este callback en caso de querer borrar el nodo
        en caso contrario se establece display: none;

        function () {
            $(this).remove();
        }
        */
        setTimeout(function () {
            $alert.fadeOut(500);
        }, 3000);
    }
});
</script>

@yield("scripts")
</body>

</html>
