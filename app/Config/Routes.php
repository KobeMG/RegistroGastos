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

//Dashboard, menu principal de gastos.
$routes->get('home', 'Home::index');
//CRUD de gastos
$routes->post('gastos/guardar', 'Home::guardarGasto');
$routes->get('gastos/editar/(:num)', 'Home::editarGasto/$1');
$routes->post('gastos/actualizar/(:num)', 'Home::actualizarGasto/$1');
$routes->post('gastos/eliminar/(:num)', 'Home::eliminarGasto/$1');

//Registro de usuarios
$routes->get('registro', 'Auth::registro');
$routes->get('registrar', 'Auth::registro');
$routes->post('/registrar', 'Auth::intentarRegistrar');

//Perfil de usuario
$routes->get('perfil', 'Perfil::index');
$routes->post('perfil/actualizar', 'Perfil::actualizar');

//Gestión de ingresos
$routes->get('perfil/nuevo-ingreso', 'Perfil::nuevoIngreso');
$routes->post('perfil/guardar-ingreso', 'Perfil::guardarIngreso');
$routes->get('perfil/editar-ingreso/(:num)', 'Perfil::editarIngreso/$1');
$routes->post('perfil/actualizar-ingreso/(:num)', 'Perfil::actualizarIngreso/$1');
$routes->post('perfil/eliminar-ingreso/(:num)', 'Perfil::eliminarIngreso/$1');

//Dashboard Financiero
$routes->get('dashboard-financiero', 'DashboardFinanciero::index');

