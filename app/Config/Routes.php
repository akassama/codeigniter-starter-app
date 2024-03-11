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
$routes->group('sign-in', function($routes) {
    $routes->add('/', 'SignInController::index');
});


//SIGN-UP
$routes->group('sign-up', function($routes) {
    $routes->add('/', 'SignUpController::index');
});