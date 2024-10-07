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
                    ¿Está seguro de que desea inactivar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmStatusChange">Inactivar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Product -->
    <div class="modal fade" id="EditProductModal" tabindex="-1" aria-labelledby="EditProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditProductModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un producto -->
                    <form id="EditProductForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="product_id_edit" name="product_id_edit">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="editproductBarcode" class="form-label">Código de Barras</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="editproductBarcode" name="editproductBarcode"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="editproductName" class="form-label">Nombre del Producto</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="editproductName" name="editproductName"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label for="editproductDescrip" class="form-label">Descripción del Producto</label>
                                <input type="text" class="form-control" id="editproductDescrip"
                                    name="editproductDescrip">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="editproductPrice" class="form-label">Precio Costo del Producto</label><span
                                    class="span-red"> *</span>
                                <input type="number" step="0.01" class="form-control" id="editproductPrice"
                                    name="editproductPrice" required>
                            </div>
                            <div class="col-md-3">
                                <label for="editproductTaxType" class="form-label">Tipo de Impuesto
                                    <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="13%: Tarifa general. <br> 4%: Servicios médicos privados y algunos otros servicios. <br> 2%: Medicamentos y alimentos básicos. <br> 1%: Algunos insumos de la canasta básica. <br> Exento: Algunos productos o servicios están exentos del IVA (por ejemplo, algunos productos de la canasta básica o servicios de educación)."></i>
                                </label><span class="span-red"> *</span>
                                <select class="form-select" id="editproductTaxType" name="editproductTaxType" required>
                                    <option value="">Seleccione un tipo de impuesto</option>
                                    @foreach ($taxTypes as $taxType)
                                        <option value="{{ $taxType->code }}">{{ $taxType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="editproductIVA" class="form-label">% de IVA</label><span class="span-red">
                                    *</span>
                                <input type="number" class="form-control" id="editproductIVA" name="editproductIVA"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label for="editproductPriceVenta" class="form-label">Precio Venta del Producto</label>
                                <input type="number" step="0.01" class="form-control" id="editproductPriceVenta"
                                    name="editproductPriceVenta" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editproductStock" class="form-label">Cant en Stock</label>
                                <input type="number" class="form-control" id="editproductStock"
                                    name="editproductStock">
                            </div>
                            <div class="col-md-6">
                                <label for="editunidad_medida">Unidad de Medida:</label>
                                <select class="form-select" id="editunidad_medida" name="editunidad_medida">
                                    <option value="">Seleccione una unidad de medida</option>
                                    <option value="Unid">Unid (Unidad)</option>
                                    <option value="kg">kg (Kilogramo)</option>
                                    <option value="g">g (Gramo)</option>
                                    <option value="L">L (Litro)</option>
                                    <option value="ml">ml (Mililitro)</option>
                                    <option value="Al">Al (Actividad)</option>
                                    <option value="Cm">Cm (Centímetro)</option>
                                    <option value="m">m (Metro)</option>
                                    <option value="oz">oz (Onza)</option>
                                    <option value="kgf">kgf (Kilogramo Fuerza)</option>
                                    <option value="lbf">lbf (Libra Fuerza)</option>
                                    <option value="kWh">kWh (Kilovatio Hora)</option>
                                    <option value="h">h (Hora)</option>
                                    <option value="s">s (Segundo)</option>
                                    <option value="min">min (Minuto)</option>
                                    <option value="Pa">Pa (Pascal)</option>
                                    <option value="psi">psi (Libra por Pulgada Cuadrada)</option>
                                    <option value="m2">m² (Metro Cuadrado)</option>
                                    <option value="m3">m³ (Metro Cúbico)</option>
                                    <option value="mm">mm (Milímetro)</option>
                                    <option value="in">in (Pulgada)</option>
                                    <option value="ft">ft (Pie)</option>
                                    <option value="yd">yd (Yarda)</option>
                                </select>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="editproductImage" class="form-label">Imagen del Producto</label>
                            <img id="currentProductImage" src="" alt="Imagen Actual" class="img-responsive"
                                style="max-width: 300px; height: auto;" />
                            <input type="file" class="form-control" id="editproductImage" name="editproductImage">
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



    <!-- Modal Add Product -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un producto -->
                    <form id="addProductForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="productBarcode" class="form-label">Código de Barras</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="productBarcode" name="barcode" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productName" class="form-label">Nombre del Producto</label><span
                                    class="span-red"> *</span>
                                <input type="text" class="form-control" id="productName" name="name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productDescrip" class="form-label">Descripción del Producto</label>
                                <input type="text" class="form-control" id="productDescrip" name="productDescrip">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="productPrice" class="form-label">Precio Costo del Producto</label><span
                                    class="span-red"> *</span>
                                <input type="number" step="0.01" class="form-control" id="productPrice"
                                    name="price" required>
                            </div>
                            <div class="col-md-3">
                                <label for="productTaxType" class="form-label">Tipo de Impuesto
                                    <i class="fas fa-question-circle text-primary" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-html="true"
                                        title="13%: Tarifa general. <br> 4%: Servicios médicos privados y algunos otros servicios. <br> 2%: Medicamentos y alimentos básicos. <br> 1%: Algunos insumos de la canasta básica. <br> Exento: Algunos productos o servicios están exentos del IVA (por ejemplo, algunos productos de la canasta básica o servicios de educación)."></i>
                                </label><span class="span-red"> *</span>
                                <select class="form-select" id="productTaxType" name="tax_type_id" required>
                                    <option value="">Seleccione un tipo de impuesto</option>
                                    @foreach ($taxTypes as $taxType)
                                        <option value="{{ $taxType->code }}">{{ $taxType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="productIVA" class="form-label">% de IVA</label><span class="span-red">
                                    *</span>
                                <input type="number" class="form-control" id="productIVA" name="iva" required>
                            </div>
                            <div class="col-md-3">
                                <label for="productPriceVenta" class="form-label">Precio Venta del Producto</label>
                                <input type="number" step="0.01" class="form-control" id="productPriceVenta"
                                    name="priceVenta" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productStock" class="form-label">Cant en Stock</label>
                                <input type="number" class="form-control" id="productStock" name="stock">
                            </div>
                            <div class="col-md-6">
                                <label for="unidad_medida">Unidad de Medida:</label>
                                <select class="form-select" id="unidad_medida" name="unidad_medida">
                                    <option value="">Seleccione una unidad de medida</option>
                                    <option value="Unid">Unid (Unidad)</option>
                                    <option value="kg">kg (Kilogramo)</option>
                                    <option value="g">g (Gramo)</option>
                                    <option value="L">L (Litro)</option>
                                    <option value="ml">ml (Mililitro)</option>
                                    <option value="Al">Al (Actividad)</option>
                                    <option value="Cm">Cm (Centímetro)</option>
                                    <option value="m">m (Metro)</option>
                                    <option value="oz">oz (Onza)</option>
                                    <option value="kgf">kgf (Kilogramo Fuerza)</option>
                                    <option value="lbf">lbf (Libra Fuerza)</option>
                                    <option value="kWh">kWh (Kilovatio Hora)</option>
                                    <option value="h">h (Hora)</option>
                                    <option value="s">s (Segundo)</option>
                                    <option value="min">min (Minuto)</option>
                                    <option value="Pa">Pa (Pascal)</option>
                                    <option value="psi">psi (Libra por Pulgada Cuadrada)</option>
                                    <option value="m2">m² (Metro Cuadrado)</option>
                                    <option value="m3">m³ (Metro Cúbico)</option>
                                    <option value="mm">mm (Milímetro)</option>
                                    <option value="in">in (Pulgada)</option>
                                    <option value="ft">ft (Pie)</option>
                                    <option value="yd">yd (Yarda)</option>
                                </select>

                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productImage" class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" id="productImage" name="image">
                        </div>

                        <button type="submit" class="btn bg-gradient-success">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                    <div id="responseMessage" class="mt-3"></div>
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
                                <h6 class="mb-0">Productos</h6>
                                <div>
                                    <input type="text" id="searchInput" placeholder="Buscar producto..."
                                        class="form-control"
                                        style="width: 250px; display: inline-block; margin-right: 10px; margin-bottom: 1rem;">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"
                                        class="btn bg-gradient-info" style="margin: 0px; !important" "> <i class="fas fa-plus"></i>  Agregar Producto</button>
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
                                                                                                            Codigo</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Precio Costo</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            % IVA</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Precio Venta</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Stock</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Estado</th>
                                                                                                        <th
                                                                                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                                                            Acción</th>
                                                                                                        <th class="text-secondary opacity-7"></th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody id="productsTableBody">

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
                                                                        var ProductId = $(this).data('product-id');
                                                                        $('#confirmStatusChange').data('product-id', ProductId); // Asignar ID al botón dentro del modal.
                                                                    });

                                                                    $(document).ready(function() {
                                                                        // Define la plantilla de la URL utilizando la función route() de Laravel
                                                                        var clientUrlTemplate = "{{ route('products.show', ['id' => ':id']) }}";

                                                                        // Manejador de evento para clic en el botón de editar
                                                                        $('#productsTableBody').on('click', '.edit-btn', function() {
                                                                            var ProductId = $(this).data(
                                                                                'product-id'); // Obtiene el ID del cliente desde el atributo data
                                                                            var fetchUrl = clientUrlTemplate.replace(':id',
                                                                                ProductId); // Sustituye ':id' con el ID real del cliente

                                                                            // Realiza una solicitud AJAX para obtener los datos del cliente
                                                                            $.ajax({
                                                                                url: fetchUrl,
                                                                                type: 'GET',
                                                                                dataType: 'json',
                                                                                success: function(response) {

                                                                                    console.log(response);

                                                                                    var producto = response.producto;
                                                                                    // Suponiendo que tienes un formulario con campos que coinciden con las propiedades del objeto cliente
                                                                                    $('#product_id_edit').val(producto.id);
                                                                                    $('#editproductBarcode').val(producto.barcode);
                                                                                    $('#editproductName').val(producto.name);
                                                                                    $('#editproductDescrip').val(producto.descripcion);
                                                                                    $('#editproductPrice').val(producto.price);
                                                                                    $('#editproductTaxType').val(producto.tax_type_edit.code);
                                                                                    $('#editproductIVA').val(producto.tax_percentage);
                                                                                    $('#editproductPriceVenta').val(producto.price_sell);
                                                                                    $('#editproductStock').val(producto.stock);
                                                                                    $('#editunidad_medida').val(producto.unidad_medida);
                                                                                    if (producto.image_url) {
                                                                                        var imageUrl = "http://localhost/sist_fact_v1/public/" + producto
                                                                                            .image_url;
                                                                                        $('#currentProductImage').attr('src', imageUrl).attr('alt',
                                                                                            'Imagen Actual de ' + producto.name).show();
                                                                                    } else {
                                                                                        $('#currentProductImage').hide(); // Oculta la imagen si no hay URL
                                                                                    }

                                                                                    $('#status_edit').val(producto.status);

                                                                                    $('#EditProductModal').modal('show');
                                                                                },
                                                                                error: function(xhr, status, error) {
                                                                                    console.error('Error al cargar los datos del cliente:', error);
                                                                                }
                                                                            });
                                                                        });
                                                                    });

                                                                    $(document).ready(function() {
                                                                        // Inicializar la búsqueda y paginación
                                                                        loadTableData('{{ route('products.searchProductList') }}');

                                                                        // Evento de input para el buscador
                                                                        $('#searchInput').on('input', function() {
                                                                            const query = $(this).val();
                                                                            loadTableData(`{{ route('products.searchProductList') }}?query=${query}`);
                                                                        });

                                                                        function loadTableData(url) {
                                                                            $.ajax({
                                                                                url: url,
                                                                                type: 'GET',
                                                                                dataType: 'json',
                                                                                success: function(response) {
                                                                                    let tableBody = $('#productsTableBody');
                                                                                    tableBody.empty();
                                                                                    response.data.forEach(product => {
                                                                                        let imageHtml = product.image_url ?
                                                                                            `<img src="http://localhost/sist_fact_v1/public/${product.image_url}" style="object-fit: contain;" class="avatar avatar-sm me-3" alt="${product.name || 'Product Image'}">` :
                                                                                            '<span class="avatar-sm"><i class="fas fa-box"></i></span>';
                                                                                        let row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        ${imageHtml}
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${product.name}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">${product.barcode}</p>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">₡ ${product.price}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">${product.tax_percentage}%</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">₡ ${product.price_sell}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">${product.stock}</span>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-${product.status === 1 ? 'success' : 'danger'}">${product.status === 1 ? 'Active' : 'Inactive'}</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="mx-3 edit-btn" data-bs-toggle="tooltip" data-bs-original-title="Edit user" data-product-id="${product.id}">
                                    <i class="fas fa-pen text-secondary"></i>
                                </a>
                                <span>
                                    <i class="cursor-pointer fas fa-trash text-secondary" data-bs-toggle="modal" data-bs-target="#confirmStatusChangeModal" data-product-id="${product.id}"></i>
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

                                                                        $('#EditProductForm').submit(function(e) {
                                                                            e.preventDefault(); // Prevent the form from submitting via the browser.

                                                                            var formData = new FormData(this); // Create a FormData object to pass with AJAX.

                                                                            $.ajax({
                                                                                url: '{{ route('products.update') }}', // Adjust this to your route defined in Laravel routes.
                                                                                type: 'POST',
                                                                                data: formData,
                                                                                contentType: false, // Required for 'multipart/form-data' type forms.
                                                                                processData: false, // Required for 'multipart/form-data' type forms.
                                                                                success: function(response) {
                                                                                    $('#responseMessageEdit').html('<div class="alert alert-success">' +
                                                                                        response.message + '</div>');
                                                                                    loadTableData('{{ route('products.searchProductList') }}');
                                                                                    $('#EditProductModal').modal('hide');
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
                                                                            var ProductId = $(this).data('product-id');
                                                                            $.ajax({
                                                                                url: '{{ route('products.changeStatus') }}', // Ajusta esto a tu ruta definida en las rutas de Laravel.
                                                                                type: 'POST',
                                                                                data: {
                                                                                    id: ProductId,
                                                                                    status: 0,
                                                                                    _token: '{{ csrf_token() }}'
                                                                                },
                                                                                success: function(response) {
                                                                                    $('#confirmStatusChangeModal').modal('hide');
                                                                                    loadTableData(
                                                                                        '{{ route('products.searchProductList') }}'
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
                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        const productPrice = document.getElementById('productPrice');
                                                                        const productIVA = document.getElementById('productIVA');
                                                                        const productPriceVenta = document.getElementById('productPriceVenta');

                                                                        function calculateVenta() {
                                                                            const costo = parseFloat(productPrice.value) || 0;
                                                                            let iva = parseFloat(productIVA.value) || 0;
                                                                            iva = iva / 100; // Convertir porcentaje a decimal
                                                                            const venta = costo + (costo * iva);
                                                                            productPriceVenta.value = venta.toFixed(2); // Formatear a dos decimales
                                                                        }

                                                                        // Evento que se dispara cuando cambian los valores de costo o IVA
                                                                        productPrice.addEventListener('input', calculateVenta);
                                                                        productIVA.addEventListener('input', calculateVenta);

                                                                        // Calcular inicialmente por si hay valores predeterminados
                                                                        calculateVenta();
                                                                    });
                                                                </script>
                                                                
                                                                <script>
                                                                    document.addEventListener('DOMContentLoaded', function() {
                                                                        const editproductPrice = document.getElementById('editproductPrice');
                                                                        const editproductIVA = document.getElementById('editproductIVA');
                                                                        const editproductPriceVenta = document.getElementById('editproductPriceVenta');

                                                                        // Función para calcular y actualizar el precio de venta
                                                                        function updatePriceVenta() {
                                                                            const precioBase = parseFloat(editproductPrice.value) || 0;
                                                                            const iva = parseFloat(editproductIVA.value) || 0;
                                                                            const valorIVA = precioBase * (iva / 100); // Calcular el valor del IVA
                                                                            const precioVenta = precioBase + valorIVA; // Sumar el precio base y el valor del IVA

                                                                            editproductPriceVenta.value = precioVenta.toFixed(2); // Establecer el precio de venta calculado
                                                                        }

                                                                        // Event listeners para recalcular cuando los valores cambian
                                                                        editproductPrice.addEventListener('input', updatePriceVenta);
                                                                        editproductIVA.addEventListener('input', updatePriceVenta);

                                                                        // También podrías querer calcularlo inicialmente si los campos tienen valores predeterminados
                                                                        updatePriceVenta();
                                                                    });
                                                                </script>
                                                                    
                                                                    
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        $('#addProductForm').on('submit', function(e) {
                                                                            e.preventDefault(); // Prevenir el envío normal del formulario

                                                                            var formData = new FormData(this);

                                                                            $.ajax({
                                                                                url: '{{ route('products.store') }}', // Cambia esta URL si es necesario
                                                                                type: 'POST',
                                                                                data: formData,
                                                                                processData: false, // No procesar los datos (necesario para FormData)
                                                                                contentType: false, // No establecer ningún tipo de contenido (necesario para FormData)
                                                                                success: function(response) {
                                                                                    // Mostrar mensaje de éxito y limpiar formulario
                                                                                    $('#responseMessage').html(
                                                                                        '<div class="alert alert-success">Producto agregado exitosamente.</div>'
                                                                                    );
                                                                                    $('#addProductForm')[0].reset();
                                                                                    loadTableData('{{ route('products.list') }}', 'productsTableBody');
                                                                                    $('#addProductModal').modal('hide');
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
@endsection
