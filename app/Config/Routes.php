<?php
$routes->setAutoRoute(true);
//use CodeIgniter\Router\RouteCollection;


/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('user/index','UserController::Index');
$routes->post('user/create','UserController::Create');
$routes->post('user/login','UserController::Login');
//$routes->resource('UserController');
