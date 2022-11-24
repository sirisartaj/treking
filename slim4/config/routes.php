<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/', \App\Action\HomeAction::class);
 
  //Treks
  $app->get('/treks/gettreks',\App\Action\Treks\GetTreks::class);
  $app->get('/treks/gettrek/{trekId}', \App\Action\Treks\GetTrek::class);
  $app->post('/treks/addtrek',\App\Action\Treks\AddTrek::class);
  $app->post('/treks/updatetrek',\App\Action\Treks\UpdateTrek::class);

  $app->post('/treks/edittrekiterinarydata',\App\Action\Treks\EditTrekIterinary::class);
  $app->post('/treks/addtrekiterinarydata',\App\Action\Treks\AddTrekIterinary::class);
  $app->get('/treks/get_itinerary_Trek/{trekId}', \App\Action\Treks\GetItineraryTrek::class);
  $app->post('/treks/delete_itinerary_Trek', \App\Action\Treks\DeleteItineraryTrek::class);


  $app->post('/treks/deletetrek/{trekId}',\App\Action\Treks\DeleteTrek::class);
  $app->post('/treks/updatetrekstatus', \App\Action\Treks\UpdateTrekStatus::class);

  
  //Bike Trips
  $app->get('/biketrips/getbiketrips',\App\Action\BikeTrips\GetBikeTrips::class);
  $app->post('/biketrips/addbiketrip', \App\Action\BikeTrips\AddBikeTrip::class);
  $app->get('/biketrips/getbiketrip/{tripId}', \App\Action\BikeTrips\GetBikeTrip::class);
  $app->post('/biketrips/updatebiketrip',\App\Action\BikeTrips\UpdateBikeTrip::class);
  $app->delete('/biketrips/deletebiketrip/{tripId}',\App\Action\BikeTrips\DeleteBikeTrip::class);
  $app->post('/biketrips/updatebiketripstatus',\App\Action\BikeTrips\UpdateBikeTripStatus::class);
  $app->get('/biketrips/get_itinerary_Trip/{tripId}', \App\Action\BikeTrips\GetBikeItineraryTrip::class);
  $app->post('/biketrips/addbiketripiterinary',\App\Action\BikeTrips\AddBikeTripIterinary::class);
  $app->post('/biketrips/editbiketripiterinary',\App\Action\BikeTrips\EditBikeTripIterinary::class);
  $app->post('/biketrips/deleteiterinary/{id}',\App\Action\BikeTrips\DeleteIterinary::class);


  //Expeditions
  $app->get('/expeditions/getexpeditions', \App\Action\Expeditions\GetExpeditions::class);
  $app->post('/expeditions/addexpeditions', \App\Action\Expeditions\AddExpedition::class);
  $app->get('/expeditions/getexpedition/{expedition_id}', \App\Action\Expeditions\GetExpedition::class);
  $app->get('/expeditions/get_itinerary_expedition/{expedition_id}', \App\Action\Expeditions\GetItineraryExpedition::class);
  $app->post('/expeditions/updateexpedition', \App\Action\Expeditions\UpdateExpedition::class);
  $app->post('/expeditions/updateexpeditionsstatus', \App\Action\Expeditions\DeleteExpedition::class);
			  
    $app->post('/expeditions/additerinary/{id}',\App\Action\Expeditions\AddIterinary::class);
  $app->post('/expeditions/editexpeditioniterinarydata',\App\Action\Expeditions\UpdateIterinary::class);
  $app->post('/expeditions/deleteiterinary',\App\Action\Expeditions\DeleteIterinary::class);


    // LeisurePackeges
  $app->get('/leisurepackages/getleisures', \App\Action\LeisurePackages\GetLeisurePackages::class);
  $app->post('/leisurepackages/addleisure', \App\Action\LeisurePackages\AddLeisurePackage::class);
  $app->get('/leisurepackages/editleisurepackages/{lepkg_id}', \App\Action\LeisurePackages\GetLeisurePackage::class);
  
  $app->post('/leisurepackages/updateleisure', \App\Action\LeisurePackages\UpdateLeisurePackage::class);
  $app->post('/leisurepackages/updateleisurepackagestatus', \App\Action\LeisurePackages\UpdateLeisurePackageStatus::class);

  $app->get('/leisurepackages/get_itinerary_leisure/{lepkg}', \App\Action\LeisurePackages\GetItineraryLeisure::class);
  $app->post('/leisurepackages/addleisureiterinary',\App\Action\LeisurePackages\AddLeisureIterinary::class);
  $app->post('/leisurepackages/editleisureiterinary',\App\Action\LeisurePackages\UpdateLeisurePackageitiStatus::class);
  $app->post('/leisurepackages/deleteiterinary',\App\Action\LeisurePackages\UpdateLeisurePackageitiStatus::class);
  
  
  
  $app->get('/hostel/gethostels', \App\Action\Hostels\Gethostels::class);
  $app->post('/hostel/addhostel', \App\Action\Hostels\Addhostel::class);
  $app->get('/hostel/edithostel/{lepkg_id}', \App\Action\Hostels\Gethostel::class);
  
  $app->post('/hostel/updatehostel', \App\Action\Hostels\Updatehostel::class);
  $app->post('/hostel/updatehostelstatus', \App\Action\Hostels\UpdatehostelStatus::class);
  

};