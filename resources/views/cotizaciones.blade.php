@extends('layouts.user_type.auth')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="modal fade" id="addCotizacionModal" tabindex="-1" aria-labelledby="addCotizacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 95% !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCotizacionModalLabel">Nueva Cotización</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para realizar nueva cotización -->
                    <form id="addCotizacionForm" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="cotizacion_id" name="cotizacion_id">

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="num_cotizacion" class="form-label">Número de Cotización</label><span
                                    class="span-red">
                                    *</span>
                                <input type="text" class="form-control" id="num_cotizacion" name="num_cotizacion"
                                    required readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="searchClient" class="form-label">Cliente</label><span class="span-red">
                                    *</span>
                                <input type="text" class="form-control" autocomplete="off" name="searchClient"
                                    id="searchClient" placeholder="Escriba para buscar el cliente" required>
                                <div id="clientResults"
                                    style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 5px; display: none;">
                                    <!-- Encabezado de dos columnas -->
                                    <div id="clientResultsHeader"
                                        style="display: none; font-weight: bold; padding: 5px; border-bottom: 1px solid #000; background-color: #f0f0f0;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <span style="width: 40%;">Cédula</span>
                                            <span style="width: 60%;">Nombre</span>
                                        </div>
                                    </div>
                                    <!-- Los resultados se mostrarán aquí -->
                                    <div id="clientResultsList"></div>
                                </div>


                                <!-- Campo oculto para almacenar el ID del cliente seleccionado -->
                                <input type="hidden" id="selectedClientId" name="client_id">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_creacion" class="form-label">Fecha Creación</label><span class="span-red">
                                    *</span>
                                <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento</label><span
                                    class="span-red">
                                    *</span>
                                <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="searchProducto" class="form-label">Búsqueda de Productos</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" autocomplete="off" name="searchProducto"
                                    id="searchProducto" placeholder="Escriba para buscar el producto">
                                <div id="productsResults"
                                    style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 5px; display: none;">
                                    <!-- Encabezado de dos columnas -->
                                    <div id="productsResultsHeader"
                                        style="display: none; font-weight: bold; padding: 5px; border-bottom: 1px solid #000; background-color: #f0f0f0;">
                                        <div style="display: flex; justify-content: space-between;">
                                            <span style="width: 30%;">Imagen</span>
                                            <span style="width: 30%;">Código</span>
                                            <span style="width: 30%;">Nombre</span>
                                            <span style="width: 10%;">Precio</span>
                                        </div>
                                    </div>
                                    <!-- Los resultados se mostrarán aquí -->
                                    <div id="ProductoResultsList"></div>
                                </div>
                                <!-- Campo oculto para almacenar el ID del cliente seleccionado -->
                                <input type="hidden" id="selectedProductId" name="product_id">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="credito" id="inlineCheckbox1"
                                        value="1">
                                    <label class="form-check-label" for="inlineCheckbox1">Crédito</label>
                                </div>
                                <div id="plazoContainer" class="d-flex align-items-center ms-3 hidden-important">
                                    <label for="plazo" class="form-label me-2">Plazo (días)</label>
                                    <input type="number" class="form-control" id="plazo" name="plazo"
                                        min="1" style="width: 80px; text-align: center;">
                                </div>
                            </div>
                        </div>


                        <!-- Tabla para mostrar los productos seleccionados -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-container">
                                    <table class="table table-bordered" id="selectedProductsTable"
                                        style="display: none;">
                                        <thead class="table-header">
                                            <tr>
                                                <th>Código</th>
                                                <th>Descripción</th>
                                                <th>Precio</th>
                                                <th>% Impuesto</th>
                                                <th>Cantidad</th>
                                                <th>% Descuento</th>
                                                <th>Total</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los productos seleccionados se agregarán aquí -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="6"
                                        placeholder="Escribe tus observaciones aquí..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span>Subtotal:</span>
                                            <span id="subtotalDisplay">₡0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Impuestos:</span>
                                            <span id="taxDisplay">₡0.00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Descuentos:</span>
                                            <span id="discountDisplay">₡0.00</span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span>Total:</span>
                                            <span id="totalDisplay">₡0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>






                        <div class="btn_coti mt-3">
                            <button type="submit" id="btn_text_form" class="btn bg-gradient-success">Realizar
                                Cotización</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    <div id="responseMessageAddRetiro" class="mt-3"></div>
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
                                <h6 class="mb-0">Cotizaciones</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar cotizaciones..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" class="btn bg-gradient-info" id="new_cotizacion"
                                        style="margin: 0px; !important">
                                        <i class="fas fa-plus"></i> Nueva Cotización
                                    </button>
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
                                                # Cotización</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Cliente</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Fecha Creación</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Total</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Estado</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Acción</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="cotizacionesTableBody">

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
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        let isEditMode = false; // Variable global para identificar el modo

        $(document).ready(function() {

            $('#new_cotizacion').on('click', function() {
                $.ajax({
                    url: '{{ route('cotizaciones.getNextNumber') }}', // Asegúrate de tener esta ruta en tu archivo de rutas
                    type: 'GET',
                    success: function(response) {
                        $('#num_cotizacion').val(response.nextNumber);
                    },
                    error: function(error) {
                        console.error('Error al obtener el número de cotización:', error);
                    }
                });
            });

            // Limpiar los campos solo cuando es modo creación
            $('#addCotizacionModal').on('shown.bs.modal', function() {
                if (!isEditMode) {
                    // Solo limpiar si es un nuevo registro (creación)
                    $('#searchClient').val('');
                    $('#clientResults').empty().hide();
                    $('#selectedClientId').val('');
                    $('#observaciones').val('');
                    $('#fecha_vencimiento').val('');
                    $('#cotizacion_id').val('');
                    $('#clientResultsHeader').hide();

                    $('#searchProducto').val('');
                    $('#productsResults').empty().hide();
                    $('#selectedProductId').val('');
                    $('#productsResultsHeader').val('');


                    // Desmarcar el checkbox de crédito y ocultar el campo de plazo
                    $('#inlineCheckbox1').prop('checked', false);
                    $('#plazoContainer').hide();
                    $('#plazo').val(''); // Limpiar el valor del campo plazo

                    // Limpiar la tabla de productos seleccionados
                    $('#selectedProductsTable tbody').empty();
                    $('#subtotalDisplay').text('₡0.00');
                    $('#taxDisplay').text('₡0.00');
                    $('#discountDisplay').text('₡0.00');
                    $('#totalDisplay').text('₡0.00');
                }
            });

            // Función para manejar la búsqueda de clientes
            $('#searchClient').on('input', function() {
                let query = $(this).val();

                if (query.length >= 2) { // Realizar la búsqueda solo si hay 2 o más caracteres
                    $.ajax({
                        url: '{{ route('cotizaciones.searchClientes') }}', // Cambia esta ruta a tu ruta real
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            let clients = response
                                .data; // Supongamos que tu respuesta es del tipo { data: [...] }
                            let resultsContainer = $('#clientResults');

                            resultsContainer.empty();

                            if (clients.length > 0) {
                                $('#clientResultsHeader').show(); // Mostrar el encabezado
                                resultsContainer.append($(
                                    '#clientResultsHeader'
                                )); // Asegurarse de que el encabezado esté en la parte superior

                                clients.forEach(client => {
                                    let clientItem = $('<div>')
                                        .addClass('client-item')
                                        .css({
                                            padding: '5px',
                                            cursor: 'pointer',
                                            borderBottom: '1px solid #ddd',
                                            display: 'flex',
                                            justifyContent: 'space-between'
                                        })
                                        .data('client-id', client
                                            .id
                                        ) // Almacenar el ID del cliente en el elemento
                                        .on('click', function() {
                                            // Cuando se hace clic en un cliente, actualizar el input con el nombre y guardar el ID en un campo oculto
                                            $('#searchClient').val(client.name);
                                            $('#selectedClientId').val(client.id);
                                            resultsContainer
                                                .hide(); // Ocultar los resultados
                                        });

                                    // Agregar la cédula y el nombre al resultado
                                    clientItem.append(
                                        `<span style="width: 40%;">${client.id_number}</span>`
                                    );
                                    clientItem.append(
                                        `<span style="width: 60%;">${client.name}</span>`
                                    );

                                    resultsContainer.append(clientItem);
                                });

                                resultsContainer.show(); // Mostrar el contenedor de resultados
                            } else {
                                $('#clientResultsHeader')
                                    .hide(); // Esconder el encabezado si no hay resultados
                                resultsContainer.hide(); // Ocultar si no hay resultados
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al buscar clientes:', error);
                        }
                    });
                } else {
                    $('#clientResultsHeader').hide(); // Esconder el encabezado si hay menos de 2 caracteres
                    $('#clientResults').empty()
                        .hide(); // Limpiar y ocultar los resultados si hay menos de 2 caracteres
                }
            });


            $('#searchProducto').on('input', function() {
                let query = $(this).val();

                if (query.length >= 2) { // Realizar la búsqueda solo si hay 2 o más caracteres
                    $.ajax({
                        url: '{{ route('cotizaciones.searchProductos') }}', // Cambia esta ruta a tu ruta real
                        type: 'GET',
                        data: {
                            query: query
                        },
                        success: function(response) {
                            let productos = response
                                .data; // Supongamos que tu respuesta es del tipo { data: [...] }
                            let resultsContainer = $('#productsResults');

                            resultsContainer.empty();

                            if (productos.length > 0) {
                                $('#productsResultsHeader').show(); // Mostrar el encabezado
                                resultsContainer.append($(
                                    '#productsResultsHeader'
                                )); // Asegurarse de que el encabezado esté en la parte superior

                                productos.forEach(producto => {
                                    let productItem = $('<div>')
                                        .addClass('producto-item')
                                        .css({
                                            padding: '5px',
                                            cursor: 'pointer',
                                            borderBottom: '1px solid #ddd',
                                            display: 'flex',
                                            justifyContent: 'space-between'
                                        })
                                        .data('product-id', producto
                                            .id
                                        ) // Almacenar el ID del producto en el elemento
                                        .on('click', function() {
                                            // Agregar el producto a la tabla
                                            addProductToTable(producto);

                                            // Limpiar el input y ocultar los resultados
                                            $('#searchProducto').val('');
                                            $('#selectedProductId').val('');
                                            resultsContainer.hide();
                                        });

                                    let imageUrl;
                                    if (producto.image_url) {
                                        imageUrl =
                                            `http://localhost/sist_fact_v1/public/${producto.image_url}`;
                                    } else {
                                        imageUrl =
                                            '{{ asset('assets/img/elegir.webp') }}';
                                    }

                                    productItem.append(
                                        `<span style="width: 20%;">
                                    <img src="${imageUrl}" style="object-fit: contain;" class="avatar avatar-sm me-3" alt="${producto.name || 'Product Image'}">
                                </span>`
                                    );

                                    productItem.append(
                                        `<span style="width: 30%;">${producto.barcode}</span>`
                                    );
                                    productItem.append(
                                        `<span style="width: 40%;">${producto.descripcion}</span>`
                                    );

                                    productItem.append(
                                        `<span style="width: 10%;">${producto.price_sell}</span>`
                                    );

                                    resultsContainer.append(productItem);
                                });

                                resultsContainer.show(); // Mostrar el contenedor de resultados
                            } else {
                                $('#productsResultsHeader')
                                    .hide(); // Esconder el encabezado si no hay resultados
                                resultsContainer.hide(); // Ocultar si no hay resultados
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al buscar productos:', error);
                        }
                    });
                } else {
                    $('#productsResultsHeader')
                        .hide(); // Esconder el encabezado si hay menos de 2 caracteres
                    $('#productsResults').empty()
                        .hide(); // Limpiar y ocultar los resultados si hay menos de 2 caracteres
                }
            });



            function addProductToTable(producto) {
                let table = $('#selectedProductsTable');
                let tbody = table.find('tbody');

                // Determinar si el producto viene de 'products' o 'cotizaciones_details'
                let isCotizacionDetail = producto.hasOwnProperty('cotizacion_id');

                // Obtener las propiedades según la fuente de datos
                let barcode = isCotizacionDetail ? producto.barcode : producto.barcode || 'N/A';
                let description = isCotizacionDetail ? producto.description : producto.descripcion || 'N/A';
                let price = isCotizacionDetail ? producto.precio_unitario : producto.price || 0;
                let priceSell = isCotizacionDetail ? producto.total : producto.price_sell || 0;
                let taxPercentage = isCotizacionDetail ? producto.taxes : producto.tax_percentage || 0;
                let discount = isCotizacionDetail ? producto.discount : 0;
                let quantity = isCotizacionDetail ? producto.quantity : 1;

                // Verificar si el producto ya está en la tabla
                let existingRow = tbody.find(`tr[data-product-id="${producto.id}"]`);
                if (existingRow.length > 0) {
                    let quantityInput = existingRow.find('.product-quantity');
                    let currentQuantity = parseFloat(quantityInput
                        .val()); // Usamos parseFloat para manejar decimales
                    let newQuantity = (currentQuantity + 1.00).toFixed(2); // Incrementamos en 1.00
                    quantityInput.val(newQuantity);

                    // Actualizar el total en la columna correspondiente
                    let total = price * newQuantity;
                    existingRow.find('.product-total').text(total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                } else {
                    // Si el producto no está en la tabla, agregar una nueva fila
                    let row = `
        <tr data-product-id="${producto.id}">
            <td>${barcode}</td>
            <td>${description}</td>
            <td data-value="${price}">${parseFloat(price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td data-value="${taxPercentage}">${parseFloat(taxPercentage).toFixed(2)}</td>
            <td>
                <div class="quantity-controls" style="display: flex; align-items: center;">
                    <button type="button" class="btn btn-sm btn-outline-secondary decrease-quantity">-</button>
                    <input type="number" class="form-control product-quantity" value="${parseFloat(quantity).toFixed(2)}" min="0.01" step="0.01" style="width: 80px; text-align: center; margin-bottom: 1rem;">
                    <button type="button" class="btn btn-sm btn-outline-secondary increase-quantity">+</button>
                </div>
            </td>
            <td style="text-align: center; display: flex; align-items: center; justify-content: center;">
                <input type="number" class="form-control product-discount" value="${parseFloat(discount).toFixed(0)}" min="0" max="100" style="width: 60px; text-align: center;">
            </td>
            <td class="product-total">${parseFloat(priceSell).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button>
            </td>
        </tr>
        `;

                    tbody.append(row);
                    table.show();
                }

                // Eventos para el aumento/disminución de cantidad
                $('.increase-quantity').off('click').on('click', function() {
                    let quantityInput = $(this).siblings('.product-quantity');
                    let currentQuantity = parseFloat(quantityInput
                        .val()); // Usamos parseFloat para manejar decimales
                    let newQuantity = (currentQuantity + 1.00).toFixed(2); // Incrementamos en 1.00
                    quantityInput.val(newQuantity).trigger('input'); // Actualizamos el valor con decimales
                });

                $('.decrease-quantity').off('click').on('click', function() {
                    let quantityInput = $(this).siblings('.product-quantity');
                    let currentQuantity = parseFloat(quantityInput
                        .val()); // Usamos parseFloat para manejar decimales
                    if (currentQuantity > 1.00) {
                        let newQuantity = (currentQuantity - 1.00).toFixed(2); // Decrementamos en 1.00
                        quantityInput.val(newQuantity).trigger(
                            'input'); // Actualizamos el valor con decimales
                    }
                });

                // Permitir ingreso manual en el input
                $('.product-quantity').off('input').on('input', function() {
                    let value = parseFloat($(this).val());

                    // Si el valor ingresado es inválido o menor que el mínimo, establecer un valor por defecto
                    if (isNaN(value) || value < 0.01) {
                        $(this).val(0.01);
                    }
                });

                // Actualizar el total cuando cambie la cantidad o el descuento
                $('.product-quantity, .product-discount').off('input').on('input', function() {
                    let row = $(this).closest('tr');
                    let quantity = parseFloat(row.find('.product-quantity').val()) ||
                        1.00; // Usar parseFloat para cantidades decimales
                    let discountPercentage = parseFloat(row.find('.product-discount').val()) || 0;
                    let price = parseFloat(row.find('td:nth-child(3)').data('value'));
                    let taxPercentage = parseFloat(row.find('td:nth-child(4)').data('value'));
                    let total = price * quantity;

                    // Calcular el monto de descuento
                    let discountAmount = total * (discountPercentage / 100);
                    total -= discountAmount;

                    // Calcular el monto de impuesto
                    let taxAmount = total * (taxPercentage / 100);
                    total += taxAmount;

                    row.find('.product-total').text(total.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));

                    updateTotals();
                });

                // Evento para eliminar la fila del producto
                $('.remove-product').off('click').on('click', function() {
                    $(this).closest('tr').remove();
                    if (tbody.children().length === 0) {
                        table.hide();
                    }
                    updateTotals();
                });

                updateTotals();
            }

            function updateTotals() {
                let subtotal = 0;
                let totalDiscount = 0;
                let totalTax = 0;
                let totalGeneral = 0;

                $('#selectedProductsTable tbody tr').each(function() {
                    let price = parseFloat($(this).find('td:nth-child(3)').data(
                        'value')); // Precio sin impuestos
                    let quantity = parseFloat($(this).find('.product-quantity')
                        .val()); // Cantidad con decimales
                    let taxPercentage = parseFloat($(this).find('td:nth-child(4)').data(
                        'value')); // % de impuesto
                    let discountPercentage = parseFloat($(this).find('.product-discount')
                        .val()); // % de descuento

                    // Verificar si los valores son válidos
                    if (isNaN(price)) price = 0;
                    if (isNaN(quantity)) quantity = 1;
                    if (isNaN(taxPercentage)) taxPercentage = 0;
                    if (isNaN(discountPercentage)) discountPercentage = 0;

                    // 1. Calcular el subtotal del producto sin impuestos ni descuentos (price * quantity)
                    let productSubtotal = price * quantity;

                    // 2. Calcular el monto del descuento (si lo hay) y restarlo
                    let discountAmount = productSubtotal * (discountPercentage / 100);
                    let subtotalAfterDiscount = productSubtotal - discountAmount;

                    // Acumular el descuento total
                    totalDiscount += discountAmount;

                    // 3. Calcular el monto del impuesto (IVA) sobre el subtotal después del descuento
                    let taxAmount = subtotalAfterDiscount * (taxPercentage / 100);

                    // Acumular los impuestos totales
                    totalTax += taxAmount;

                    // 4. El total general del producto después de aplicar descuento e impuestos
                    let productTotal = subtotalAfterDiscount + taxAmount;

                    // Sumar al subtotal general (antes de impuestos y descuentos)
                    subtotal += productSubtotal;

                    // Sumar al total general (después de impuestos y descuentos)
                    totalGeneral += productTotal;

                    // Actualizar el total para este producto en la tabla
                    $(this).find('.product-total').text(productTotal.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                });

                // Mostrar los valores en la interfaz
                $('#subtotalDisplay').text(subtotal.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#discountDisplay').text(`₡${totalDiscount.toFixed(2)}`);
                $('#taxDisplay').text(totalTax.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
                $('#totalDisplay').text(totalGeneral.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }


            var CotizacionUrlTemplate = "{{ route('cotizaciones.show', ['id' => ':id']) }}";

            // Evento para cargar datos de cotización en el formulario de edición
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();

                isEditMode = true; // Establecer modo edición
                console.log('Modo: Edición editar', isEditMode);
                $('#addCotizacionModalLabel').text('Editar Cotización'); // Cambiar el título del modal
                $('#btn_text_form').text('Editar Cotización');


                var cotizacionId = $(this).data(
                    'cotizacion-id'); // Obtiene el ID de la cotización desde el atributo data
                var fetchUrl = CotizacionUrlTemplate.replace(':id', cotizacionId);

                // Realizar una solicitud AJAX para obtener los datos de la cotización
                $.ajax({
                    url: fetchUrl, // Ruta para obtener los datos de la cotización
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Cotizacion', response);

                        // Rellenar el formulario con los datos obtenidos
                        $('#num_cotizacion').val(response.numero_cotizacion);
                        $('#selectedClientId').val(response.id_cliente);
                        $('#searchClient').val(response.cliente.name);
                        $('#fecha_creacion').val(response.start_date);
                        $('#fecha_vencimiento').val(response.end_date);
                        $('#observaciones').val(response.terms);
                        $('#cotizacion_id').val(response.id);
                        $('#inlineCheckbox1').prop('checked', response.credito === 1);
                        if (response.credito === 1) {
                            $('#plazoContainer').removeClass('hidden-important').show();
                            $('#plazo').val(response.plazo);
                        } else {
                            $('#plazoContainer').hide();
                            $('#plazo').val('');
                        }


                        // Limpiar la tabla de productos y agregar los productos obtenidos
                        $('#selectedProductsTable tbody').empty();
                        response.productos.forEach(producto => {
                            console.log('Productos', producto);
                            addProductToTable(
                                producto
                            ); // Esta función ya la tienes para agregar productos a la tabla
                        });

                        // Mostrar el modal de edición
                        $('#addCotizacionModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al cargar los datos de la cotización:', error);
                    }
                });
            });

            // Función que abre el modal en modo creación
            $(document).on('click', '#new_cotizacion', function() {
                isEditMode = false; // Establecer modo creación
                console.log('Modo: Creación New', isEditMode);
                $('#addCotizacionModalLabel').text('Nueva Cotización'); // Cambiar el título del modal
                $('#addCotizacionModal').modal('show'); // Abrir el modal con JavaScript
            });









            $('#inlineCheckbox1').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#plazoContainer').removeClass('hidden-important').show(); // Mostrar
                } else {
                    $('#plazoContainer').addClass('hidden-important'); // Ocultar
                    $('#plazo').val(''); // Limpiar el input
                }
            });

            loadTableData('{{ route('cotizaciones.searchCotizacionList') }}');

            // Evento de input para el buscador
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                loadTableData(`{{ route('cotizaciones.searchCotizacionList') }}?query=${query}`);
            });

            // Función para cargar datos paginados
            function loadTableData(url) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let tableBody = $('#cotizacionesTableBody');
                        tableBody.empty();

                        // Cargar las filas de la tabla
                        response.data.forEach(cotizacion => {
                            let formattedTotal = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'CRC', // O la moneda que estés utilizando
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }).format(cotizacion.total);

                            let row = `
                <tr>
                    <td>
                        <p class="text-xs font-weight-bold mb-0">${cotizacion.numero_cotizacion}</p>
                    </td>
                    <td style="text-align: center;">
                        <p class="text-xs font-weight-bold mb-0">${cotizacion.cliente.name}</p>
                    </td>
                    <td style="text-align: center;">
                        <p class="text-xs font-weight-bold mb-0">${cotizacion.start_date}</p>
                    </td>
                    <td style="text-align: center;">
                        <p class="text-xs font-weight-bold mb-0">${formattedTotal}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-${getStatusClass(cotizacion.status)}">${getStatusLabel(cotizacion.status)}</span>
                    </td>
                    <td class="text-center">
                        <a href="#" class="mx-3 edit-btn" data-cotizacion-id="${cotizacion.id}">
                            <i class="fas fa-pen text-secondary"></i>
                        </a>
                        <a href="#" class="mx-3 pdf-btn" title="PDF" data-cotizacion-id="${cotizacion.id}">
                            <i class="fas fa-file-pdf"></i>
                        </a>
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


            // Evento para manejar la paginación
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let url = $(this).data('url');
                if (url) {
                    loadTableData(url);
                }
            });

            $(document).on('click', '.pdf-btn', function(e) {
                e.preventDefault();

                // Obtener el id de cotización desde el atributo data-cotizacion-id
                var cotizacionId = $(this).data('cotizacion-id');

                // Construir la URL usando la función de Laravel
                var pdfUrl = "{{ route('cotizaciones.pdf', ':id') }}".replace(':id', cotizacionId);

                // Redirigir al usuario a la URL generada
                window.location.href = pdfUrl;
            });


            $('#addCotizacionForm').on('submit', function(e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                // Recopilar los datos del formulario
                let formData = {
                    num_cotizacion: $('#num_cotizacion').val(),
                    client_id: $('#selectedClientId').val(),
                    fecha_creacion: $('#fecha_creacion').val(),
                    fecha_vencimiento: $('#fecha_vencimiento').val(),
                    observaciones: $('#observaciones').val(),
                    credito: $('#inlineCheckbox1').is(':checked') ? 1 : 0,
                    plazo: $('#plazo').val(),
                    productos: []
                };

                if (isEditMode) {
                    formData.id = $('#cotizacion_id')
                        .val(); // Usar el input oculto con el ID de la cotización
                }

                $('#selectedProductsTable tbody tr').each(function() {
                    let producto = {
                        barcode: $(this).find('td:nth-child(1)').text(),
                        description: $(this).find('td:nth-child(2)').text(),
                        precio_unitario: parseFloat($(this).find('td:nth-child(3)').data(
                            'value')),
                        quantity: parseInt($(this).find('.product-quantity').val()),
                        discount: parseFloat($(this).find('.product-discount').val()) || 0,
                        taxes: parseFloat($(this).find('td:nth-child(4)').data(
                            'value')),
                        total: parseFloat($(this).find('.product-total').text().replace(/,/g,
                            '')) // Remover cualquier coma en la cantidad
                    };
                    formData.productos.push(producto);
                });

                console.log('Modo: Edición Btn Form', isEditMode);

                $.ajax({
                    url: isEditMode ? `{{ route('cotizaciones.update', ['id' => ':id']) }}`
                        .replace(':id', $('#cotizacion_id').val()) :
                        '{{ route('cotizaciones.store') }}',
                    type: isEditMode ? 'PUT' : 'POST',
                    data: formData, // Enviar los datos como un objeto
                    success: function(response) {

                        let successMessage = isEditMode ? 'Cotización editada con éxito.' :
                            'Cotización creada con éxito.'; // Definir el mensaje según el modo

                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: successMessage,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: true,
                            willClose: () => {
                                loadTableData(
                                    '{{ route('cotizaciones.searchCotizacionList') }}'
                                );
                                $('#addCotizacionModal').modal('hide');
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
        function getStatusClass(status) {
            switch (status) {
                case 'pendiente':
                    return 'warning'; // Cambia el color a tu preferencia
                case 'aceptada':
                    return 'success';
                case 'rechazada':
                    return 'danger';
                case 'expirada':
                    return 'secondary'; // Color para 'expirada'
                default:
                    return 'dark'; // Default en caso de otros valores
            }
        }

        function getStatusLabel(status) {
            switch (status) {
                case 'pendiente':
                    return 'Pendiente';
                case 'aceptada':
                    return 'Aceptada';
                case 'rechazada':
                    return 'Rechazada';
                case 'expirada':
                    return 'Expirada';
                default:
                    return 'Desconocido'; // Para manejar posibles casos inesperados
            }
        }
    </script>
    <script>
        // Obtener la fecha actual
        const today_fecha = new Date();
        // Formatear la fecha en formato YYYY-MM-DD
        const formattedDate = today_fecha.toISOString().split('T')[0];
        // Asignar la fecha al input
        document.getElementById('fecha_creacion').value = formattedDate;
    </script>
@endsection
