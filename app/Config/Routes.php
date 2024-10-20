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

    // イベント管理
    $routes->group('event', function ($routes) {
        $routes->get('/', 'EventController::getEventList');
        $routes->get('new', 'EventController::getEventNew');
        $routes->post('create', 'EventController::postEventCreate');
        $routes->get('edit/(:id)', 'EventController::getEventEdit/$1');
        $routes->post('edit/(:id)', 'EventController::postEventEdit/$1');
        $routes->get('delete/(:id)', 'EventController::getEventDelete/$1');
    });
});

// REST API
$routes->group('api', function ($routes) {
    $routes->group('auth', function ($routes) {
        $routes->post('signup', 'AuthController::postSignup');
        $routes->post('login', 'AuthController::postLogin');
        $routes->post('logout', 'AuthController::postLogout');
    });
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::getUserShow');
        $routes->put('/', 'UserController::putUserUpdate');
        $routes->delete('/', 'UserController::deleteUser');
    });
});
