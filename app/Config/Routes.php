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

    $routes->group('event', function ($routes) {
        $routes->get('/', 'EventController::getEventList');
        $routes->get('new', 'EventController::getEventNew');
        $routes->post('create', 'EventController::postEventCreate');
        $routes->get('(:num)/edit', 'EventController::getEventEdit/$1');
        $routes->post('(:num)/update', 'EventController::postEventUpdate/$1');
        $routes->get('(:num)/delete', 'EventController::getEventDelete/$1');
    });
});

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
