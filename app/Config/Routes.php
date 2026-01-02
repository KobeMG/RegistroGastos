<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ // Logica es CONTROLLER::METODO

//LOGICA DEL LOGIN
$routes->get('/', 'Auth::index'); //Por defecto va a la pagina de login
$routes->post('login', 'Auth::intentarLogin');
$routes->get('registro', 'Auth::registro');
$routes->get('home', 'Home::index');
$routes->post('gastos/guardar', 'Home::guardarGasto');



$routes->post('/registrar', 'Auth::intentarRegistrar');

$routes->get('logout', 'Auth::logout');