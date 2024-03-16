<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');

//HOME
$routes->group('home', function($routes) {
    $routes->get('/', 'HomeController::index');
});

//ABOUT
$routes->get('/about', 'AboutController::index');

//SIGN-IN
$routes->group('sign-in', ['filter' => 'guestFilter'], function($routes) {
    $routes->get('/', 'SignInController::index');
    $routes->post('/', 'SignInController::login');
});

//SIGN-UP
$routes->group('sign-up', function($routes) {
    $routes->get('/', 'SignUpController::index');
    $routes->post('/', 'SignUpController::addRegistration');
});

//SIGN-OUT
$routes->get('/sign-out', 'SignOutController::index');

//ACCOUNT - DASHBOARD
$routes->group('account', ['filter' => 'authFilter'], function($routes) {
    $routes->get('dashboard', 'DashboardController::index');
});

//HTMX
$routes->group('htmx', function($routes) {
    $routes->post('check-user-email-exists', 'HtmxController::userEmailExists');
    $routes->post('check-user-username-exists', 'HtmxController::userUsernameExists');
    $routes->post('check-password-is-valid', 'HtmxController::checkPasswordIsValid');
    $routes->post('check-passwords-match', 'HtmxController::checkPasswordsMatch');
});