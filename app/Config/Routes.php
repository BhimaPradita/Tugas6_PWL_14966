<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'redirect']);

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');



$routes->group('', ['filter' => 'auth'], function($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('produk', 'ProdukController::create', ['filter' => 'auth']);
    $routes->post('produk/edit/(:any)', 'ProdukController::edit/$1', ['filter' => 'auth']);
    $routes->get('produk/delete/(:any)', 'ProdukController::delete/$1', ['filter' => 'auth']);
    $routes->get('produk/download', 'ProdukController::download');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->get('produk', 'ProdukController::index', ['filter' => 'auth']);
$routes->get('keranjang', 'TransaksiController::index', ['filter' => 'auth']);
$routes->get('contact', 'Home::contact', ['filter' => 'auth']);

$routes->get('profile', 'ProfileController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);



$routes->get('/diskon', 'DiskonController::index');
$routes->post('/diskon/simpan', 'DiskonController::simpan');
$routes->post('/diskon/update/(:num)', 'DiskonController::update/$1');
$routes->get('/diskon/delete/(:num)', 'DiskonController::delete/$1');

$routes->post('keranjang/add', 'TransaksiController::cart_add');
