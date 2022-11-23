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
$routes->get('/', 'TrekController::index');
$routes->get('/trekslist', 'TrekController::trekslist');
$routes->get('/trekitinerary', 'TrekController::trekitinerary');
$routes->get('/getfaq/(:any)', 'TrekController::getfaq/$1');
$routes->get('/addTrek', 'TrekController::addTrek');
$routes->get('/gettrek/(:any)', 'TrekController::gettrek/$1');
$routes->get('/gettrekitinerary/(:any)', 'TrekController::gettrekitinerary/$1');
$routes->get('/deletetrekitinerary/(:any)', 'TrekController::deletetrekitinerary/$1');
$routes->get('/deleteTrek/(:any)', 'TrekController::deletetrek/$1');
$routes->post('/edittrek', 'TrekController::edittrek');
$routes->post('/storetrek', 'TrekController::storetrek');
$routes->post('/trekiterinarystore', 'TrekController::trekiterinarystore');
$routes->post('/fileupload', 'TrekController::fileupload');


/*bike*/
$routes->get('/bike', 'BikeController::index');
$routes->get('/biketripslist', 'BikeController::tripslist');
$routes->get('/biketripitinerary', 'BikeController::tripitinerary');

$routes->get('/addBikeTrip', 'BikeController::addBikeTrip');
$routes->get('/getBiketrip/(:any)', 'BikeController::getBikeTrip/$1');
$routes->get('/getBikeTripItinerary/(:any)', 'BikeController::getBikeTripItinerary/$1');
$routes->post('/editBiketrip', 'BikeController::editBikeTrip');
$routes->post('/storeBiketrip', 'BikeController::storeBiketrip');
$routes->post('/biketripiterinarystore', 'BikeController::biketripiterinarystore');
$routes->post('/bikefileupload', 'BikeController::fileupload');


/*LeisurePackage*/
$routes->get('/leisure', 'LeisurePackageController::index');
$routes->get('/leisureslist', 'LeisurePackageController::leisureslist');
$routes->get('/leisureitinerary', 'LeisurePackageController::leisureitinerary');
$routes->get('/addLeisure', 'LeisurePackageController::addLeisure');
$routes->get('/addleisure', 'LeisurePackageController::addLeisure');
$routes->get('/getLeisure/(:any)', 'LeisurePackageController::getleisure/$1');
$routes->get('/getLeisureitinerary/(:any)', 'LeisurePackageController::getleisureitinerary/$1');
$routes->post('/editLeisure', 'LeisurePackageController::editleisure');
$routes->get('/deleteLeisure/(:any)', 'LeisurePackageController::deleteLeisure/$1');
$routes->get('/deleteitineraryLeisure/(:any)', 'LeisurePackageController::deleteitineraryLeisure/$1');
$routes->post('/storeLeisure', 'LeisurePackageController::storeleisure');
$routes->post('/storeleisure', 'LeisurePackageController::storeleisure');
$routes->post('/leisureiterinarystore', 'LeisurePackageController::leisureiterinarystore');

$routes->post('/leisureFileupload', 'LeisurePackageController::fileupload');

/*expedition*/
$routes->get('/expedition', 'ExpeditionController::index');
$routes->get('/expeditionslist', 'ExpeditionController::expeditionslist');
$routes->get('/expeditionitinerary', 'ExpeditionController::expeditionitinerary');
$routes->get('/addexpedition', 'ExpeditionController::addexpedition');
$routes->get('/getexpedition/(:any)', 'ExpeditionController::getexpedition/$1');
$routes->get('/getexpeditionitinerary/(:any)', 'ExpeditionController::getexpeditionitinerary/$1');
$routes->post('/editexpedition', 'ExpeditionController::editexpedition');
$routes->post('/storeexpedition', 'ExpeditionController::storeexpedition');
$routes->post('/expeditioniterinarystore', 'ExpeditionController::expeditioniterinarystore');
$routes->post('/expeditionFileupload', 'ExpeditionController::fileupload');
$routes->get('/deleteexpeditionitinerary/(:any)', 'ExpeditionController::deleteitineraryExpedition/$1');
$routes->get('/deleteexpedition/(:any)', 'ExpeditionController::deleteexpedition/$1');



/*hotel*/
$routes->get('/Hotel', 'HotelController::index');
$routes->get('/Hoteltrekslist', 'HotelController::trekslist');
//$routes->get('/trekitinerary', 'HotelController::trekitinerary');
$routes->get('/HoteladdTrek', 'HotelController::addTrek');
$routes->get('/Hotelgettrek/(:any)', 'HotelController::gettrek/$1');
$routes->get('/Hotelgettrekitinerary/(:any)', 'HotelController::gettrekitinerary/$1');
$routes->post('/Hoteledittrek', 'HotelController::edittrek');
$routes->post('/Hotelstoretrek', 'HotelController::storetrek');
$routes->post('/Hoteltrekiterinarystore', 'HotelController::trekiterinarystore');
$routes->post('/Hotelfileupload', 'HotelController::fileupload');



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
