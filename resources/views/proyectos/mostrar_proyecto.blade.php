@extends('layouts.dashboard_admin')
@section('main')
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white py-3 d-flex flex-row align-items-center justify-content-between">
            <h1 class="m-0" style="font-size: 1.25rem;font-size: clamp(1.25rem, 1rem + 1.25vw, 2.5rem);">
                {{ ucfirst(mb_strtolower($proyecto->nombre)) }}</h1>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-white"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink"
                    style="">
                    <div class="dropdown-header">Acciones:</div>
                    @if ($proyecto->investigadoresHistoricos->isNotEmpty())
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historicoModal">
                            <i class="fa-solid fa-clock-rotate-left fa-sm fa-fw mr-2 text-gray-400"></i>
                            Historico de Investigadores
                        </a>
                    @endif
                    <a class="dropdown-item" href="{{ route('proyectos.edit', $proyecto->codigo) }}">
                        <i class="fa-solid fa-pen-to-square fa-sm fa-fw mr-2 text-gray-400"></i>
                        Editar Proyecto
                    </a>
                    <a class="dropdown-item delete-btn" data-id="{{ $proyecto->codigo }}" data-toggle="modal"
                        data-target="#deleteModal" href="#">
                        <i class="fa-solid fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>
                        Eliminar Proyecto
                    </a>
                </div>
            </div>
        </div>
        <div id="container-main" class="card-body">
            <table class="table table-sm table-borderless table-hover">
                <tbody>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Objetivo general</div>
                        </td>
                        <td>
                            {{ $proyecto->objetivo_general }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Programa</div>
                        </td>
                        <td>
                            {{ $proyecto->programa->nombre }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Procedencia</div>
                        </td>
                        <td>
                            {{ $proyecto->procedencia->opcion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Tipologia</div>
                        </td>
                        <td>
                            {{ $proyecto->tipologia->opcion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Duracion</div>
                        </td>
                        <td>
                            {{ $proyecto->duracion }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Costo</div>
                        </td>
                        <td>
                            ${{ number_format($proyecto->costo, 2, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="font-weight-bold">Año</div>
                        </td>
                        <td>
                            {{ $proyecto->anio }}
                        </td>
                    </tr>
                    @if ($proyecto->pdf_url)
                        <tr>
                            <td>
                                <div class="font-weight-bold">Url fichero</div>
                            </td>
                            <td>
                                <a href="{{ $proyecto->pdf_url }}" target="_blank"
                                    rel="noopener noreferrer">{{ $proyecto->pdf_url }}</a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($proyecto->investigadores->isNotEmpty())
                @php
                    $indexInvestigadores = 1;
                @endphp

                <h3 class="mb-4 text-secondary font-weight-bold">Investigadores Activos</h3>

                <div id="container-investigadores-activos" class="row">
                    @foreach ($proyecto->investigadores as $investigador)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-user mr-2"></i> Investigador {{ $indexInvestigadores }}
                                    </h5>
                                    <p class="card-text text-muted mb-0">{{ $investigador->nombre }}</p>
                                </div>
                            </div>
                        </div>
                        @php
                            $indexInvestigadores++;
                        @endphp
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="card border-info shadow mb-4">
        <div class="card-header p-2 bg-info text-white">
            <h6 class="m-0 font-weight-bold">Ficheros en este proyecto:</h6>
        </div>
        @if ($proyecto->pdf_url)
                <div id="loader-container" style="display: none;">
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                    <p class="text-center mt-2">Cargando metadatos del PDF...</p>
                </div>
                <div id="pdf-metadata-container" class="card-body p-0" data-url="{{ $proyecto->pdf_url }}"></div>
        @else
                <div class="card-body p-3">
                    No hay ficheros asociados a este proyecto.
                </div>
        @endif
    </div>
    @if ($proyecto->investigadoresHistoricos->isNotEmpty())
        <div class="modal fade" id="historicoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Investigadores Historicos</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="alert" class="alert alert-dismissible fade show d-none" role="alert">
                            <span class="alert-message" style="white-space: pre-line;line-height: 1.3;"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                        <th>Duración</th>
                                        <th>Revinculado?</th>
                                        <th>Seleccion</th>
                                    </tr>
                                </thead>
                                <tbody id="historicoTable">
                                    @foreach ($proyecto->investigadoresHistoricos as $investigador)
                                        @php
                                            $inicio = \Carbon\Carbon::parse($investigador->pivot->created_at);
                                            $fin = \Carbon\Carbon::parse($investigador->pivot->deleted_at);
                                            $duracion = $inicio->diffForHumans($fin, true);
                                        @endphp
                                        <tr data-pivot-id="{{ $investigador->pivot->id }}" data-investigador-id="{{ $investigador->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $investigador->nombre }}</td>
                                            <td>{{ $inicio->format('d/m/Y') }}</td>
                                            <td>{{ $fin->format('d/m/Y') }}</td>
                                            <td>{{ $duracion }}</td>
                                            <td>{{ in_array($investigador->id, $proyecto->investigadores()->pluck('investigadores.id')->toArray())? "si": "no" }}</td>
                                            <td>
                                                {{-- eliminar investigador por medio de un checkbox para poder seleccionar varios en caso de eliminacion multiple --}}
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                    value="{{ $investigador->pivot->id }}"
                                                    data-investigador-id="{{ $investigador->id }}"
                                                    id="investigador-{{ $investigador->pivot->id }}">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="selectAllCheckbox">
                            <label class="form-check-label" for="selectAllCheckbox">
                                Seleccionar todos
                            </label>
                        </div>
                        <button id="reactivateButton" type="submit" class="btn btn-success btn-sm">
                            Reactivar
                        </button>
                        <button id="deleteButton" type="submit" class="btn btn-danger btn-sm">
                            Eliminar
                        </button>

                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('css')
@endsection
@section('scripts')
{{--     <script>
        $(document).ready(function() {
            $('#selectAllCheckbox').on('change', function() {
                const isChecked = $(this).is(':checked');
                $('.form-check-input').not(this).prop('checked', isChecked);
            });

            const deleteRouteTemplate = @json(route('proyectos.delete', ['id' => '__ID__']));

            $(document).on('click', '.delete-btn', function () {
                let userId = $(this).data('id');
                let deleteUrl = deleteRouteTemplate.replace('__ID__', userId);
                $('#deleteForm').attr('action', deleteUrl);
            });

            const contenedor = $('#pdf-metadata-container');
            const pdfUrl = contenedor.data('url');

            if (pdfUrl) {
                let loaderTimeout;
                $('#loader-container').show();
                contenedor.hide();

                loaderTimeout = setTimeout(() => {
                    $('#loader-container').fadeIn(200);
                }, 300);
                $.ajax({
                    url: 'pdf/metadatos',
                    method: 'GET',
                    headers: {
                        'X-PDF-Url': pdfUrl
                    },
                    success: function(response) {
                        const html = `
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="py-1 px-2">Fichero</th>
                                                <th class="py-1 px-2">Descripción</th>
                                                <th class="py-1 px-2">Tamaño</th>
                                                <th class="py-1 px-2">Formato</th>
                                                <th class="py-1 px-2"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-2 px-2">${response.nombre}</td>
                                                <td class="py-2 px-2">${response.descripcion}</td>
                                                <td class="py-2 px-2">${response.tamaño}</td>
                                                <td class="py-2 px-2">Adobe PDF</td>
                                                <td class="py-2 px-2">
                                                    <a href="${response.url}" class="btn btn-success btn-sm">Descargar</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>`;
                        contenedor.html(html);
                    },
                    error: function(xhr) {
                        contenedor.html(`
                        <div class="alert alert-danger">
                            Error al obtener los metadatos del archivo PDF.
                        </div>`);
                        console.error('Error en la petición:', xhr);
                    },
                    complete: function() {
                        clearTimeout(loaderTimeout);
                        $('#loader-container').hide();
                        $('#pdf-metadata-container').show();
                    }
                });
            }

            $('#deleteButton').on('click', function() {
                $('#deleteButton').prop('disabled', true);
                $('#reactivateButton').prop('disabled', true);

                const selectedIds = [];
                const selectedRows = [];

                $('.form-check-input:checked').not('#selectAllCheckbox').each(function() {
                    console.log($(this));
                    selectedIds.push($(this).val());
                    selectedRows.push($(this).closest('tr'));
                });

                if (selectedIds.length === 0) {
                    alert('Por favor, selecciona al menos un investigador.');
                    $(this).prop('disabled', false);
                    $('#reactivateButton').prop('disabled', false);
                    return;
                }
                if (!confirm('¿Estás seguro de que quieres eliminar este proyecto? Esta acción no se puede deshacer.')) {
                    return;
                }
                $.ajax(
                    {
                        url: @json(route('investigadores.historicos.delete')),
                        method: 'DELETE',
                        data: {
                            selectedIds,
                            _token: @json(csrf_token())
                        },
                        success: function(response) {
                            let $alert = $('#alert');
                            $alert.removeClass('d-none alert-danger')
                                .addClass('alert-success alert-dismissible fade show');
                            $alert.find('.alert-message').text(response.message);

                            let rowsProcessed = 0;
                            selectedRows.forEach(function(row) {
                                row.fadeOut(500, function() {
                                    $(this).remove();
                                    rowsProcessed++;

                                    if (rowsProcessed === selectedRows.length) {
                                        if ($('#historicoTable').children().length === 0) {
                                            $('#historicoTable').html('<tr><td colspan="6" class="text-center">No hay investigadores historicos.</td></tr>');
                                            $('#deleteButton').prop('disabled', true);
                                            $('#reactivateButton').prop('disabled', true);
                                            $('#selectAllCheckbox').prop('disabled', true);
                                        } else {
                                            $('#deleteButton').prop('disabled', false);
                                            $('#reactivateButton').prop('disabled', false);
                                        }
                                    }
                                });
                            });
                            setTimeout(function () {
                                $alert.fadeOut(500);
                            }, 3000);

                        },
                        error: function(xhr) {
                            let $alert = $('#alert');
                            $alert.removeClass('d-none alert-success')
                                .addClass('alert-danger alert-dismissible fade show');
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorMessages = '';
                                $.each(errors, function (key, value) {
                                    errorMessages += value + '\n';
                                });
                                $alert.find('.alert-message').text(errorMessages);
                            }else if (xhr.status === 404) {
                                $alert.find('.alert-message').text(xhr.responseJSON.message);
                            } else {
                                $alert.find('.alert-message').text('Error en la petición AJAX');
                            }
                            $('#deleteButton').prop('disabled', false);
                            $('#reactivateButton').prop('disabled', false);
                        }
                    }
                );
            });

            $('#reactivateButton').on('click', function() {
                habilitarDeshabilitarBotones(true);
                const selectedIds = [];
                const selectedRows = [];
                const indexInvestigadores = @json($indexInvestigadores ?? 1);

                $('.form-check-input:checked').not('#selectAllCheckbox').each(function() {
                    selectedIds.push($(this).data('investigador-id'));
                    selectedRows.push($(this).closest('tr'));
                });

                if (selectedIds.length === 0) {
                    alert('Por favor, selecciona al menos un investigador.');
                    habilitarDeshabilitarBotones(false);
                    return;
                }
                if (!confirm('¿Estás seguro de que quieres reactivar este proyecto? Esta acción no se puede deshacer.')) {
                    habilitarDeshabilitarBotones(false);
                    return;
                }
                $.ajax(
                    {
                        url: @json(route('investigadores.historicos.reactivar', $proyecto->id)),
                        method: 'POST',
                        data: {
                            selectedIds,
                            _token: @json(csrf_token())
                        },
                        success: function(response) {
                            let $alert = $('#alert');
                            $alert.removeClass('d-none alert-danger')
                                .addClass('alert-success alert-dismissible fade show');
                            $alert.find('.alert-message').text(response.message);
                            mostrarToast('success', response.message, true, true);

                            response.investigadoresRestaurados.forEach(function(investigador) {
                                const row = $('#historicoTable').find('tr').filter(function() {
                                    return $(this).find('td').eq(1).text().trim() === investigador.nombre;
                                });
                                if (row.length && investigador.restore) {
                                    row.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                }
                                if ($('#container-investigadores-activos').length) {
                                    $(`
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title text-primary">
                                                        <i class="fas fa-user mr-2"></i> Investigador ${indexInvestigadores}
                                                    </h5>
                                                    <p class="card-text text-muted mb-0">${investigador.nombre}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `).hide().appendTo('#container-investigadores-activos').fadeIn(500);
                                } else{
                                    $(`
                                    <h3 class="mb-4 text-secondary font-weight-bold">Investigadores Activos</h3>
                                        <div id="container-investigadores-activos" class="row">
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                                <div class="card h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-primary">
                                                            <i class="fas fa-user mr-2"></i> Investigador ${indexInvestigadores}
                                                        </h5>
                                                        <p class="card-text text-muted mb-0">${investigador.nombre}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    `).hide().appendTo('#container-main').fadeIn(500);
                                }
                            });
                            if(response.errores && response.errores.length > 0){
                                response.errores.forEach(function(error) {
                                    mostrarToast('warning', error, false);
                                });
                            }
                            setTimeout(function () {
                                $alert.fadeOut(500);
                            }, 3000);

                        },
                        error: function(xhr) {
                            let $alert = $('#alert');
                            $alert.removeClass('d-none alert-success')
                                .addClass('alert-danger alert-dismissible fade show');
                            if (xhr.status === 422 || xhr.status === 400) {
                                let errors = xhr.responseJSON.errors;
                                let errorMessages = '';
                                $.each(errors, function (key, value) {
                                    errorMessages += value + '\n';
                                });
                                console.log(errorMessages);
                                $alert.find('.alert-message').text(errorMessages);
                                mostrarToast('danger', mensaje);
                            }else if (xhr.status === 404) {
                                $alert.find('.alert-message').text(xhr.responseJSON.message);
                            }else {
                                $alert.find('.alert-message').text('Error en la petición AJAX');
                            }
                        },
                        complete: function() {
                            habilitarDeshabilitarBotones(false);
                        }
                    }
                );
            })
        })
        $(document).on('hidden.bs.modal', function () {
            $('.toast').toast('hide');
        });

        function habilitarDeshabilitarBotones(flag){
            $('#deleteButton').prop('disabled', flag);
            $('#reactivateButton').prop('disabled', flag);
            $('#selectAllCheckbox').prop('disabled', flag);
        }
        function mostrarToast(tipo, mensaje, autohide = true, startNew = false,  duracion = 5000) {

            if (startNew) {
                    $('#toast-container').empty();
            }

            const iconos = {
                success: '✅',
                warning: '⚠️',
                danger: '❌',
                info: 'ℹ️'
            };
            const colores = {
                success: '#e4ffc4',
                warning: '#FFEB3B',
                danger: '#dc3545',
                info: '#17a2b8'
            };

            const id = 'toast-' + Date.now() + '-' + Math.floor(Math.random() * 1000);

            const toastHTML = `
                <div id="${id}" class="toast font-weight-bold text-gray-900 mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-delay="${duracion}" data-autohide="${autohide}" style="background-color: ${colores[tipo]} !important;">
                    <div class="toast-header text-gray-900" style="background-color: ${colores[tipo]} !important;">
                        <strong class="mr-auto">${iconos[tipo] || ''} ${tipo.toUpperCase()}</strong>
                        <button type="button" class="ml-2 mb-1 close text-gray-900" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        ${mensaje}
                    </div>
                </div>
            `;

            $('#toast-container').append(toastHTML);
            const $nuevoToast = $('#' + id);
            $nuevoToast.toast('show');

            // Eliminar el toast del DOM cuando desaparezca
            $nuevoToast.on('hidden.bs.toast', function () {
                $(this).remove();
            });
        }

    </script> --}}
<script>
    window.appData = {
        indexActual : @json($indexInvestigadores ?? 1),
        csrf: '{{ csrf_token() }}',
        rutas: {
            eliminar: @json(route('proyectos.delete', ['id' => '__ID__'])),
            reactivar: '{{ route('investigadores.historicos.reactivar', $proyecto->id) }}',
            eliminarRegistroHistorico: '{{ route('investigadores.historicos.delete') }}'
        }
    };
</script>
@vite('resources/js/mostrar_proyecto.js')
@endsection
