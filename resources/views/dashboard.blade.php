@extends('layouts.user_type.auth')

@section('content')
 
  <div class="grid-container">
    <!-- Cuadro 1 -->
    <a href="{{ route('facturacion.index') }}" class="card" style="background-image: url('{{ asset('assets/img/facturar.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Facturar</h5>
      </div>
    </a>
  
    <!-- Cuadro 2 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/caja.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Caja</h5>
      </div>
    </a>
  
    <!-- Cuadro 3 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/proveedores.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Proveedores</h5>
      </div>
    </a>
  
    <!-- Cuadro 4 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/clientes.webp') }}');">
      <div class="card-content" >
        <h5 class="text_module">Clientes</h5>
      </div>
    </a>
  
    <!-- Cuadro 5 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/productos.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Productos</h5>
      </div>
    </a>
  
    <!-- Cuadro 6 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/inventario.webp') }}');" >
      <div class="card-content">
        <h5 class="text_module">Inventario</h5>
      </div>
    </a>
  
    <!-- Cuadro 7 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/compras.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Compras</h5>
      </div>
    </a>
  
    <!-- Cuadro 8 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/salida.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Salidas</h5>
      </div>
    </a>
  
    <!-- Cuadro 9 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/cxp.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Cuentas por pagar</h5>
      </div>
    </a>
  
    <!-- Cuadro 10 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/cxc.webp') }}');">
      <div class="card-content">
        <h5 class="text_module">Cuentas por cobrar</h5>
      </div>
    </a>
  
    <!-- Cuadro 11 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Gastos</h5>
      </div>
    </a>
  
    <!-- Cuadro 12 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Devoluciones</h5>
      </div>
    </a>
  
    <!-- Cuadro 13 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Administración</h5>
      </div>
    </a>
  
    <!-- Cuadro 14 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Reportes</h5>
      </div>
    </a>
  
    <!-- Cuadro 15 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Listado de facturas</h5>
      </div>
    </a>
  
    <!-- Cuadro 16 -->
    <a class="card" style="background-image: url('{{ asset('assets/img/ivancik.jpg') }}');">
      <div class="card-content">
        <h5 class="text_module">Cuadro 16</h5>
      </div>
    </a>
  </div>

@endsection
@push('dashboard')
  <script>
   
  </script>
@endpush

