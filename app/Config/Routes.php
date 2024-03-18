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


//ACCOUNT
$routes->get('/account', 'AccountController::index', ['filter' => 'authFilter']);

//ACCOUNT
$routes->group('account', ['filter' => 'authFilter'], function($routes) {
    //DASHBOARD
    $routes->get('dashboard', 'DashboardController::index');

    //CONTACTS
    $routes->get('contacts', 'ContactsController::index');

    //SETTINGS
    $routes->get('settings', 'SettingsController::index');
    $routes->get('settings/update-details', 'SettingsController::updateDetails');
    $routes->get('settings/change-password', 'SettingsController::changePassword');

    //ADMIN
    $routes->get('admin', 'AdminController::index');
    $routes->get('admin/users', 'AdminController::users');
    $routes->get('admin/activity-logs', 'AdminController::activityLogs');
});

//SEARCH
$routes->group('search', function($routes) {
    $routes->get('/', 'SearchController::searchResults');
    $routes->get('modules', 'SearchController::searchModulesResult', ['filter' => 'authFilter']);
});

//HTMX
$routes->group('htmx', function($routes) {
    $routes->post('check-user-email-exists', 'HtmxController::userEmailExists');
    $routes->post('check-user-username-exists', 'HtmxController::userUsernameExists');
    $routes->post('check-password-is-valid', 'HtmxController::checkPasswordIsValid');
    $routes->post('check-passwords-match', 'HtmxController::checkPasswordsMatch');
    $routes->post('search-back-end-features', 'HtmxController::backendSearchResults');
});

//TEST
$routes->get('/test', 'TestController::index');