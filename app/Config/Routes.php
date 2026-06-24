<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('', ['filter' => 'group:admin,superadmin'], static function ($routes) {
    $routes->get('/', 'Home::index');

    $routes->get('/customers', 'Resource\CustomerController::index');
    $routes->get('/customers/create', 'Resource\CustomerController::create');
    $routes->post('/customers', 'Resource\CustomerController::store');
    $routes->get('/customers/(:num)/edit', 'Resource\CustomerController::edit/$1');
    $routes->put('/customers/(:num)', 'Resource\CustomerController::update/$1');
    $routes->delete('/customers/(:num)', 'Resource\CustomerController::delete/$1');


    $routes->get('/products', 'Resource\ProductController::index');
    $routes->get('/products/create', 'Resource\ProductController::create');
    $routes->post('/products', 'Resource\ProductController::store');
    $routes->get('/products/(:num)/edit', 'Resource\ProductController::edit/$1');
    $routes->put('/products/(:num)', 'Resource\ProductController::update/$1');
    $routes->delete('/products/(:num)', 'Resource\ProductController::delete/$1');


    $routes->get('/transactions', 'Resource\TransactionController::index');
    $routes->get('/transactions/create', 'Resource\TransactionController::create');
    $routes->post('/transactions', 'Resource\TransactionController::store');
    $routes->get('/transactions/(:num)', 'Resource\TransactionController::show/$1');
    $routes->get('/transactions/(:num)/edit', 'Resource\TransactionController::edit/$1');
    $routes->put('/transactions/(:num)', 'Resource\TransactionController::update/$1');
    $routes->get('/transactions/(:num)/download', 'Resource\TransactionController::download/$1');
    $routes->delete('/transactions/(:num)', 'Resource\TransactionController::delete/$1');
});


service('auth')->routes($routes);
