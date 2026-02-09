<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ // Logica es CONTROLLER::METODO

//LOGICA DEL LOGIN
$routes->get('/', 'Auth::index'); //Por defecto va a la pagina de login
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::intentarLogin');
$routes->get('logout', 'Auth::logout');

//Gastos - CRUD completo
$routes->get('gastos', 'Gastos::index');
$routes->post('gastos/guardar', 'Gastos::guardar');
$routes->post('gastos/actualizar/(:num)', 'Gastos::actualizar/$1');
$routes->post('gastos/eliminar/(:num)', 'Gastos::eliminar/$1');

//Registro de usuarios
$routes->get('registro', 'Auth::registro');
$routes->get('registrar', 'Auth::registro');
$routes->post('/registrar', 'Auth::intentarRegistrar');

//Perfil de usuario
$routes->get('perfil', 'Perfil::index');
$routes->post('perfil/actualizar', 'Perfil::actualizar');
$routes->post('perfil/generar-token', 'Perfil::generarToken');
$routes->post('perfil/revocar-token', 'Perfil::revocarToken');

//Gestión de ingresos
$routes->get('perfil/nuevo-ingreso', 'Perfil::nuevoIngreso');
$routes->post('perfil/guardar-ingreso', 'Perfil::guardarIngreso');
$routes->get('perfil/editar-ingreso/(:num)', 'Perfil::editarIngreso/$1');
$routes->post('perfil/actualizar-ingreso/(:num)', 'Perfil::actualizarIngreso/$1');
$routes->post('perfil/eliminar-ingreso/(:num)', 'Perfil::eliminarIngreso/$1');

//Dashboard Financiero
$routes->get('dashboard-financiero', 'DashboardFinanciero::index');

//Cierres de mes
$routes->get('cierres', 'Cierres::index');
$routes->get('cierres/ver/(:num)', 'Cierres::ver/$1');

// API Routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Gastos
    $routes->post('gastos/registrar', 'Gastos::registrar');
});
