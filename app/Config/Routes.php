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
