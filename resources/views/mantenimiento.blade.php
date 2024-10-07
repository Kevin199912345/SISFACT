@extends('layouts.user_type.auth')

@section('content')
    <!-- Modal delete Product -->
    <div class="modal fade" id="confirmStatusChangeModal" tabindex="-1" aria-labelledby="confirmStatusChangeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusChangeModalLabel">Confirmar Cambio de Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea inactivar esta sucursal?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange">Inactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete Caja -->
    <div class="modal fade" id="confirmStatusChangeModal_caja" tabindex="-1"
        aria-labelledby="confirmStatusChangeModalLabel_caja" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusChangeModalLabel_caja">Confirmar Cambio de Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea inactivar esta caja?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange_caja">Inactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Sucursal -->
    <div class="modal fade" id="EditSucursalModal" tabindex="-1" aria-labelledby="EditSucursalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditSucursalModalLabel">Editar Sucursal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un sucursal -->
                    <form id="EditSucursalForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="sucursal_id_edit" name="sucursal_id_edit">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="codigo_sucursal_edit" class="form-label">Código de Sucursal</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="codigo_sucursal_edit"
                                    name="codigo_sucursal_edit" required>
                            </div>
                            <div class="col-md-4">
                                <label for="name_edit" class="form-label">Nombre</label><span class="span-red"> *</span>
                                <input type="text" class="form-control" id="name_edit" name="name_edit" required>
                            </div>
                            <div class="col-md-4">
                                <label for="direccion_edit" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion_edit" name="direccion_edit">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="telefono_edit" class="form-label">Télefono</label><span class="span-red">
                                    *</span>
                                <input type="number" step="0.01" class="form-control" id="telefono_edit"
                                    name="telefono_edit" required>
                            </div>

                            <div class="col-md-3">
                                <label for="email_edit" class="form-label">Email:</label><span class="span-red">
                                    *</span>
                                <input type="email" class="form-control" id="email_edit" name="email_edit" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status_edit" class="form-label">Estado</label>
                            <select class="form-select" id="status_edit" name="status_edit">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>


                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageEdit" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Caja -->
    <div class="modal fade" id="EditCajaModal" tabindex="-1" aria-labelledby="EditSucursalModalLabel_caja"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditSucursalModalLabel_caja">Editar Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar una caja -->
                    <form id="EditCajaForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="caja_id_edit" name="caja_id_edit">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="codigo_caja_edit" class="form-label">Código de caja</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="codigo_caja_edit" name="codigo_caja_edit"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="name_caja_edit" class="form-label">Nombre</label><span class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="name_caja_edit" name="name_caja_edit"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="sucursal_caja_id_edit" class="form-label">Sucursal</label><span class="span-red">
                                    *</span>
                                <select class="form-select" id="sucursal_caja_id_edit" name="sucursal_caja_id_edit"
                                    required>
                                    <option value="">Seleccione una sucurdal</option>
                                    @foreach ($sucursales as $suculsal)
                                        <option value="{{ $suculsal->id }}">
                                            {{ $suculsal->codigo_sucursal }}-{{ $suculsal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status_edit_caja" class="form-label">Estado</label>
                            <select class="form-select" id="status_edit_caja" name="status_edit_caja">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>


                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageEdit_caja" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Add Product -->
    <div class="modal fade" id="addSucursalModal" tabindex="-1" aria-labelledby="addSucursalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSucursalModalLabel">Agregar Nueva Sucursal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar una sucursal -->
                    <form id="addSucursalForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="codigo_sucursal" class="form-label">Código de Sucursal</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="codigo_sucursal" name="codigo_sucursal"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="name" class="form-label">Nombre</label><span class="span-red"> *</span>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="telefono" class="form-label">Télefono</label><span class="span-red"> *</span>
                                <input type="number" step="0.01" class="form-control" id="telefono"
                                    name="telefono" required>
                            </div>

                            <div class="col-md-3">
                                <label for="email" class="form-label">Email:</label><span class="span-red">
                                    *</span>
                                <input type="email" class="form-control" id="email" name="email" required>
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


    <!-- Modal Add Caja -->
    <div class="modal fade" id="addCajaModal" tabindex="-1" aria-labelledby="addCajaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCajaModalLabel">Agregar Nueva Caja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar una caja -->
                    <form id="addSCajaForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="codigo_caja" class="form-label">Código de caja</label><span class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="codigo_caja" name="codigo_caja" required>
                            </div>
                            <div class="col-md-4">
                                <label for="name_caja" class="form-label">Nombre</label><span class="span-red"> *</span>
                                <input type="text" class="form-control" id="name_caja" name="name_caja" required>
                            </div>
                            <div class="col-md-4">
                                <label for="sucursal_id" class="form-label">Sucursal</label><span class="span-red"> *</span>
                                <select class="form-select" id="sucursal_id" name="sucursal_id" required>
                                    <option value="">Seleccione una sucurdal</option>
                                    @foreach ($sucursales as $suculsal)
                                        <option value="{{ $suculsal->id }}">
                                            {{ $suculsal->codigo_sucursal }}-{{ $suculsal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessageCaja" class="mt-3"></div>
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
                                <h6 class="mb-0">Sucursales</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar sucursal..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addSucursalModal"
                                        class="btn bg-gradient-info" style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Agregar Sucursal</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="card-body px-0 pt-0 pb-2">
                                                                                        <div class="table-responsive p-0">
                                                                                            <table class="table align-items-center mb-0">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Nombre</th>
                                                                                                        <th
                                                                                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                                                            Código</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Teléfono</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Estado</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Acción</th>
                                                                                                        <th class="text-secondary opacity-7"></th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody id="SucursalTableBody">

                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                    <nav aria-label="Page navigation example" class="items_paginations">
                                                                                        <ul class="pagination justify-content-end" id="paginationLinks1">
                                                                                            <!-- Enlaces de paginación generados dinámicamente -->
                                                                                        </ul>
                                                                                    </nav>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </main>

                                                             

        <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Cajas</h6>
                                    <div>
                                        <input type="text" id="searchInput_Caja" placeholder="Buscar caja..."
                                            class="form-control"
                                            style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#addCajaModal"
                                            class="btn bg-gradient-info" style="margin: 0px; !important" ">
                                        <i class="fas fa-plus"></i> Agregar Cajas</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nombre</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Código Caja</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Sucusal</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Estado</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Acción</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="CajaTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav aria-label="Page navigation example" class="items_paginations">
                            <ul class="pagination justify-content-end" id="paginationLinks2">
                                <!-- Enlaces de paginación generados dinámicamente -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $('#minimize_menu').click(function() {
            $('#sidenav-main').addClass('minimize-menu-side');
            $('.direction_row').addClass('direction_row_css');
            $('#esconderli').addClass('hidden_div');
            $('.size_fix').addClass('fix_size_ajust');
            $('#id_container_invoice').addClass('max_with_container');
            $('#mostrarli').removeClass('hidden_div');
            $('.nav-link-text').removeClass('ms-1');
            $('.shadow').removeClass('me-2');
        });

        $('#maximize_menu').click(function() {
            $('#sidenav-main').removeClass('minimize-menu-side');
            $('.direction_row').removeClass('direction_row_css');
            $('#esconderli').removeClass('hidden_div');
            $('.size_fix').removeClass('fix_size_ajust');
            $('#id_container_invoice').removeClass('max_with_container');
            $('#mostrarli').addClass('hidden_div');
            $('.nav-link-text').addClass('ms-1');
            $('.shadow').addClass('me-2');
        });
    </script>
    <script>
        $(document).on('click', '.fa-trash', function() {
            var SucursalId = $(this).data('sucursal-id');
            $('#confirmStatusChange').data('sucursal-id', SucursalId); // Asignar ID al botón dentro del modal.
        });

        $(document).ready(function() {
            // Define la plantilla de la URL utilizando la función route() de Laravel
            var clientUrlTemplate = "{{ route('sucursal.show', ['id' => ':id']) }}";

            // Manejador de evento para clic en el botón de editar
            $('#SucursalTableBody').on('click', '.edit-btn', function() {
                var SucursalId = $(this).data(
                    'sucursal-id'); // Obtiene el ID del cliente desde el atributo data
                var fetchUrl = clientUrlTemplate.replace(':id',
                    SucursalId); // Sustituye ':id' con el ID real del cliente

                // Realiza una solicitud AJAX para obtener los datos del cliente
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        console.log(response);

                        var sucursal = response.sucursal;
                        // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                        $('#sucursal_id_edit').val(sucursal.id);
                        $('#codigo_sucursal_edit').val(sucursal.codigo_sucursal);
                        $('#name_edit').val(sucursal.name);
                        $('#direccion_edit').val(sucursal.direccion);
                        $('#telefono_edit').val(sucursal.telefono);
                        $('#email_edit').val(sucursal.email);
                        $('#status_edit').val(sucursal.status);

                        $('#EditSucursalModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos de la sucursal:', error);
                    }
                });
            });
        });

        $(document).ready(function() {
            // Inicializar la búsqueda y paginación
            loadTableData('{{ route('sucursal.searchSucursalList') }}');

            // Evento de input para el buscador
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                loadTableData(`{{ route('sucursal.searchSucursalList') }}?query=${query}`);
            });

            function loadTableData(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let tableBody = $('#SucursalTableBody');
                        tableBody.empty();
                        response.data.forEach(sucursal => {
                            let row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${sucursal.name}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">${sucursal.codigo_sucursal }</p>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">${sucursal.telefono}</span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-${sucursal.status === 1 ? 'success' : 'danger'}">${sucursal.status === 1 ? 'Active' : 'Inactive'}</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="mx-3 edit-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-sucursal-id="${sucursal.id}">
                                    <i class="fas fa-pen text-secondary"></i>
                                </a>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="modal" data-bs-target="#confirmStatusChangeModal" data-sucursal-id="${sucursal.id}"></i>
                                </span>
                            </td>
                        </tr>`;
                            tableBody.append(row);
                        });
                        // Renderizar los enlaces de paginación
                        $('#paginationLinks1').empty();
                        if (response.links) {
                            response.links.forEach((link, index) => {
                                let label = link.label;

                                // Reemplazar las palabras "Previous" y "Next" por los símbolos de flecha
                                if (label.includes("Previous")) {
                                    label = "&laquo;"; // Flecha hacia la izquierda
                                }
                                if (label.includes("Next")) {
                                    label = "&raquo;"; // Flecha hacia la derecha
                                }

                                let activeClass = link.active ? 'active' : '';
                                let disabledClass = link.url ? '' : 'disabled';
                                let paginationLink = `
                    <li class="page-item ${activeClass} ${disabledClass}">
                        <a class="page-link" href="#" data-url="${link.url}" ${!link.url ? 'tabindex="-1"' : ''}>${label}</a>
                    </li>`;
                                $('#paginationLinks1').append(paginationLink);
                            });

                            // Habilitar la navegación por paginación al hacer clic en los enlaces
                            $('#paginationLinks1 .page-link').on('click', function(e) {
                                e.preventDefault();
                                const url = $(this).data('url');
                                if (url) {
                                    loadTableData(url); // Cargar la nueva página de resultados
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener los datos:', error);
                    }
                });
            }

            $('#EditSucursalForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting via the browser.

                var formData = new FormData(this); // Create a FormData object to pass with AJAX.
                console.log('formData:', formData);
                $.ajax({
                    url: '{{ route('sucursal.update') }}', // Adjust this to your route defined in Laravel routes.
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for 'multipart/form-data' type forms.
                    processData: false, // Required for 'multipart/form-data' type forms.

                    success: function(response) {
                        $('#responseMessageEdit').html('<div class="alert alert-success">' +
                            response.message + '</div>');
                        loadTableData('{{ route('sucursal.searchSucursalList') }}');
                        $('#EditSucursalModal').modal('hide');
                        // Additional code to handle other aspects like closing modal, refreshing data, etc.
                    },
                    error: function(response) {
                        $('#responseMessageEdit').html(
                            '<div class="alert alert-danger">Error al actualizar datos.</div>'
                        );
                        console.error('Error:', response);
                    }
                });
            });

            $('#confirmStatusChange').click(function() {
                var SucursalId = $(this).data('sucursal-id');
                $.ajax({
                    url: '{{ route('sucursal.changeStatus') }}', // Ajusta esto a tu ruta definida en las rutas de Laravel.
                    type: 'POST',
                    data: {
                        id: SucursalId,
                        status: 0,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#confirmStatusChangeModal').modal('hide');
                        loadTableData(
                            '{{ route('sucursal.searchSucursalList') }}'
                        ); // Recargar la tabla para reflejar los cambios.
                    },
                    error: function() {
                        alert('Hubo un error al cambiar el estado del cliente.');
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#addSucursalForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('sucursal.store') }}', // Cambia esta URL si es necesario
                    type: 'POST',
                    data: formData,
                    processData: false, // No procesar los datos (necesario para FormData)
                    contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                    success: function(response) {
                        // Mostrar mensaje de éxito y limpiar formulario
                        $('#responseMessage').html(
                            '<div class="alert alert-success">Sucursal agregada exitosamente.</div>'
                        );
                        $('#addSucursalForm')[0].reset();
                        loadTableData('{{ route('sucursal.searchSucursalList') }}',
                            'SucursalTableBody');
                        $('#addSucursalModal').modal('hide');
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });
                        errorHtml += '</div>';
                        $('#responseMessage').html(errorHtml);
                    }
                });
            });
        });
    </script>




    <!---- Script Caja  ----->
    <script>
        $(document).on('click', '.fa-trash', function() {
            0
            var CajaId = $(this).data('caja-id');
            $('#confirmStatusChange_caja').data('caja-id', CajaId); // Asignar ID al botón dentro del modal.
        });

        $(document).ready(function() {
            // Define la plantilla de la URL utilizando la función route() de Laravel
            var clientUrlTemplateCaja = "{{ route('caja.show', ['id' => ':id']) }}";

            // Manejador de evento para clic en el botón de editar
            $('#CajaTableBody').on('click', '.edit-btn_caja', function() {
                var CajaId = $(this).data(
                    'caja-id'); // Obtiene el ID del cliente desde el atributo data
                var fetchUrl = clientUrlTemplateCaja.replace(':id',
                    CajaId); // Sustituye ':id' con el ID real del cliente

                // Realiza una solicitud AJAX para obtener los datos del cliente
                $.ajax({
                    url: fetchUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        console.log(response);

                        var caja = response.caja;
                        // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                        $('#caja_id_edit').val(caja.id);
                        $('#codigo_caja_edit').val(caja.codigo_caja);
                        $('#name_caja_edit').val(caja.name);
                        $('#sucursal_caja_id_edit').val(caja.sucursal_id);
                        $('#status_edit_caja').val(caja.status);

                        $('#EditCajaModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos de la caja:', error);
                    }
                });
            });
        });

        $(document).ready(function() {
            // Inicializar la búsqueda y paginación
            loadTableDataCaja('{{ route('caja.searchCajaList') }}');

            // Evento de input para el buscador
            $('#searchInput_Caja').on('input', function() {
                const query = $(this).val();
                loadTableDataCaja(`{{ route('caja.searchCajaList') }}?query=${query}`);
            });

            function loadTableDataCaja(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let tableBody = $('#CajaTableBody');
                        tableBody.empty();
                        response.data.forEach(caja => {
                            let row = `
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${caja.name}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">${caja.codigo_caja}</p>
                        </td>
                        <td class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">${caja.sucursal.name}</span>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <span class="badge badge-sm bg-gradient-${caja.status === 1 ? 'success' : 'danger'}">${caja.status === 1 ? 'Active' : 'Inactive'}</span>
                        </td>
                        <td class="text-center">
                            <a href="#" class="mx-3 edit-btn_caja" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-caja-id="${caja.id}">
                                <i class="fas fa-pen text-secondary"></i>
                            </a>
                            <span>
                                <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="modal" data-bs-target="#confirmStatusChangeModal_caja" data-caja-id="${caja.id}"></i>
                            </span>
                        </td>
                    </tr>`;
                            tableBody.append(row);
                        });
                        $('#paginationLinks2').empty();
                        if (response.links) {
                            response.links.forEach((link, index) => {
                                let label = link.label;

                                // Reemplazar las palabras "Previous" y "Next" por los símbolos de flecha
                                if (label.includes("Previous")) {
                                    label = "&laquo;"; // Flecha hacia la izquierda
                                }
                                if (label.includes("Next")) {
                                    label = "&raquo;"; // Flecha hacia la derecha
                                }

                                let activeClass = link.active ? 'active' : '';
                                let disabledClass = link.url ? '' : 'disabled';
                                let paginationLink = `
                    <li class="page-item ${activeClass} ${disabledClass}">
                        <a class="page-link" href="#" data-url="${link.url}" ${!link.url ? 'tabindex="-1"' : ''}>${label}</a>
                    </li>`;
                                $('#paginationLinks2').append(paginationLink);
                            });

                            // Habilitar la navegación por paginación al hacer clic en los enlaces
                            $('#paginationLinks2 .page-link').on('click', function(e) {
                                e.preventDefault();
                                const url = $(this).data('url');
                                if (url) {
                                    loadTableDataCaja(url); // Cargar la nueva página de resultados
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener los datos:', error);
                    }
                });
            }

            $('#EditCajaForm').submit(function(e) {
                e.preventDefault(); // Prevent the form from submitting via the browser.

                var formData = new FormData(this); // Create a FormData object to pass with AJAX.
                console.log('formData:', formData);
                $.ajax({
                    url: '{{ route('caja.update') }}', // Adjust this to your route defined in Laravel routes.
                    type: 'POST',
                    data: formData,
                    contentType: false, // Required for 'multipart/form-data' type forms.
                    processData: false, // Required for 'multipart/form-data' type forms.

                    success: function(response) {
                        $('#responseMessageEdit_caja').html('<div class="alert alert-success">' +
                            response.message + '</div>');
                        loadTableDataCaja('{{ route('caja.searchCajaList') }}');
                        $('#EditCajaModal').modal('hide');
                        // Additional code to handle other aspects like closing modal, refreshing data, etc.
                    },
                    error: function(response) {
                        $('#responseMessageEdit_caja').html(
                            '<div class="alert alert-danger">Error al actualizar datos.</div>'
                        );
                        console.error('Error:', response);
                    }
                });
            });

            $('#confirmStatusChange_caja').click(function() {
                var CajaId = $(this).data('caja-id');
                $.ajax({
                    url: '{{ route('caja.changeStatus') }}', // Ajusta esto a tu ruta definida en las rutas de Laravel.
                    type: 'POST',
                    data: {
                        id: CajaId,
                        status: 0,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#confirmStatusChangeModal_caja').modal('hide');
                        loadTableDataCaja(
                            '{{ route('caja.searchCajaList') }}'
                        ); // Recargar la tabla para reflejar los cambios.
                    },
                    error: function() {
                        alert('Hubo un error al cambiar el estado de la caja.');
                    }
                });
            });

            $('#addSCajaForm').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío normal del formulario

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('caja.store') }}', // Cambia esta URL si es necesario
                    type: 'POST',
                    data: formData,
                    processData: false, // No procesar los datos (necesario para FormData)
                    contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                    success: function(response) {
                        // Mostrar mensaje de éxito y limpiar formulario
                        $('#responseMessageCaja').html(
                            '<div class="alert alert-success">Caja agregada exitosamente.</div>'
                        );
                        $('#addSCajaForm')[0].reset();
                        loadTableDataCaja('{{ route('caja.searchCajaList') }}',
                            'CajaTableBody');
                        $('#addCajaModal').modal('hide');
                    },
                    error: function(xhr) {
                        // Mostrar mensaje de error
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger">';
                        $.each(errors, function(key, value) {
                            errorHtml += '<p>' + value + '</p>';
                        });
                        errorHtml += '</div>';
                        $('#responseMessageCaja').html(errorHtml);
                    }
                });
            });
        });
    </script>
@endsection
