<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ // Logica es CONTROLLER::METODO
$routes->get('/', 'Auth::index');
$routes->post('gastos/guardar', 'Home::guardarGasto');

// Rutas de Autenticación - Tema login
$routes->get('login', 'Auth::login');
$routes->post('auth/login', 'Auth::intentarLogin');

$routes->get('registro', 'Auth::registro');
$routes->post('auth/registrar', 'Auth::intentarRegistrar');

$routes->get('logout', 'Auth::logout');