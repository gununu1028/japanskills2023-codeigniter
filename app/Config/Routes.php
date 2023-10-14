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
    $routes->get('dashboard', 'AdminController::getDashboard');
    $routes->group('user', function ($routes) {
        $routes->get('/', 'AdminController::getUserList');
        $routes->get('new', 'AdminController::getUserNew');
        $routes->post('create', 'AdminController::postUserCreate');
        $routes->get('(:num)', 'AdminController::getUserShow/$1');
        $routes->get('(:num)/edit', 'AdminController::getUserEdit/$1');
        $routes->put('(:num)', 'AdminController::putUserUpdate/$1');
        $routes->patch('(:num)/active_status', 'AdminController::patchUserActiveStatus/$1');
        $routes->delete('(:num)', 'AdminController::deleteUser/$1');
    });
});
