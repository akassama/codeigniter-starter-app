<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

//HOME
$routes->group('home', function($routes) {
    $routes->add('/', 'HomeController::index');
});

//ABOUT
$routes->get('/about', 'AboutController::index');

//SIGN-IN
$routes->group('sign-in', ['filter' => 'guestFilter'], function($routes) {
    $routes->add('/', 'SignInController::index');
    $routes->post('/', 'SignInController::login');
});

//SIGN-UP
$routes->group('sign-up', function($routes) {
    $routes->add('/', 'SignUpController::index');
    $routes->post('/', 'SignUpController::addRegistration');
});

//SIGN-OUT
$routes->get('/sign-out', 'SignOutController::index');

//ACCOUNT - DASHBOARD
$routes->group('account', ['filter' => 'authFilter'], function($routes) {
    $routes->add('dashboard', 'DashboardController::index');
});