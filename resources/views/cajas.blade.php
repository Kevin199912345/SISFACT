@extends('layouts.user_type.auth')

@section('content')
    <!-- Modal Close Apertura -->
    <div class="modal fade" id="CloseAperturaModal" tabindex="-1" aria-labelledby="CloseAperturaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CloseAperturaModalLabel">Cierre Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un sucursal -->
                    <form id="CloseAperturaForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="apertura_id_cierre" id="apertura_id_cierre">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="monto_cierre" class="form-label">Monto de cierre</label><span class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_cierre" name="monto_cierre" required>
                            </div>
                        </div>
                        <button type="submit" class="btn bg-gradient-success">Cerrar Caja</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageEdit" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Retiro -->
    <div class="modal fade" id="addRetiroModal" tabindex="-1" aria-labelledby="addRetiroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRetiroModalLabel">Retiro de caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para realizar retiro de caja -->
                    <form id="addRetiroForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="apertura_id" id="apertura_id">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="monto_retiro" class="form-label">Monto del Retiro</label><span class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_retiro" name="monto_retiro" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="motivo" class="form-label">Motivo del Retiro</label><span class="span-red">
                                    *</span>
                                <textarea type="text" class="form-control" id="motivo" name="motivo" rows="3" maxlength="255" required></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn bg-gradient-success">Realizar retiro</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageAddRetiro" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Add Apertura -->
    <div class="modal fade" id="addAperturaCajaModal" tabindex="-1" aria-labelledby="addAperturaCajaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAperturaCajaModalLabel">Aperturar Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar una apertura de caja -->
                    <form id="addAperturaCajaForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="caja_id" class="form-label">Caja</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="caja_id" name="caja_id" required>
                                    <option value="">Seleccione una caja</option>
                                    @foreach ($cajas as $caja)
                                        <option value="{{ $caja->id }}">
                                            {{ $caja->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="monto_apertura" class="form-label">Monto Apertura</label><span
                                    class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_apertura" name="monto_apertura"
                                    required>
                            </div>
                        </div>

                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Edit Apertura -->
    <div class="modal fade" id="EditAperturaCajaModal" tabindex="-1" aria-labelledby="EditAperturaCajaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditAperturaCajaModalLabel">Editar Apertura de Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar una apertuta -->
                    <form id="EditAperturaCajaForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="apertura_id_edit" name="apertura_id_edit">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="caja_id_edit" class="form-label">Caja</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="caja_id_edit" name="caja_id_edit" required disabled>
                                    <option value="">Seleccione una caja</option>
                                    @foreach ($cajasedit as $caja)
                                        <option value="{{ $caja->id }}">
                                            {{ $caja->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="monto_apertura_edit" class="form-label">Monto Apertura</label><span
                                    class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_apertura_edit"
                                    name="monto_apertura_edit" required>
                            </div>
                        </div>


                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageEdit" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Cierre -->
    <div class="modal fade" id="EditCierreCajaModal" tabindex="-1" aria-labelledby="EditCierreCajaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditCierreCajaModalLabel">Editar Cierre de Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para editar cierre -->
                    <form id="EditCierreCajaForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="cierre_id_edit" name="cierre_id_edit">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="caja_id_edit_cierre" class="form-label">Caja</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="caja_id_edit_cierre" name="caja_id_edit_cierre" required
                                    disabled>
                                    <option value="">Seleccione una caja</option>
                                    @foreach ($cajasedit as $caja)
                                        <option value="{{ $caja->id }}">
                                            {{ $caja->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="monto_cierre_edit" class="form-label">Monto Cierre</label><span
                                    class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_cierre_edit"
                                    name="monto_cierre_edit" required>
                            </div>
                        </div>


                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageEdit" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Listado de cierres-->
    <div class="modal fade" id="cierresModal" tabindex="-1" aria-labelledby="cierresModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cierresModalLabel">Listado de Cierres</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="cierresTable">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Caja</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Monto Apertura</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Monto Cierre</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Profit</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Usuario</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Fecha Cierre</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Estado</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acción</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4" style="min-height:100px !important;">
                        <div class="card-header pb-0" style="padding: 0px !important;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Apertura/Cierre de Cajas</h6>
                                <div>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#cierresModal"
                                        class="btn bg-gradient-info"
                                        style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Listado de Cierres</button>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#addAperturaCajaModal"
                                                            class="btn bg-gradient-info" style="margin: 0px; !important" ">
                                        <i class="fas fa-plus"></i> Aperturar Caja</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @if ($aperturaCajas->isNotEmpty())
        <div class="cont_cajas">
            <div class="grid-container_cajas">
                @foreach ($aperturaCajas as $apertura)
                    <div class="grid-item_cajas">
                        <div class="inputs_details_caja">
                            <a class="detalle_caja"><span class="btn bg-gradient-info"><i class="far fa-eye"></i> Ver
                                    detalle</span></a>
                            <a class="cierre_caja">
                                <span class="btn bg-gradient-secondary open-retiro-modal margin-btn-caja" id="edit-btn"
                                    data-id="{{ $apertura->id }}"><i class="fas fa-pen text-white"></i></span>
                                <span class="btn bg-gradient-secondary open-retiro-modal margin-btn-caja"
                                    data-id="{{ $apertura->id }}" data-bs-toggle="modal"
                                    data-bs-target="#addRetiroModal">Realizar retiro <i
                                        class="fas fa-vote-yea"></i></span><span
                                    class="btn bg-gradient-danger margin-btn-caja cierre_caja_input"
                                    data-bs-toggle="modal" data-bs-target="#CloseAperturaModal"
                                    data-apertura-id="{{ $apertura->id }}">Cierre <i class="fas fa-times"></i></span></a>
                        </div>
                        <div class="img_caja_details">
                            <img src="{{ asset('assets/img/cajero-automatico.webp') }}" alt="img_caja">
                        </div>
                        <div class="info_caja">
                            <h3>{{ $apertura->caja->name }}</h3>
                            <p>{{ $apertura->usuario->name }}</p>
                            <div class="price_cajas">
                                <h4>Apertura:
                                    ₡{{ number_format($apertura->monto_apertura, 2, '.', ',') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#cierresModal').on('show.bs.modal', function() {
                // Realizar la solicitud AJAX
                $.ajax({
                    url: '{{ route('apertura.list') }}', // Cambia esta ruta a la que uses para obtener los datos
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var tableBody = $('#cierresTable tbody');
                        tableBody.empty(); // Limpiar el contenido actual de la tabla

                        // Recorrer la respuesta y llenar la tabla
                        $.each(response.data, function(index, apertura) {
                            var montoApertura = parseFloat(apertura.monto_apertura)
                                .toLocaleString('en-US', {
                                    style: 'currency',
                                    currency: 'CRC',
                                    minimumFractionDigits: 2
                                });

                            var montoCierre = parseFloat(apertura.monto_cierre)
                                .toLocaleString('en-US', {
                                    style: 'currency',
                                    currency: 'CRC',
                                    minimumFractionDigits: 2
                                });

                            var profit = parseFloat(apertura.profit).toLocaleString(
                                'en-US', {
                                    style: 'currency',
                                    currency: 'CRC',
                                    minimumFractionDigits: 2
                                });

                            var fechaCierre = apertura.monto_cierre ? new Date(apertura
                                .updated_at).toLocaleString('es-CR') : 'No cerrado';

                            // Determinar el color del texto para el profit
                            var profitColor =
                                'text-gray'; // Color por defecto (gris) cuando profit es 0
                            if (apertura.profit > 0) {
                                profitColor = 'text-success'; // Verde
                            } else if (apertura.profit < 0) {
                                profitColor = 'text-danger'; // Rojo
                            }

                            var row = `
                    <tr>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${apertura.id}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${apertura.caja.name}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${montoApertura}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${montoCierre}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0 ${profitColor}">${profit}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${apertura.usuario.name}</p>
                        </td>
                        <td style="text-align: center;">
                            <p class="text-xs font-weight-bold mb-0">${fechaCierre}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-${apertura.status === 1 ? 'success' : 'danger'}">${apertura.status === 1 ? 'Abierta' : 'Cerrada'}</span>
                        </td>
                        <td class="text-center bnt-cierre">
                            <a href="#" class="mx-3 edit-btn-cierre" data-bs-toggle="tooltip" data-bs-original-title="Edit user" title="Editar" data-id="${apertura.id}">
                                <i class="fas fa-pen text-secondary"></i>
                            </a>
                        </td>
                    </tr>
                `;
                            tableBody.append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener los datos de cierres:', error);
                    }
                });
            });



            // Define la plantilla de la URL utilizando la función route() de Laravel
            var clientUrlTemplate = "{{ route('apertura.show', ['id' => ':id']) }}";

            // Manejador de evento para clic en el botón de editar
            $('.cierre_caja').on('click', '#edit-btn', function() {
                var aperturatId = $(this).data(
                    'id'); // Obtiene el ID del cliente desde el atributo data
                var fetchUrl = clientUrlTemplate.replace(':id',
                    aperturatId); // Sustituye ':id' con el ID real del cliente

                // Realiza una solicitud AJAX para obtener los datos del cliente
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(apertura) {
                        // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                        $('#apertura_id_edit').val(apertura.id);
                        $('#caja_id_edit').val(apertura.id_caja);
                        $('#monto_apertura_edit').val(apertura.monto_apertura);

                        $('#EditAperturaCajaModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos de la apertura:', error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Al hacer clic en el botón "Realizar retiro"
            $('.open-retiro-modal').on('click', function() {
                var aperturaId = $(this).data('id');
                $('#apertura_id').val(aperturaId);
            });

            $('.cierre_caja_input').on('click', function() {
                var aperturaCirreId = $(this).data('apertura-id');
                $('#apertura_id_cierre').val(aperturaCirreId);
            });

            // Manejar el envío del formulario de retiro
            $('#addRetiroForm').on('submit', function(e) {
                e.preventDefault();


                $('#monto_retiro').val($('#monto_retiro').val().replace(/\./g, ''));

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('retiros.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Retiro de caja exitoso.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: true,
                            willClose: () => {
                                $('#addRetiroForm')[0].reset();
                                $('#addAperturaCajaModal').modal('hide');
                                location
                                    .reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorHtml,
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });




        });
    </script>
    <script>
        $(document).ready(function() {
            $('#addAperturaCajaForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario


                $('#monto_apertura').val($('#monto_apertura').val().replace(/\./g, ''));

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('apertura.store') }}', // Cambia esta URL si es necesario
                    type: 'POST',
                    data: formData,
                    processData: false, // No procesar los datos (necesario para FormData)
                    contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                    success: function(response) {
                        // Mostrar mensaje de éxito y limpiar formulario
                        $('#responseMessage').html(
                            '<div class="alert alert-success">Apertura de caja exitosa.</div>'
                        );
                        $('#addAperturaCajaForm')[0].reset();
                        $('#addAperturaCajaModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error
                        var errors = xhr.responseJSON;
                        var errorHtml = '<div class="alert alert-danger">';

                        // Si el error es porque ya tiene un registro activo
                        if (errors.success === false && errors.message) {
                            errorHtml += '<p>' + errors.message + '</p>';
                        } else if (errors.errors) {
                            // Mostrar otros errores de validación
                            $.each(errors.errors, function(key, value) {
                                errorHtml += '<p>' + value + '</p>';
                            });
                        }

                        errorHtml += '</div>';
                        $('#responseMessage').html(errorHtml);

                        // Asegurarse de que el modal no se cierre
                        $('#addAperturaCajaModal').modal('show');
                    }
                });
            });

            $('#EditAperturaCajaForm').on('submit', function(e) {
                $('#caja_id_edit').prop('disabled',
                    false); // Habilita el campo antes de enviar el formulario
            });


            $('#EditAperturaCajaForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting via the browser.

                $('#monto_apertura_edit').val($('#monto_apertura_edit').val().replace(/\./g, ''));

                var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                $.ajax({
                    url: '{{ route('apertura.update') }}', // Adjust this to your route defined in Laravel routes.
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for 'multipart/form-data' type forms.
                    processData: false, // Required for 'multipart/form-data' type forms.
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Se edito la apertura con éxito.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: true,
                            willClose: () => {
                                $('#EditAperturaCajaForm')[0].reset();
                                $('#EditAperturaCajaModal').modal('hide');
                                location
                                    .reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorHtml,
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });

            var clientUrlTemplateCierre = "{{ route('apertura.show', ['id' => ':id']) }}";

            // Manejador de evento para clic en el botón de editar utilizando delegación de eventos
            $(document).on('click', '.edit-btn-cierre', function() {
                var aperturatId = $(this).data('id'); // Obtiene el ID del cliente desde el atributo data
                var fetchUrl = clientUrlTemplateCierre.replace(':id',
                aperturatId); // Sustituye ':id' con el ID real del cliente

                // Realiza una solicitud AJAX para obtener los datos del cliente
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(apertura) {
                        // Asignar los valores obtenidos al formulario
                        $('#cierre_id_edit').val(apertura.id);
                        $('#caja_id_edit_cierre').val(apertura.id_caja);
                        $('#monto_cierre_edit').val(apertura.monto_cierre);

                        // Mostrar el modal
                        $('#EditCierreCajaModal').modal('show');
                        $('#cierresModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos de la apertura:', error);
                    }
                });
            });




            $('#EditCierreCajaForm').on('submit', function(e) {
                $('#caja_id_edit_cierre').prop('disabled',
                    false); // Habilita el campo antes de enviar el formulario
            });


            $('#EditCierreCajaForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting via the browser.

                $('#monto_cierre_edit').val($('#monto_cierre_edit').val().replace(/\./g, ''));

                var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                $.ajax({
                    url: '{{ route('apertura.updateCierre') }}', // Adjust this to your route defined in Laravel routes.
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for 'multipart/form-data' type forms.
                    processData: false, // Required for 'multipart/form-data' type forms.
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Se edito el cierre con éxito.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: true,
                            willClose: () => {
                                $('#EditCierreCajaForm')[0].reset();
                                $('#EditCierreCajaModal').modal('hide');
                                $('#cierresModal').modal('show');
                            }
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorHtml,
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });

            $('#CloseAperturaForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario


                $('#monto_cierre').val($('#monto_cierre').val().replace(/\./g, ''));

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('apertura.cierre') }}', // Cambia esta URL si es necesario
                    type: 'POST',
                    data: formData,
                    processData: false, // No procesar los datos (necesario para FormData)
                    contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Cierre de caja exitoso.',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: true,
                            willClose: () => {
                                $('#CloseAperturaForm')[0].reset();
                                $('#CloseAperturaModal').modal('hide');
                                location
                                    .reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errorHtml,
                            confirmButtonText: 'Cerrar'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#monto_cierre_edit').on('input', function() {
                // Obtén el valor actual del input y elimina los puntos
                let value = $(this).val().replace(/\./g, '');

                // Asegúrate de que el valor sea un número válido antes de formatear
                if (!isNaN(value) && value.length > 0) {
                    // Formatea el número con los separadores de miles
                    let formattedValue = parseInt(value).toLocaleString('de-DE');
                    $(this).val(formattedValue);
                }
            });

            $('#monto_apertura_edit').on('input', function() {
                // Obtén el valor actual del input y elimina los puntos
                let value = $(this).val().replace(/\./g, '');

                // Asegúrate de que el valor sea un número válido antes de formatear
                if (!isNaN(value) && value.length > 0) {
                    // Formatea el número con los separadores de miles
                    let formattedValue = parseInt(value).toLocaleString('de-DE');
                    $(this).val(formattedValue);
                }
            });

            $('#monto_apertura').on('input', function() {
                // Obtén el valor actual del input y elimina los puntos
                let value = $(this).val().replace(/\./g, '');

                // Asegúrate de que el valor sea un número válido antes de formatear
                if (!isNaN(value) && value.length > 0) {
                    // Formatea el número con los separadores de miles
                    let formattedValue = parseInt(value).toLocaleString('de-DE');
                    $(this).val(formattedValue);
                }
            });

            $('#monto_cierre').on('input', function() {
                // Obtén el valor actual del input y elimina los puntos
                let value = $(this).val().replace(/\./g, '');

                // Asegúrate de que el valor sea un número válido antes de formatear
                if (!isNaN(value) && value.length > 0) {
                    // Formatea el número con los separadores de miles
                    let formattedValue = parseInt(value).toLocaleString('de-DE');
                    $(this).val(formattedValue);
                }
            });

            $('#monto_retiro').on('input', function() {
                // Obtén el valor actual del input y elimina los puntos
                let value = $(this).val().replace(/\./g, '');

                // Asegúrate de que el valor sea un número válido antes de formatear
                if (!isNaN(value) && value.length > 0) {
                    // Formatea el número con los separadores de miles
                    let formattedValue = parseInt(value).toLocaleString('de-DE');
                    $(this).val(formattedValue);
                }
            });
        });
    </script>
@endsection
