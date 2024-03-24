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
    $routes->get('contacts/new-contact', 'ContactsController::newContact');
    $routes->post('contacts/new-contact', 'ContactsController::addContact');
    $routes->get('contacts/view-contact/(:any)', 'ContactsController::viewContact/$1');
    $routes->get('contacts/edit-contact/(:any)', 'ContactsController::editContact/$1');
    $routes->post('contacts/edit-contact', 'ContactsController::updateContact');

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

//HTMX REQUESTS
$routes->group('htmx', function($routes) {
    //USER REGISTRATIONS REQUESTS
    $routes->post('check-user-email-exists', 'HtmxController::userEmailExists');
    $routes->post('check-user-username-exists', 'HtmxController::userUsernameExists');
    $routes->post('check-password-is-valid', 'HtmxController::checkPasswordIsValid');
    $routes->post('check-passwords-match', 'HtmxController::checkPasswordsMatch');
    $routes->post('search-back-end-features', 'HtmxController::backendSearchResults');

    //CONTACT REQUESTS
    $routes->post('check-contact-number-exists', 'HtmxController::contactNumberExists');
    $routes->post('check-edit-contact-number-exists', 'HtmxController::editContactNumberExists');
});

//SERVICES
$routes->group('services', function($routes) {
    $routes->post('remove-record', 'ServicesController::deleteService', ['filter' => 'authFilter']);
});

//TEST
$routes->get('/test', 'TestController::index');