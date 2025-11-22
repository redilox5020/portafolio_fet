<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/favicon.ico') }}">

    <title>Dashboard FET</title>

    <!-- Custom fonts for this template-->
    <!--<link href="{{asset("vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset("css/bootstrap5-styles.css")}}" rel="stylesheet">
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
                <span>Usuarios</span></a>
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
                <span>Tipologias</span>
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
                <span>Procedencias</span>
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
                <span>Detalle Procedencias</span>
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
                <span>Programas</span>
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
                <span>Proyectos</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('productos.index')}}">
                <i class="fa-brands fa-product-hunt"></i>
                <span>Productos</span></a>
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
                            <form action="{{route("proyectos")}}" class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input name="search" type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">
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
                            <a class="dropdown-item" href="{{ route('proyectos', ['search'=>auth()->user()->name]) }}">
                                <i class="fa-solid fa-table-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Proyectos registrados
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
                <div id="toast-container" class="position-fixed bottom-0 right-0 p-3" style="z-index: 1055; right: 0; bottom: 0;"></div>

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
                    'title' => 'Detalle',
                    'routeName' => 'procedencia.codigo',
                    'selectName' => 'procedencia_detalle_id',
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
            <form id="deleteForm" method="POST" class="d-inline">
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
<script src="{{asset("vendor/chart.js/Chart.min.js")}}"></script>

@vite(['resources/js/admin/dashboard.js'])

@yield("scripts")
<script src="{{ asset('js/modal-accessibility.js') }}"></script>
</body>

</html>
