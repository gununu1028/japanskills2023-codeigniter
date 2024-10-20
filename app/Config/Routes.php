<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {
    $routes->get('/', 'AdminController::getLogin');
    $routes->get('login', 'AdminController::getLogin');
    $routes->post('login', 'AdminController::postLogin');
    $routes->get('logout', 'AdminController::getLogout');
    $routes->get('dashboard', 'AdminController::getDashboard');

    // ここから追加
    $routes->group('event', function ($routes) {
        $routes->get('/', 'EventController::getEventList');
        $routes->get('new', 'EventController::getEventNew');
        $routes->post('create', 'EventController::postEventCreate');
        $routes->get('edit/(:id)', 'EventController::getEventEdit/$1');
        $routes->post('edit/(:id)', 'EventController::postEventEdit/$1');
        $routes->get('delete/(:id)', 'EventController::getEventDelete/$1');
    });
    // ここまで追加
});
