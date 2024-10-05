<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\FacturarController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AperturaCajaController;
use App\Http\Controllers\RetiroController;
use App\Http\Controllers\CotizacionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {


	/* Facturacion */
	Route::get('/facturacion', [FacturarController::class, 'index'])->name('facturacion.index');
	Route::get('/generar-factura', [FacturarController::class, 'generarFactura'])->name('facturacion.generarFactura');;
	Route::get('/search-product', [ProductController::class, 'search'])->name('product.search');


	/*Productos */
	Route::post('/save-products', [ProductController::class, 'store'])->name('products.store');
	Route::get('/products/list', [ProductController::class, 'list'])->name('products.list');
	Route::get('/products/search', [ProductController::class, 'searchProductList'])->name('products.searchProductList');
	Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
	Route::post('/update-product', [ProductController::class, 'update'])->name('products.update');
	Route::post('/changestatus-product', [ProductController::class, 'changeStatus'])->name('products.changeStatus');


	/*Clientes */
	Route::post('/save-clients', [ClienteController::class, 'store'])->name('clients.store');
	Route::get('/clients/list', [ClienteController::class, 'list'])->name('clients.list');
	Route::get('/clientes/{id}', [ClienteController::class, 'show'])->name('clients.show');
	Route::get('/clients/search', [ClienteController::class, 'searchClientList'])->name('clients.searchClientList');
	Route::post('/update-client', [ClienteController::class, 'update'])->name('clients.update');
	Route::post('/changestatus-client', [ClienteController::class, 'changeStatus'])->name('clients.changeStatus');

	Route::get('/geo/provincias', [ClienteController::class, 'provincias'])->name('clients.provincias');
	Route::get('/geo/cantones', [ClienteController::class, 'cantones'])->name('clients.cantones');
	Route::get('/geo/distritos', [ClienteController::class, 'distritos'])->name('clients.distritos');


	/*Proveedores */
	Route::get('/proveedores/search', [ProveedorController::class, 'searchProveedorList'])->name('proveedor.searchProveedorList');
	Route::get('/proveedores/{id}', [ProveedorController::class, 'show'])->name('proveedor.show');
	Route::post('/update-proveedores', [ProveedorController::class, 'update'])->name('proveedor.update');
	Route::post('/save-proveedores', [ProveedorController::class, 'store'])->name('proveedor.store');
	Route::post('/changestatus-proveedor', [ProveedorController::class, 'changeStatus'])->name('proveedor.changeStatus');


	/* Sucursal */
	Route::post('/save-sucursal', [SucursalController::class, 'storeSucursal'])->name('sucursal.store');
	Route::get('/sucursal/list', [SucursalController::class, 'listSucursal'])->name('sucursal.list');
	Route::get('/sucursal/search', [SucursalController::class, 'searchSucursalListSucursal'])->name('sucursal.searchSucursalList');
	Route::get('/sucursal/searchSucursal', [SucursalController::class, 'searchSucursal'])->name('sucursal.searchSucursal');
	Route::get('/sucursal/{id}', [SucursalController::class, 'showSucursal'])->name('sucursal.show');
	Route::post('/update-sucursal', [SucursalController::class, 'updateSucursal'])->name('sucursal.update');
	Route::post('/changestatus-sucursal', [SucursalController::class, 'changeStatusSucursal'])->name('sucursal.changeStatus');


	/* Caja */
	Route::post('/save-caja', [SucursalController::class, 'storeCaja'])->name('caja.store');
	Route::get('/caja/list', [SucursalController::class, 'listCaja'])->name('caja.list');
	Route::get('/caja/search', [SucursalController::class, 'searchCajaList'])->name('caja.searchCajaList');
	Route::get('/caja/searchCaja', [SucursalController::class, 'searchCaja'])->name('caja.searchCaja');
	Route::get('/caja/{id}', [SucursalController::class, 'showCaja'])->name('caja.show');
	Route::post('/update-caja', [SucursalController::class, 'updateCaja'])->name('caja.update');
	Route::post('/changestatus-caja', [SucursalController::class, 'changeStatusCaja'])->name('caja.changeStatus');

	/* Apertura caja*/ 
	Route::post('/save-apertura', [AperturaCajaController::class, 'storeAperturaCaja'])->name('apertura.store');
	Route::post('/changestatus-aperturacaja', [AperturaCajaController::class, 'changeStatus'])->name('apertura.changeStatus');
	Route::post('/cierre-caja', [AperturaCajaController::class, 'cierre'])->name('apertura.cierre');
	Route::get('/apertura/{id}', [AperturaCajaController::class, 'show'])->name('apertura.show');
	Route::post('/update-apertura', [AperturaCajaController::class, 'update'])->name('apertura.update');
	Route::get('/aperturas/list', [AperturaCajaController::class, 'listAperturas'])->name('apertura.list');
	Route::post('/update-cierre', [AperturaCajaController::class, 'updateCierre'])->name('apertura.updateCierre');


	/* Retiros */
	Route::post('/save-retiro', [RetiroController::class, 'storeRetiro'])->name('retiros.store');
	Route::get('/retiro/search', [RetiroController::class, 'searchRetiroList'])->name('retiros.searchRetiroList');
	Route::get('/retiro/{id}', [RetiroController::class, 'show'])->name('retiros.show');
	Route::post('/update-retiro', [RetiroController::class, 'update'])->name('retiros.update');

	/* Cotizaciones */
	Route::get('/cotizacion-clientes/search', [CotizacionesController::class, 'searchClientes'])->name('cotizaciones.searchClientes');
	Route::get('/cotizacion-productos/search', [CotizacionesController::class, 'searchProductos'])->name('cotizaciones.searchProductos');
	Route::get('/cotizaciones/next-number', [CotizacionesController::class, 'getNextNumber'])->name('cotizaciones.getNextNumber');
	// Ruta para crear una nueva cotización
	Route::post('/cotizaciones/store', [CotizacionesController::class, 'store'])->name('cotizaciones.store');
	// Ruta para actualizar una cotización existente
	Route::put('/cotizaciones/update/{id}', [CotizacionesController::class, 'update'])->name('cotizaciones.update');
	Route::get('/cotizaciones/search', [CotizacionesController::class, 'searchCotizacionList'])->name('cotizaciones.searchCotizacionList');
	Route::get('/cotizaciones/{id}', [CotizacionesController::class, 'show'])->name('cotizaciones.show');
	Route::get('/cotizaciones/pdf/{id}', [CotizacionesController::class, 'generatePDF'])->name('cotizaciones.pdf');




    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('Clientes', function () {
		return view('clients');
	})->name('clients');

	Route::get('Proveedores', function () {
		return view('proveedores');
	})->name('proveedores');


	Route::get('Cotizaciones', function () {
		return view('cotizaciones');
	})->name('cotizaciones');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('Productos', [ProductController::class, 'index'])->name('tables');
	Route::get('Mantenimiento', [SucursalController::class, 'indexSucursal'])->name('mantenimiento');
	Route::get('Cajas', [AperturaCajaController::class, 'indexAperturaCaja'])->name('cajas.index');
	Route::get('Retiros', [RetiroController::class, 'index'])->name('retiros.index');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register_store');
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store'])->name('login_store');
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');