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
                    ¿Está seguro de que desea inactivar este cliente?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange">Inactivar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Client -->
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClientModalLabel">Agregar Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un producto -->
                    <form id="addClientForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="tipo_id">Tipo identificación</label><span class="span-red"> *</span>
                                <select class="form-select" id="tipo_id" name="tipo_id" required>
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
                                <label for="commercial_name" class="form-label">Nombre Comercial</label>
                                <input type="text" class="form-control" id="commercial_name" name="commercial_name">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                            <div class="col-md-3">
                                <label for="phone" class="form-label">Teléfono</label><span class="span-red"> *</span>
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
                                <label for="provincia">Provincia</label>
                                <select class="form-select" id="provincia" name="provincia" onchange="cargarCantones()">
                                    <option value="">Selecciona una Provincia</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="canton">Cantón</label>
                                <select class="form-select" id="canton" name="canton" onchange="cargarDistritos()">
                                    <option value="">Selecciona un Cantón</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="distrito">Distrito</label>
                                <select class="form-select" id="distrito" name="distrito">
                                    <option value="">Selecciona un Distrito</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barrio">Barrio</label>
                                <input type="text" class="form-control" id="barrio" name="barrio">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="otras_senas" class="form-label">Otras Señas</label>
                            <textarea rows="3" class="form-control" id="otras_senas" name="otras_senas"></textarea>
                        </div>

                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Client -->
    <div class="modal fade" id="EditClientModal" tabindex="-1" aria-labelledby="EditClientModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditClientModalLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un cliente -->
                    <form id="EditClientForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="client_id_edit" name="client_id_edit">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="tipo_id_edit">Tipo identificación</label><span class="span-red"> *</span>
                                <select class="form-select" id="tipo_id_edit" name="tipo_id_edit" required>
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
                                <label for="commercial_name_edit" class="form-label">Nombre Comercial</label>
                                <input type="text" class="form-control" id="commercial_name_edit"
                                    name="commercial_name_edit">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="fecha_nacimiento_edit" class="form-label">Fecha Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento_edit"
                                    name="fecha_nacimiento_edit">
                            </div>
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
                                <label for="provincia_edit">Provincia</label>
                                <select class="form-select" id="provincia_edit" name="provincia_edit"
                                    onchange="cargarCantones()">
                                    <option value="">Selecciona una Provincia</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="canton_edit">Cantón</label>
                                <select class="form-select" id="canton_edit" name="canton_edit"
                                    onchange="cargarDistritos()">
                                    <option value="">Selecciona un Cantón</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="distrito_edit">Distrito</label>
                                <select class="form-select" id="distrito_edit" name="distrito_edit">
                                    <option value="">Selecciona un Distrito</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="barrio_edit">Barrio</label>
                                <input type="text" class="form-control" id="barrio_edit" name="barrio_edit">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="otras_senas_edit" class="form-label">Otras Señas</label>
                            <textarea rows="3" class="form-control" id="otras_senas_edit" name="otras_senas_edit"></textarea>
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



    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Clientes</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar clientes..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addClientModal"
                                        class="btn bg-gradient-info" style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Agregar Cliente</button>
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
                                                                                                            Email</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                                Estado</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Acción</th>
                                                                                                        <th class="text-secondary opacity-7"></th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody id="clientsTableBody">

                                                                                                </tbody>
                                                                                            </table>
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
                                                                <script type="text/javascript">
                                                                    $(document).on('click', '.fa-trash', function() {
                                                                        var clientId = $(this).data('client-id');
                                                                        $('#confirmStatusChange').data('client-id', clientId); // Asignar ID al botón dentro del modal.
                                                                    });


                                                                    $(document).ready(function() {
                                                                        // Define la plantilla de la URL utilizando la función route() de Laravel
                                                                        var clientUrlTemplate = "{{ route('clients.show', ['id' => ':id']) }}";

                                                                        // Manejador de evento para clic en el botón de editar
                                                                        $('#clientsTableBody').on('click', '.edit-btn', function() {
                                                                            var clientId = $(this).data(
                                                                                'client-id'); // Obtiene el ID del cliente desde el atributo data
                                                                            var fetchUrl = clientUrlTemplate.replace(':id',
                                                                                clientId); // Sustituye ':id' con el ID real del cliente

                                                                            // Realiza una solicitud AJAX para obtener los datos del cliente
                                                                            $.ajax({
                                                                                url: fetchUrl,
                                                                                type: 'GET',
                                                                                dataType: 'json',
                                                                                success: function(client) {
                                                                                    // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                                                                                    $('#client_id_edit').val(client.id);
                                                                                    $('#tipo_id_edit').val(client.type_id);
                                                                                    $('#id_number_edit').val(client.id_number);
                                                                                    $('#name_edit').val(client.name);
                                                                                    $('#commercial_name_edit').val(client.commercial_name);
                                                                                    $('#fecha_nacimiento_edit').val(client.fecha_nacimiento);
                                                                                    $('#phone_edit').val(client.phone);
                                                                                    $('#email_edit').val(client.email);
                                                                                    fetchProvincias(client.province);
                                                                                    $('#canton_edit').val(client.canton);
                                                                                    $('#distrito_edit').val(client.district);
                                                                                    $('#barrio_edit').val(client.barrio);
                                                                                    $('#otras_senas_edit').val(client.other_signs);
                                                                                    $('#status_edit').val(client.status);

                                                                                    $('#EditClientModal').modal('show');
                                                                                },
                                                                                error: function(xhr, status, error) {
                                                                                    console.error('Error al cargar los datos del cliente:', error);
                                                                                }
                                                                            });
                                                                        });
                                                                    });
                                                                </script>
                                                                
                                                                <script>
                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        fetchProvincias();
                                                                        fetchCantones();
                                                                        fetchDistritos();
                                                                    });

                                                                    function fetchProvincias(selectedId = null) {
                                                                        fetch(`{{ route('clients.provincias') }}`)
                                                                            .then(response => response.json())
                                                                            .then(provincias => {
                                                                                const select = document.getElementById('provincia_edit');
                                                                                select.innerHTML = ''; // Limpia opciones existentes
                                                                                provincias.forEach(provincia => {
                                                                                    const option = document.createElement('option');
                                                                                    option.value = provincia.id;
                                                                                    option.textContent = provincia.nombre;
                                                                                    select.appendChild(option);
                                                                                });
                                                                                if (selectedId) {
                                                                                    select.value = selectedId; // Establece el valor seleccionado si se proporciona
                                                                                }
                                                                            });
                                                                    }

                                                                    function fetchCantones(selectedIdC = null) {
                                                                        fetch(`{{ route('clients.cantones') }}`)
                                                                            .then(response => response.json())
                                                                            .then(cantones => {
                                                                                const select = document.getElementById('canton_edit');
                                                                                select.innerHTML = ''; // Limpia opciones existentes
                                                                                cantones.forEach(canton => {
                                                                                    const option = document.createElement('option');
                                                                                    option.value = canton.id;
                                                                                    option.textContent = canton.nombre;
                                                                                    select.appendChild(option);
                                                                                });
                                                                                if (selectedIdC) {
                                                                                    select.value = selectedIdC; // Establece el valor seleccionado si se proporciona
                                                                                }
                                                                            });
                                                                    }


                                                                    function fetchDistritos(selectedIdD = null) {
                                                                        fetch(`{{ route('clients.distritos') }}`)
                                                                            .then(response => response.json())
                                                                            .then(distritos => {
                                                                                const select = document.getElementById('distrito_edit');
                                                                                select.innerHTML = ''; // Limpia opciones existentes
                                                                                distritos.forEach(distrito => {
                                                                                    const option = document.createElement('option');
                                                                                    option.value = distrito.id;
                                                                                    option.textContent = distrito.nombre;
                                                                                    select.appendChild(option);
                                                                                });
                                                                                if (selectedIdD) {
                                                                                    select.value = selectedIdD; // Establece el valor seleccionado si se proporciona
                                                                                }
                                                                            });
                                                                    }




                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        fetch(`{{ route('clients.provincias') }}`)
                                                                            .then(response => response.json())
                                                                            .then(provincias => {
                                                                                const select = document.getElementById('provincia');
                                                                                provincias.forEach(provincia => {
                                                                                    const option = document.createElement('option');
                                                                                    option.value = provincia.id;
                                                                                    option.textContent = provincia.nombre;
                                                                                    select.appendChild(option);
                                                                                });
                                                                            });
                                                                    });

                                                                    function cargarCantones() {
                                                                        const provinciaId = document.getElementById('provincia').value;
                                                                        fetch(`{{ route('clients.cantones') }}`)
                                                                            .then(response => response.json())
                                                                            .then(cantones => {
                                                                                const select = document.getElementById('canton');
                                                                                select.innerHTML = '<option value="">Selecciona un cantón</option>';
                                                                                cantones.filter(canton => canton.provinciaId === provinciaId)
                                                                                    .forEach(canton => {
                                                                                        const option = document.createElement('option');
                                                                                        option.value = canton.id;
                                                                                        option.textContent = canton.nombre;
                                                                                        select.appendChild(option);
                                                                                    });
                                                                            });
                                                                    }

                                                                    function cargarDistritos() {
                                                                        const cantonId = document.getElementById('canton').value;
                                                                        fetch(`{{ route('clients.distritos') }}`)
                                                                            .then(response => response.json())
                                                                            .then(distritos => {
                                                                                const select = document.getElementById('distrito');
                                                                                select.innerHTML = '<option value="">Selecciona un distrito</option>';
                                                                                distritos.filter(distrito => distrito.cantonId === cantonId)
                                                                                    .forEach(distrito => {
                                                                                        const option = document.createElement('option');
                                                                                        option.value = distrito.id;
                                                                                        option.textContent = distrito.nombre;
                                                                                        select.appendChild(option);
                                                                                    });
                                                                            });
                                                                    }
                                                                </script>
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        // Inicializar la búsqueda y paginación
                                                                        loadTableData('{{ route('clients.searchClientList') }}');

                                                                        // Evento de input para el buscador
                                                                        $('#searchInput').on('input', function() {
                                                                            const query = $(this).val();
                                                                            loadTableData(`{{ route('clients.searchClientList') }}?query=${query}`);
                                                                        });

                                                                        function loadTableData(url) {
                                                                            $.ajax({
                                                                                url: url,
                                                                                type: 'GET',
                                                                                dataType: 'json',
                                                                                success: function(response) {
                                                                                    let tableBody = $('#clientsTableBody');
                                                                                    tableBody.empty();
                                                                                    response.data.forEach(clients => {
                                                                                        let row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="http://localhost/sist_fact_v1/public/storage/images/usuario.webp" style="object-fit: contain;" class="avatar avatar-sm me-3" alt="${clients.name}">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${clients.name}</h6>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${clients.id_number}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${clients.phone}</p>
                            </td>
                            <td style="text-align: center;">
                                <p class="text-xs font-weight-bold mb-0">${clients.email}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-${clients.status === 1 ? 'success' : 'danger'}">${clients.status === 1 ? 'Active' : 'Inactive'}</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="mx-3 edit-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-client-id="${clients.id}">
                                    <i class="fas fa-pen text-secondary"></i>
                                </a>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="modal" data-bs-target="#confirmStatusChangeModal" data-client-id="${clients.id}"></i>
                                </span>
                            </td>
                        </tr>`;
                                                                                        tableBody.append(row);
                                                                                    });
                                                                                    // Renderizar los enlaces de paginación
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

                                                                        $('#EditClientForm').submit(function(e) {
                                                                            e.preventDefault(); // Prevent the form from submitting via the browser.

                                                                            var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                                                                            $.ajax({
                                                                                url: '{{ route('clients.update') }}', // Adjust this to your route defined in Laravel routes.
                                                                                type: 'POST',
                                                                                data: formData,
                                                                                contentType: false, // Required for 'multipart/form-data' type forms.
                                                                                processData: false, // Required for 'multipart/form-data' type forms.
                                                                                success: function(response) {
                                                                                    $('#responseMessageEdit').html('<div class="alert alert-success">' +
                                                                                        response.message + '</div>');
                                                                                    loadTableData('{{ route('clients.searchClientList') }}');
                                                                                    $('#EditClientModal').modal('hide');
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

                                                                        $('#addClientForm').on('submit', function(e) {
                                                                            e.preventDefault(); // Prevenir el envío normal del formulario

                                                                            var formData = new FormData(this);

                                                                            $.ajax({
                                                                                url: '{{ route('clients.store') }}', // Cambia esta URL si es necesario
                                                                                type: 'POST',
                                                                                data: formData,
                                                                                processData: false, // No procesar los datos (necesario para FormData)
                                                                                contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                                                                                success: function(response) {
                                                                                    // Mostrar mensaje de éxito y limpiar formulario
                                                                                    $('#responseMessage').html(
                                                                                        '<div class="alert alert-success">Cliente agregado exitosamente.</div>'
                                                                                    );
                                                                                    loadTableData('{{ route('clients.searchClientList') }}');
                                                                                    $('#EditClientModal').modal('hide');
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
                                                                            var clientId = $(this).data('client-id');
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
                                                                                        '{{ route('clients.searchClientList') }}'
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
