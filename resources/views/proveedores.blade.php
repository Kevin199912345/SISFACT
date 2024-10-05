@extends('layouts.user_type.auth')

@section('content')
    <!-- Modal delete Client -->
    <div class="modal fade" id="confirmStatusChangeModal" tabindex="-1" aria-labelledby="confirmStatusChangeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusChangeModalLabel">Confirmar Cambio de Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea inactivar este proveedor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange">Inactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Proveedor -->
    <div class="modal fade" id="addProveedorModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Agregar Nuevo Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un producto -->
                    <form id="addProveedorForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="type_id">Tipo identificación</label><span class="span-red"> *</span>
                                <select class="form-select" id="type_id" name="type_id" required>
                                    <option value="" selected="" disabled=""> --- Seleccione --- </option>
                                    <option value="01"> Físico Nacional </option>
                                    <option value="02"> Jurídica Nacional </option>
                                    <option value="03"> DIMEX </option>
                                    <option value="04"> NITE </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="id_number" class="form-label">Número de identificación</label><span
                                    class="span-red"> *</span>
                                <input type="number" class="form-control" id="id_number" name="id_number" required>
                            </div>
                            <div class="col-md-3">
                                <label for="name" class="form-label">Nombre</label><span class="span-red"> *</span>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="phone" class="form-label">Teléfono</label><span class="span-red">
                                    *</span>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label><span class="span-red">
                                    *</span>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto">
                            </div>
                            <div class="col-md-3">
                                <label for="phone_contacto">Teléfono Contacto</label>
                                <input type="text" class="form-control" id="phone_contacto" name="phone_contacto">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="metodo_pago">Metodo de Pago</label>
                                <input type="text" class="form-control" id="metodo_pago" name="metodo_pago">
                            </div>
                            <div class="col-md-3">
                                <label for="cuenta_bancaria">Cuenta Bancaría</label>
                                <input type="text" class="form-control" id="cuenta_bancaria" name="cuenta_bancaria">
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

    <!-- Modal Edit Proveedor -->
    <div class="modal fade" id="EditProveedorModal" tabindex="-1" aria-labelledby="EditProveedorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditProveedorModalLabel">Editar Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un proveedor -->
                    <form id="EditProveedorForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="proveedor_id_edit" name="proveedor_id_edit">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="type_id_edit">Tipo identificación</label><span class="span-red"> *</span>
                                <select class="form-select" id="type_id_edit" name="type_id_edit" required>
                                    <option value="" selected="" disabled=""> --- Seleccione --- </option>
                                    <option value="01"> Físico Nacional </option>
                                    <option value="02"> Jurídica Nacional </option>
                                    <option value="03"> DIMEX </option>
                                    <option value="04"> NITE </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="id_number_edit" class="form-label">Número de identificación</label><span
                                    class="span-red"> *</span>
                                <input type="number" class="form-control" id="id_number_edit" name="id_number_edit"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label for="name_edit" class="form-label">Nombre</label><span class="span-red"> *</span>
                                <input type="text" class="form-control" id="name_edit" name="name_edit" required>
                            </div>
                            <div class="col-md-3">
                                <label for="direccion_edit" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion_edit" name="direccion_edit">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="phone_edit" class="form-label">Teléfono</label><span class="span-red">
                                    *</span>
                                <input type="number" class="form-control" id="phone_edit" name="phone_edit" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email_edit" class="form-label">Correo Electrónico</label><span
                                    class="span-red">
                                    *</span>
                                <input type="email" class="form-control" id="email_edit" name="email_edit" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="contacto_edit">Contacto</label>
                                <input type="text" class="form-control" id="contacto_edit" name="contacto_edit">
                            </div>
                            <div class="col-md-3">
                                <label for="phone_contacto_edit">Teléfono Contacto</label>
                                <input type="text" class="form-control" id="phone_contacto_edit"
                                    name="phone_contacto_edit">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status_edit" class="form-label">Estado</label>
                            <select class="form-select" id="status_edit" name="status_edit">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="metodo_pago_edit">Metodo de Pago</label>
                                <input type="text" class="form-control" id="metodo_pago_edit"
                                    name="metodo_pago_edit">
                            </div>
                            <div class="col-md-3">
                                <label for="cuenta_bancaria_edit">Cuenta Bancaría</label>
                                <input type="text" class="form-control" id="cuenta_bancaria_edit"
                                    name="cuenta_bancaria_edit">
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
                                <h6 class="mb-0">Proveedores</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar proveedores..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addProveedorModal"
                                        class="btn bg-gradient-info" style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Agregar Proveedor</button>
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
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                Cédula</th>
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
                                                                                                    <tbody id="proveedorTableBody">

                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                        <nav aria-label="Page navigation example" class="items_paginations">
                                                                                            <ul class="pagination justify-content-end" id="paginationLinks">
                                                                                                <!-- Enlaces de paginación generados dinámicamente -->
                                                                                            </ul>
                                                                                        </nav>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </main>
                                                                    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
                                                                    <script type="text/javascript">
                                                                        $(document).on('click', '.fa-trash', function() {
                                                                            var proveedorId = $(this).data('proveedor-id');
                                                                            $('#confirmStatusChange').data('proveedor-id', proveedorId); // Asignar ID al botón dentro del modal.
                                                                        });


                                                                        $(document).ready(function() {
                                                                            // Define la plantilla de la URL utilizando la función route() de Laravel
                                                                            var clientUrlTemplate = "{{ route('proveedor.show', ['id' => ':id']) }}";

                                                                            // Manejador de evento para clic en el botón de editar
                                                                            $('#proveedorTableBody').on('click', '.edit-btn', function() {
                                                                                var proveedorId = $(this).data(
                                                                                    'proveedor-id'); // Obtiene el ID del cliente desde el atributo data
                                                                                var fetchUrl = clientUrlTemplate.replace(':id',
                                                                                    proveedorId); // Sustituye ':id' con el ID real del cliente

                                                                                // Realiza una solicitud AJAX para obtener los datos del cliente
                                                                                $.ajax({
                                                                                    url: fetchUrl,
                                                                                    type: 'GET',
                                                                                    dataType: 'json',
                                                                                    success: function(proveedor) {
                                                                                        // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                                                                                        $('#proveedor_id_edit').val(proveedor.id);
                                                                                        $('#type_id_edit').val(proveedor.type_id);
                                                                                        $('#id_number_edit').val(proveedor.id_number);
                                                                                        $('#name_edit').val(proveedor.name);
                                                                                        $('#direccion_edit').val(proveedor.direccion);
                                                                                        $('#phone_edit').val(proveedor.phone);
                                                                                        $('#email_edit').val(proveedor.email);
                                                                                        $('#contacto_edit').val(proveedor.contacto);
                                                                                        $('#phone_contacto_edit').val(proveedor.phone_contacto);
                                                                                        $('#status_edit').val(proveedor.status);
                                                                                        $('#metodo_pago_edit').val(proveedor.metodo_pago);
                                                                                        $('#cuenta_bancaria_edit').val(proveedor.cuenta_bancaria);

                                                                                        $('#EditProveedorModal').modal('show');
                                                                                    },
                                                                                    error: function(xhr, status, error) {
                                                                                        console.error('Error al cargar los datos del proveedor:', error);
                                                                                    }
                                                                                });
                                                                            });
                                                                        });
                                                                    </script>
                                                                    
                                                                
                                                                    <script>
                                                                        $(document).ready(function() {
                                                                            // Inicializar la búsqueda y paginación
                                                                            loadTableData('{{ route('proveedor.searchProveedorList') }}');

                                                                            // Evento de input para el buscador
                                                                            $('#searchInput').on('input', function() {
                                                                                const query = $(this).val();
                                                                                loadTableData(`{{ route('proveedor.searchProveedorList') }}?query=${query}`);
                                                                            });

                                                                            function loadTableData(url) {
                                                                                $.ajax({
                                                                                    url: url,
                                                                                    type: 'GET',
                                                                                    dataType: 'json',
                                                                                    success: function(response) {
                                                                                        let tableBody = $('#proveedorTableBody');
                                                                                        tableBody.empty();
                                                                                        response.data.forEach(proveedor => {
                                                                                            let row = `
                        <tr>
                            <td  >
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="http://localhost/sist_fact_v1/public/storage/images/proveedor.webp" style="object-fit: contain;" class="avatar avatar-sm me-3" alt="${proveedor.name}">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${proveedor.name}</h6>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${proveedor.id_number}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${proveedor.phone}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-${proveedor.status === 1 ? 'success' : 'danger'}">${proveedor.status === 1 ? 'Active' : 'Inactive'}</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="mx-3 edit-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-proveedor-id="${proveedor.id}">
                                    <i class="fas fa-pen text-secondary"></i>
                                </a>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="modal" data-bs-target="#confirmStatusChangeModal" data-proveedor-id="${proveedor.id}"></i>
                                </span>
                            </td>
                        </tr>`;
                                                                                            tableBody.append(row);
                                                                                        });
                                                                                        $('#paginationLinks').empty();
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
                                                                                                $('#paginationLinks').append(paginationLink);
                                                                                            });

                                                                                            // Habilitar la navegación por paginación al hacer clic en los enlaces
                                                                                            $('#paginationLinks .page-link').on('click', function(e) {
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

                                                                            $('#EditProveedorForm').submit(function(e) {
                                                                                e.preventDefault(); // Prevent the form from submitting via the browser.

                                                                                var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                                                                                $.ajax({
                                                                                    url: '{{ route('proveedor.update') }}', // Adjust this to your route defined in Laravel routes.
                                                                                    type: 'POST',
                                                                                    data: formData,
                                                                                    contentType: false, // Required for 'multipart/form-data' type forms.
                                                                                    processData: false, // Required for 'multipart/form-data' type forms.
                                                                                    success: function(response) {
                                                                                        $('#responseMessageEdit').html('<div class="alert alert-success">' +
                                                                                            response.message + '</div>');
                                                                                        $('#EditProveedorForm')[0].reset();
                                                                                        loadTableData('{{ route('proveedor.searchProveedorList') }}');
                                                                                        $('#EditProveedorModal').modal('hide');
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

                                                                            $('#addProveedorForm').on('submit', function(e) {
                                                                                e.preventDefault(); // Prevenir el envío normal del formulario

                                                                                var formData = new FormData(this);

                                                                                $.ajax({
                                                                                    url: '{{ route('proveedor.store') }}', // Cambia esta URL si es necesario
                                                                                    type: 'POST',
                                                                                    data: formData,
                                                                                    processData: false, // No procesar los datos (necesario para FormData)
                                                                                    contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                                                                                    success: function(response) {
                                                                                        // Mostrar mensaje de éxito y limpiar formulario
                                                                                        $('#responseMessage').html(
                                                                                            '<div class="alert alert-success">Proveedor agregado exitosamente.</div>'
                                                                                        );
                                                                                        $('#addProveedorForm')[0].reset();
                                                                                        loadTableData('{{ route('proveedor.searchProveedorList') }}');
                                                                                        $('#addProveedorModal').modal('hide');
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

                                                                            $('#confirmStatusChange').click(function() {
                                                                                var proveedortId = $(this).data('proveedor-id');
                                                                                $.ajax({
                                                                                    url: '{{ route('proveedor.changeStatus') }}', // Ajusta esto a tu ruta definida en las rutas de Laravel.
                                                                                    type: 'POST',
                                                                                    data: {
                                                                                        id: proveedortId,
                                                                                        status: 0,
                                                                                        _token: '{{ csrf_token() }}'
                                                                                    },
                                                                                    success: function(response) {
                                                                                        $('#confirmStatusChangeModal').modal('hide');
                                                                                        loadTableData(
                                                                                            '{{ route('proveedor.searchProveedorList') }}'
                                                                                        ); // Recargar la tabla para reflejar los cambios.
                                                                                    },
                                                                                    error: function() {
                                                                                        alert('Hubo un error al cambiar el estado del proveedor.');
                                                                                    }
                                                                                });
                                                                            });
                                                                        });
                                                                    </script>
@endsection
