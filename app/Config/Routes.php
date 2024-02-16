<?php
$routes->setAutoRoute(true);
use CodeIgniter\Router\RouteCollection;
use App\Controllers\UserController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//$routes->resource('user');
