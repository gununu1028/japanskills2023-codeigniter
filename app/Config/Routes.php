<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// 管理画面
$routes->group('admin', function ($routes) {
    $routes->get('/', 'AdminController::getLogin');
    $routes->get('login', 'AdminController::getLogin');
    $routes->post('login', 'AdminController::postLogin');
    $routes->get('logout', 'AdminController::getLogout');
    $routes->get('dashboard', 'AdminController::getDashboard');
});
