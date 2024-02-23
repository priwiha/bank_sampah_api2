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

$routes->get('uom/index','UomController::Index');
$routes->post('uom/getuom','UomController::Getuom');

$routes->get('category/index','CategoryController::Index');
$routes->post('category/create','CategoryController::Create');
$routes->post('category/categorychange','CategoryController::Categorychange');


$routes->get('price/index','PriceController::Index');
$routes->post('price/create','PriceController::Create');
//$routes->resource('UserController');
