<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */
$routes->get('/', 'SigninController::index');
$routes->get('/trekslist', 'AdminController::trekslist');
$routes->get('/trekitinerary', 'AdminController::trekitinerary');
$routes->get('/getfaq/(:any)', 'AdminController::getfaq/$1');
$routes->get('/addTrek', 'AdminController::addTrek');
$routes->get('/gettrek/(:any)', 'AdminController::gettrek/$1');
$routes->get('/gettrekitinerary/(:any)', 'AdminController::gettrekitinerary/$1');
$routes->post('/edittrek', 'AdminController::edittrek');
$routes->post('/storetrek', 'AdminController::storetrek');
$routes->post('/trekiterinarystore', 'AdminController::trekiterinarystore');
$routes->post('/fileupload', 'AdminController::fileupload');


$routes->get('/signup', 'SignupController::index');
$routes->match(['get', 'post'], 'SignupController/store', 'SignupController::store');
$routes->match(['get', 'post'], 'SigninController/loginAuth', 'SigninController::loginAuth');
$routes->get('/signin', 'SigninController::index');
$routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);
$routes->get('logout', 'SigninController::logout');
$routes->get('feedbackform/(:any)', 'feedbackController::userfeedbackform/$1');
$routes->get('addqfeedback', 'feedbackController::addquestionstofeedbackform');
$routes->post('submitquestion', 'feedbackController::qstore');
$routes->get('showfeedbackform/(:any)', 'feedbackController::showquestionstofeedbackform/$1');
$routes->post('savefeedback', 'feedbackController::saveuserfeedback');
$routes->post('feebackreport', 'feedbackController::feebackreport');



$routes->get('/adduser', 'ProfileController::adduser');
$routes->get('/getuser/(:any)', 'ProfileController::getuser/$1');//for edit user
$routes->get('/changepassword/(:any)', 'ProfileController::changepassword/$1');
$routes->get('/getusers', 'ProfileController::getusers');
$routes->post('storeuser', 'ProfileController::storeuser');
$routes->post('changepwd', 'ProfileController::changepwd');
$routes->post('edituserstore', 'ProfileController::edituserstore');


$routes->get('/addrole', 'RoleController::addrole');
$routes->post('storerole', 'RoleController::storerole');
$routes->get('/getrole/(:any)', 'RoleController::getrole/$1');
$routes->post('editrolestore', 'RoleController::editrolestore');
$routes->get('/getroles', 'RoleController::index');
$routes->get('/roleprivilies/(:any)', 'RoleController::roleprivilies/$1');
$routes->post('/rolepriviliesstore', 'RoleController::rolepriviliesstore');





/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
