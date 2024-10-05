<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturación - SISFACT CR</title>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            max-width: 100%;
            !important;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }



        .scanner-input {
            width: 90%;
            margin-bottom: 20px;
            display: flex;
        }

        #barcode {
            width: 25%;
            height: 40px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 15px;
            font-size: 18px;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #5cb85c;
        }

        .table-container {
            width: 100%;
            max-width: 90%;
            margin-top: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 15px;
            text-align: center;
        }

        table th {
            background-color: #5cb85c;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table td {
            border-bottom: 1px solid #eee;
        }

        .sub-total-price {
            text-align: right;
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .total-price {
            text-align: right;
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .total-price-iva {
            text-align: right;
            margin-top: 20px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 5px;
            justify-content: center;
        }

        .quantity-controls button,
        .quantity-controls input {
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 5px 10px;
            text-align: center;
            width: 35px;
            height: 35px;
            line-height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-controls button:hover {
            background-color: #e6e6e6;
        }

        .quantity-controls input {
            width: 50px;
            /* Ajusta el ancho del input si es necesario */
            padding: 5px;
            text-align: center;
            font-size: 16px;
            /* Ajusta el tamaño de la fuente si es necesario */
        }

        .remove-btn {
            padding: 0 5px;
            color: white !important;
            background-color: #5cb85c;
            /* Un rojo más claro, estilo tomate */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            /* Hacer la 'X' más grande */
            line-height: 20px;
            /* Ajustar la altura de línea si es necesario */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
            /* Ajustar según el diseño */
            width: 35px;
            /* Hacer el botón cuadrado */
        }

        .remove-btn:hover {
            background-color: #d9534f;
            /* Un rojo más oscuro para hover */
        }

        /* Hacer que la tabla tenga un scroll interno */
        .table-container {
            max-height: 50vh;
            /* Altura máxima antes de que aparezca el scroll */
            overflow-y: auto;
            /* Scroll vertical dentro de la tabla */
            margin-bottom: 20px;
            /* Espacio entre la tabla y los totales */
            border: 1px solid #ddd;
            /* Añade un borde para destacar el área de la tabla */
        }

        /* Mantener el ancho completo de la tabla dentro del contenedor */
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Asegurarse de que las celdas de la tabla tengan buen padding y un borde inferior */
        .table-container th,
        .table-container td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        /* Fijar los totales en la parte inferior derecha */
        .totales_facturacion_class {
            position: fixed;
            bottom: 20px;
            background-color: #fff;
            padding: 1%;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* Asegura que siempre esté visible */
            display: flex;
            flex-direction: column;
            align-items: end;
            width: 87%;
            border-radius: 20px;
        }

        .table-container th {
            position: sticky;
            top: 0;
            /* Fondo del encabezado para distinguirlo */
            z-index: 2;
            /* Asegura que esté por encima de las celdas de datos */
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
            /* Sombra para mejor visualización */
        }

        /* Asegurar que las celdas no se desborden */
        .table-container th,
        .table-container td {
            white-space: nowrap;
            /* Evita que el contenido se desborde */
        }

        .btn {
            background-image: linear-gradient(310deg, #627594, #a8b8d8);
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: .5rem;
            color: #fff;
            cursor: pointer;
            display: inline-block;
            font-size: .75rem;
            font-weight: 700;
            line-height: 1.4;
            padding: .75rem 1.5rem;
            text-align: center;
            transition: all .15s ease-in;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            vertical-align: middle;
            background-position-x: 25%;
            background-size: 150%;
            box-shadow: 0 4px 7px -1px rgba(0, 0, 0, .11), 0 2px 4px -1px rgba(0, 0, 0, .07);
            letter-spacing: -.025rem;
            margin-left: 10px;
            height: 40px;
        }

        #select_tipo_doc {
            width: 15%;
            margin-left: 10px;
            height: 40px;
        }

        #additionalInput{
            margin-left: 10px;
            width: 25%; 
            height: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="scanner-input">
            <input type="text" id="barcode" placeholder="Escanea el código de barras..." autofocus>
            <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"
                class="btn bg-gradient-secondary"><i class="fas fa-search"></i> Buscar Producto</button>
            <select class="form-select" name="select_tipo_doc" id="select_tipo_doc"
                title="Definir el tipo de documento" onchange="toggleInputVisibility()">
                <option value=""> --- Seleccione --- </option>
                <option value="01"> Factura electrónica </option>
                <option value="03"> Nota de crédito electrónica </option>
                <option value="04" selected> Tiquete Electrónico </option>
                <option value="08"> Factura electrónica de Compra </option>
            </select>

            <input type="text" class="form-control" id="additionalInput" placeholder="Buscar cliente por nombre o cédula" style="display:none;">
            <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"
                class="btn bg-gradient-secondary" id="btn_buscar_client" style="display:none;" ><i class="fas fa-search"></i> Buscar Cliente</button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#addProductModal"
                class="btn bg-gradient-secondary" style="display:none;" id="btn_add_client"><i class="fas fa-user-plus"></i> Agregar Cliente</button>
        </div>

        <div class="table-container">
            <table id="product-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Descuento (%)</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>IVA</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="product-list">
                    <!-- Productos escaneados aparecerán aquí -->
                </tbody>
            </table>
        </div>
        <div class="totales_facturacion_class">
            <div class="total-price-iva" id="total-price-iva">
                Total IVA: ₡0.00
            </div>
            <div class="sub-total-price" id="sub-total-price">
                Sub Total: ₡0.00
            </div>
            <div class="total-price" id="total-price">
                Total: ₡0.00
            </div>
        </div>
    </div>
    <script>
        function toggleInputVisibility() {
            var select = document.getElementById('select_tipo_doc');
            var input = document.getElementById('additionalInput');
            var addclient = document.getElementById('btn_add_client');
            var searchclient = document.getElementById('btn_buscar_client');
            if (select.value === '01' || select.value === '03' || select.value === '08') {
                input.style.display = 'block'; // Muestra el input
                addclient.style.display = 'block';
                searchclient.style.display = 'block';
            } else {
                input.style.display = 'none'; // Oculta el input
                addclient.style.display = 'none';
                searchclient.style.display = 'none';
            }
        }
        
        // Ejecuta la función al cargar para establecer el estado inicial del input
        window.onload = toggleInputVisibility;
        </script>
    <script>
        let totalPrice = 0;
        let totalIVA = 0;
        let products = {};
        let debounceTimeout;

        window.onload = focusBarcodeInput;

        document.getElementById('barcode').addEventListener('input', function() {
            const barcode = this.value.trim();
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(() => {
                if (barcode.length > 5) {
                    // Simulación de búsqueda de producto (cambiar por tu ruta a la API de búsqueda)
                    fetch(`{{ route('product.search') }}?barcode=${barcode}`)
                        .then(response => response.ok ? response.json() : Promise.reject(
                            'Producto no encontrado'))
                        .then(data => {
                            document.getElementById('barcode').value = '';
                            if (products[data.barcode]) {
                                adjustQuantity(data.barcode, 1);
                            } else {
                                products[data.barcode] = {
                                    name: data.name,
                                    price: parseFloat(data.price), // Precio costo (sin IVA)
                                    price_sell: parseFloat(data
                                        .price_sell), // Precio venta (con IVA)
                                    quantity: 1,
                                    discount: 0, // Descuento inicial 0%
                                    total: parseFloat(data.price_sell),
                                    tax_percentage: parseFloat(data.tax_percentage) // % de IVA
                                };
                                addProductRow(data.barcode);
                            }
                            updateTotalPrice();
                        })
                        .catch(error => {
                            console.error(error);
                            alert(error);
                            focusBarcodeInput();
                        });
                }
            }, 500);
        });

        function addProductRow(barcode) {
            const product = products[barcode];
            const row = document.createElement('tr');
            row.innerHTML = `
        <td>${product.name}</td>
        <td>₡${product.price_sell.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td> <!-- Mostramos el price_sell (ya incluye IVA) con formato -->
        <td>
            <input type="number" style="width: 50% !important; text-align: center; margin: 0 auto;" class="form-control" min="0" max="100" value="0" onchange="updateDiscount('${barcode}', this.value)" />
        </td>
        <td>
            <div class="quantity-controls">
                <button onclick="adjustQuantity('${barcode}', -1)">-</button>
                <input type="text" data-barcode="${barcode}" value="${product.quantity}" min="1" onchange="manualAdjustQuantity('${barcode}', this.value)" disabled>
                <button onclick="adjustQuantity('${barcode}', 1)">+</button>
            </div>
        </td>
        <td id="total-${barcode}">₡${product.total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
        <td id="iva-${barcode}">₡${(product.price * (product.tax_percentage / 100) * product.quantity).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td> <!-- IVA calculado con formato -->
        <td><button onclick="removeProduct('${barcode}')" class="remove-btn"><i class="cursor-pointer fas fa-trash"></i></button></td>
    `;
            document.querySelector('#product-table tbody').appendChild(row);
        }

        function adjustQuantity(barcode, change) {
            const product = products[barcode];
            product.quantity += change;

            // Evitar cantidades menores a 1
            if (product.quantity < 1) product.quantity = 1;

            // Actualizamos el valor del input visualmente
            document.querySelector(`input[data-barcode='${barcode}']`).value = product.quantity;

            recalculateProduct(barcode);
        }

        function manualAdjustQuantity(barcode, quantity) {
            const product = products[barcode];
            product.quantity = parseInt(quantity, 10) || 1; // Asegurar que la cantidad sea al menos 1

            // Actualizamos el valor del input visualmente
            document.querySelector(`input[data-barcode='${barcode}']`).value = product.quantity;

            recalculateProduct(barcode);
        }

        function updateDiscount(barcode, discount) {
            const product = products[barcode];
            product.discount = parseFloat(discount) || 0;
            recalculateProduct(barcode);
        }

        function recalculateProduct(barcode) {
            const product = products[barcode];

            // Calculamos el precio con descuento aplicado si lo hay
            const discountedPriceSell = product.price_sell * (1 - (product.discount / 100));

            // Calculamos el total sin IVA (cantidad * price_sell con descuento)
            let totalWithDiscount = discountedPriceSell * product.quantity;

            // Como price_sell ya incluye el IVA, no lo calculamos nuevamente
            product.total = totalWithDiscount;

            // Actualizamos los valores en la tabla con formato de miles
            document.querySelector(`#total-${barcode}`).textContent =
                `₡${product.total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.querySelector(`#iva-${barcode}`).textContent =
                `₡${(product.price * (product.tax_percentage / 100) * product.quantity).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            updateTotalPrice();
        }

        function updateTotalPrice() {
            let subtotal = 0; // Subtotal antes de aplicar cualquier descuento
            totalPrice = 0; // Precio total (con descuentos aplicados)
            totalIVA = 0; // Total del IVA

            // Iteramos sobre cada producto para calcular los totales
            Object.values(products).forEach(product => {
                // Calculamos el subtotal sin aplicar descuento (solo el price_sell)
                subtotal += parseFloat(product.price_sell) * product.quantity;

                // Aplicamos descuento al total de venta (price_sell) si lo hay
                let discountedPriceSell = product.price_sell * (1 - (product.discount / 100));

                // Calculamos el total con descuento
                let totalWithDiscount = discountedPriceSell * product.quantity;

                // Calculamos el IVA sobre el precio costo
                let productIVA = product.price * (product.tax_percentage / 100) * product.quantity;

                // Sumamos los valores al total
                totalPrice += totalWithDiscount;
                totalIVA += productIVA; // Sumamos el IVA total
            });

            // Aseguramos que el subtotal y totalPrice sean números válidos
            subtotal = isNaN(subtotal) ? 0 : subtotal;
            totalPrice = isNaN(totalPrice) ? 0 : totalPrice;
            totalIVA = isNaN(totalIVA) ? 0 : totalIVA;

            // Actualizamos los valores en la interfaz con formato de miles
            document.getElementById('sub-total-price').textContent =
                `Sub Total: ₡${subtotal.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('total-price-iva').textContent =
                `Total IVA: ₡${totalIVA.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            document.getElementById('total-price').textContent =
                `Total: ₡${totalPrice.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        }

        function removeProduct(barcode) {
            const row = document.querySelector(`input[data-barcode='${barcode}']`).closest('tr');
            row.remove();
            delete products[barcode];
            updateTotalPrice();
        }

        function focusBarcodeInput() {
            document.getElementById('barcode').focus();
        }

        document.body.addEventListener('click', focusBarcodeInput);
    </script>



</body>

</html>
