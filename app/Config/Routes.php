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

//FORGOT-PASSWORD
$routes->group('forgot-password', ['filter' => 'guestFilter'], function($routes) {
    $routes->get('/', 'ForgotPasswordController::index');
    $routes->post('/', 'ForgotPasswordController::sendResetLinkEmail');
});

//PASSWORD-RESET
$routes->group('password-reset', ['filter' => 'guestFilter'], function($routes) {
    $routes->get('(:segment)', 'PasswordResetController::index/$1');
    $routes->post('/', 'PasswordResetController::resetPassword');
});

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
    $routes->post('settings/update-details/update-user', 'SettingsController::updateUser');
    $routes->get('settings/change-password', 'SettingsController::changePassword');
    $routes->post('settings/change-password/update-password', 'SettingsController::updatePassword');

    //FILE MANAGER
    $routes->get('file-manager', 'FileManagerController::index');
    $routes->get('file-manager/upload', 'FileManagerController::newUpload');
    $routes->post('file-manager/upload', 'FileManagerController::uploadFile');

    //ADMIN
    $routes->get('admin', 'AdminController::index', ['filter' => 'adminRoleFilter']);
    $routes->get('admin/users', 'AdminController::users', ['filter' => 'adminRoleFilter']);
    $routes->get('admin/users/new-user', 'AdminController::newUser', ['filter' => 'adminRoleFilter']);
    $routes->post('admin/users/new-user', 'AdminController::addUser');
    $routes->get('admin/users/edit-user/(:any)', 'AdminController::editUser/$1', ['filter' => 'adminRoleFilter']);
    $routes->post('admin/users/edit-user', 'AdminController::updateUser');
    $routes->get('admin/activity-logs', 'AdminController::activityLogs', ['filter' => 'adminRoleFilter']);
    $routes->get('admin/activity-logs/view-activity/(:any)', 'AdminController::viewActivity/$1');
    $routes->get('admin/configurations', 'AdminController::configurations', ['filter' => 'adminRoleFilter']);
    $routes->get('admin/configurations/new-config', 'AdminController::newConfiguration', ['filter' => 'adminRoleFilter']);
    $routes->post('admin/configurations/new-config', 'AdminController::addConfiguration');
    $routes->get('admin/configurations/edit-config/(:any)', 'AdminController::editConfiguration/$1', ['filter' => 'adminRoleFilter']);
    $routes->post('admin/configurations/edit-config', 'AdminController::updateConfiguration');

    //ACCESS DENIED
    $routes->get('access-denied', 'AccessController::index');
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
    $routes->post('check-config-exists', 'HtmxController::configForExists');

    //CONTACT REQUESTS
    $routes->post('check-contact-number-exists', 'HtmxController::contactNumberExists');
    $routes->post('check-edit-contact-number-exists', 'HtmxController::editContactNumberExists');
});

//SERVICES
$routes->group('services', function($routes) {
    $routes->post('remove-record', 'ServicesController::deleteService', ['filter' => 'authFilter']);
    $routes->post('remove-file', 'ServicesController::deleteFileService', ['filter' => 'authFilter']);
});

//TEST
$routes->get('/test', 'TestController::index');
$routes->post('test/upload', 'TestController::uploadFile');
$routes->get('/test/send-email', 'TestController::sendWelcomeEmail');
$routes->get('/test/send-email-text', 'TestController::sendWelcomeEmailPlain');