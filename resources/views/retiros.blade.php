@extends('layouts.user_type.auth')

@section('content')
    <!-- Modal delete retiro -->
    <div class="modal fade" id="confirmStatusChangeModal" tabindex="-1" aria-labelledby="confirmStatusChangeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusChangeModalLabel">Eliminar retiro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este retiro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange">Inactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Client -->
    <div class="modal fade" id="addRetiroModal" tabindex="-1" aria-labelledby="addRetiroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRetiroModalLabel">Realizar retiro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un producto -->
                    <form id="addRetiroForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="apertura_id" class="form-label">Caja</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="apertura_id" name="apertura_id" required>
                                    @if ($aperturas->isEmpty())
                                        <option value="">No tiene cajas abiertas</option>
                                    @else
                                        <option value="">Seleccione una caja</option>
                                        @foreach ($aperturas as $apertura)
                                            <option value="{{ $apertura->id }}">
                                                {{ $apertura->caja->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
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
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Client -->
    <div class="modal fade" id="EditRetiroModal" tabindex="-1" aria-labelledby="EditRetiroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditRetiroModalLabel">Editar Retiro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un Retiro -->
                    <form id="EditRetiroForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="retiro_id_edit" name="retiro_id_edit">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="apertura_id_edit" class="form-label">Caja</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="apertura_id_edit" name="apertura_id_edit" required
                                    disabled>
                                    @if ($aperturasEdit->isEmpty())
                                        <option value="">No tiene cajas abiertas</option>
                                    @else
                                        <option value="">Seleccione una caja</option>
                                        @foreach ($aperturasEdit as $apertura)
                                            <option value="{{ $apertura->id }}">
                                                {{ $apertura->caja->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="monto_retiro_edit" class="form-label">Monto del Retiro</label><span
                                    class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="monto_retiro_edit"
                                    name="monto_retiro_edit" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="motivo_edit" class="form-label">Motivo del Retiro</label><span
                                    class="span-red">
                                    *</span>
                                <textarea type="text" class="form-control" id="motivo_edit" name="motivo_edit" rows="3" maxlength="255"
                                    required></textarea>
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



    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Retiros</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar retiros..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addRetiroModal"
                                        class="btn bg-gradient-info" style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Realizar retiro</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="card-body px-0 pt-0 pb-2">
                                                                                                        <div class="table-responsive p-0">
                                                                                                            <table class="table align-items-center mb-0">
                                                                                                                <thead>
                                                                                                                    <tr>
                                                                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Caja</th>
                                                                                                                        <th
                                                                                                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Monto</th>
                                                                                                                        <th
                                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Motivo</th>
                                                                                                                        <th
                                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Usuario</th>
                                                                                                                            <th
                                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Fecha</th>
                                                                                                                        <th
                                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                            Acción</th>
                                                                                                                        <th class="text-secondary opacity-7"></th>
                                                                                                                    </tr>
                                                                                                                </thead>
                                                                                                                <tbody id="RetiroTableBody">

                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </main>
                                                                                <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
                                                                                <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
                                                                                <script type="text/javascript">
                                                                                    $(document).on('click', '.fa-trash', function() {
                                                                                        var retiroId = $(this).data('retiro-id');
                                                                                        $('#confirmStatusChange').data('retiro-id', retiroId); // Asignar ID al botón dentro del modal.
                                                                                    });


                                                                                    $(document).ready(function() {
                                                                                        // Define la plantilla de la URL utilizando la función route() de Laravel
                                                                                        var clientUrlTemplate = "{{ route('retiros.show', ['id' => ':id']) }}";

                                                                                        // Manejador de evento para clic en el botón de editar
                                                                                        $('#RetiroTableBody').on('click', '.edit-btn', function() {
                                                                                            var retiroId = $(this).data(
                                                                                                'retiro-id'); // Obtiene el ID del cliente desde el atributo data
                                                                                            var fetchUrl = clientUrlTemplate.replace(':id',
                                                                                                retiroId); // Sustituye ':id' con el ID real del cliente

                                                                                            // Realiza una solicitud AJAX para obtener los datos del cliente
                                                                                            $.ajax({
                                                                                                url: fetchUrl,
                                                                                                type: 'GET',
                                                                                                dataType: 'json',
                                                                                                success: function(retiro) {
                                                                                                    // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                                                                                                    $('#retiro_id_edit').val(retiro.id);
                                                                                                    $('#apertura_id_edit').val(retiro.id_apertura);
                                                                                                    $('#monto_retiro_edit').val(retiro.monto);
                                                                                                    $('#motivo_edit').val(retiro.motivo);

                                                                                                    $('#EditRetiroModal').modal('show');
                                                                                                },
                                                                                                error: function(xhr, status, error) {
                                                                                                    console.error('Error al cargar los datos del retiro:', error);
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                    });
                                                                                </script>
                                                                                
                                                                                
                                                                                <script>
                                                                                    $(document).ready(function() {

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

                                                                                        $('#monto_retiro_edit').on('input', function() {
                                                                                            // Obtén el valor actual del input y elimina los puntos
                                                                                            let value = $(this).val().replace(/\./g, '');

                                                                                            // Asegúrate de que el valor sea un número válido antes de formatear
                                                                                            if (!isNaN(value) && value.length > 0) {
                                                                                                // Formatea el número con los separadores de miles
                                                                                                let formattedValue = parseInt(value).toLocaleString('de-DE');
                                                                                                $(this).val(formattedValue);
                                                                                            }
                                                                                        });
                                                                                        // Inicializar la búsqueda y paginación
                                                                                        loadTableData('{{ route('retiros.searchRetiroList') }}');

                                                                                        // Evento de input para el buscador
                                                                                        $('#searchInput').on('input', function() {
                                                                                            const query = $(this).val();
                                                                                            loadTableData(`{{ route('retiros.searchRetiroList') }}?query=${query}`);
                                                                                        });

                                                                                        function loadTableData(url) {
                                                                                            $.ajax({
                                                                                                url: url,
                                                                                                type: 'GET',
                                                                                                dataType: 'json',
                                                                                                success: function(response) {
                                                                                                    let tableBody = $('#RetiroTableBody');
                                                                                                    tableBody.empty();
                                                                                                    response.data.forEach(retiros => {
                                                                                                        let row = `
                        <tr>
                            <td  >
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${retiros.apertura.caja.name}</h6>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${retiros.monto}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${retiros.motivo}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${retiros.usuario.name}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0"> ${new Date(retiros.created_at).toLocaleString('en-GB', { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false })}</p>
                            </td>
                            <td class="text-center">
                                <a href="#" class="mx-3 edit-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-retiro-id="${retiros.id}">
                                    <i class="fas fa-pen text-secondary"></i>
                                </a>
                            </td>
                        </tr>`;
                                                                                                        tableBody.append(row);
                                                                                                    });
                                                                                                },
                                                                                                error: function(xhr, status, error) {
                                                                                                    console.error('Error al obtener los datos:', error);
                                                                                                }
                                                                                            });
                                                                                        }

                                                                                        $('#EditRetiroForm').submit(function(e) {
                                                                                            e.preventDefault(); // Prevent the form from submitting via the browser.


                                                                                            $('#monto_retiro_edit').val($('#monto_retiro_edit').val().replace(/\./g, ''));


                                                                                            var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                                                                                            $.ajax({
                                                                                                url: '{{ route('retiros.update') }}', // Adjust this to your route defined in Laravel routes.
                                                                                                type: 'POST',
                                                                                                data: formData,
                                                                                                contentType: false, // Required for 'multipart/form-data' type forms.
                                                                                                processData: false, // Required for 'multipart/form-data' type forms.
                                                                                                success: function(response) {

                                                                                                    Swal.fire({
                                                                                                        icon: 'success',
                                                                                                        title: '¡Éxito!',
                                                                                                        text: 'Retiro de caja actualizado con exito.',
                                                                                                        showConfirmButton: true,
                                                                                                        confirmButtonText: 'OK',
                                                                                                        timer: 1500,
                                                                                                        timerProgressBar: true,
                                                                                                        allowOutsideClick: true,
                                                                                                        willClose: () => {
                                                                                                            $('#EditRetiroForm')[0].reset();
                                                                                                            $('#EditRetiroModal').modal('hide');
                                                                                                            loadTableData(
                                                                                                                '{{ route('retiros.searchRetiroList') }}'
                                                                                                            );
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

                                                                                        $('#addRetiroForm').on('submit', function(e) {
                                                                                            e.preventDefault(); // Prevenir el envío normal del formulario

                                                                                            $('#monto_retiro').val($('#monto_retiro').val().replace(/\./g, ''));

                                                                                            var formData = new FormData(this);

                                                                                            $.ajax({
                                                                                                url: '{{ route('retiros.store') }}', // Cambia esta URL si es necesario
                                                                                                type: 'POST',
                                                                                                data: formData,
                                                                                                processData: false, // No procesar los datos (necesario para FormData)
                                                                                                contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
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
                                                                                                            $('#addRetiroModal').modal('hide');
                                                                                                            loadTableData(
                                                                                                                '{{ route('retiros.searchRetiroList') }}'
                                                                                                            );
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

                                                                                        $('#confirmStatusChange').click(function() {
                                                                                            var clientId = $(this).data('retiro-id');
                                                                                            $.ajax({
                                                                                                url: '{{ route('clients.changeStatus') }}', // Ajusta esto a tu ruta definida en las rutas de Laravel.
                                                                                                type: 'POST',
                                                                                                data: {
                                                                                                    id: clientId,
                                                                                                    status: 0,
                                                                                                    _token: '{{ csrf_token() }}'
                                                                                                },
                                                                                                success: function(response) {
                                                                                                    $('#confirmStatusChangeModal').modal('hide');
                                                                                                    loadTableData(
                                                                                                        '{{ route('retiros.searchRetiroList') }}'
                                                                                                    ); // Recargar la tabla para reflejar los cambios.
                                                                                                },
                                                                                                error: function() {
                                                                                                    alert('Hubo un error al cambiar el estado del cliente.');
                                                                                                }
                                                                                            });
                                                                                        });
                                                                                    });
                                                                                </script>
@endsection
