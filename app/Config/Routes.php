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

$routes->get('member/index','MemberController::Index');
$routes->post('member/getbycode','MemberController::Getbycode');
$routes->post('member/updatemember','MemberController::Updatemember');

$routes->get('uom/index','UomController::Index');
$routes->post('uom/getuom','UomController::Getuom');

$routes->get('category/index','CategoryController::Index');
$routes->post('category/create','CategoryController::Create');
$routes->post('category/categorychange','CategoryController::Categorychange');


$routes->get('price/index','PriceController::Index');
$routes->post('price/create','PriceController::Create');

$routes->get('transaksi/getprice','TransaksiController::Getcategoryprice');
$routes->post('transaksi/timbang','TransaksiController::Create_timbang');
$routes->post('transaksi/timbang_del','TransaksiController::Delete_timbang');
//$routes->resource('UserController');
