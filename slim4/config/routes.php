<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  $app->get('/', \App\Action\HomeAction::class);
 
  //Treks
  $app->get('/treks/gettreks',\App\Action\Treks\GetTreks::class);
  $app->post('/treks/addtrek',\App\Action\Treks\AddTrek::class);
  $app->post('/treks/edittrekiterinarydata',\App\Action\Treks\EditTrekIterinary::class);
  $app->post('/treks/addtrekiterinarydata',\App\Action\Treks\AddTrekIterinary::class);
  $app->post('/treks/updatetrek',\App\Action\Treks\UpdateTrek::class);
  $app->get('/treks/gettrek/{trekId}', \App\Action\Treks\GetTrek::class);
  $app->get('/treks/get_itinerary_Trek/{trekId}', \App\Action\Treks\GetItineraryTrek::class);

  $app->delete('/treks/deletetrek/{trekId}',\App\Action\Treks\DeleteTrek::class);
  $app->post('/treks/updatetrekstatus', \App\Action\Treks\UpdateTrekStatus::class);

  // Trek batches
  $app->get('/treks/getbatches/{trek_id}', \App\Action\Treks\GetBatches::class);
  $app->post('/treks/addbatch',\App\Action\Treks\AddBatch::class);
  $app->get('/treks/getbatch/{batch_id}',\App\Action\Treks\GetBatch::class);
  $app->post('/treks/updatebatch',\App\Action\Treks\UpdateBatch::class);
  $app->post('/treks/updatebatchstatus', \App\Action\Treks\UpdateBatchStatus::class);
  //Fee
  $app->get('/treks/gettrekfeebyid/{trek_id}', \App\Action\Treks\GetTrekFee::class);
  $app->post('/treks/updatefee',\App\Action\Treks\UpdateTrekFee::class);
  $app->post('/treks/updatepopular',\App\Action\Treks\UpdatePopular::class);

  // //Trek Bookings
  $app->get('/treks/getbatchbookingdeatils/{id}',\App\Action\Treks\GetBatchBookings::class);
  $app->get('/treks/getbookingdetails',\App\Action\Treks\GetBookings::class);
  $app->get('/treks/getparticipantsdetails/{booking_id}',\App\Action\Treks\GetParticipants::class);
  $app->get('/treks/getbookingdetailsbyid/{id}',\App\Action\Treks\GetBookingDetails::class);

    //Transactions
  $app->get('/treks/gettransactiondetails', \App\Action\Treks\GetTransactions::class);
  $app->get('/treks/gettransactiondetailsbyid/{id}',\App\Action\Treks\GetTransactionDetails::class);

  //Trek Organizers
  $app->post('/treks/addorganizer',\App\Action\Treks\AddOrganizer::class);
  $app->get('/treks/getorganizerdetails/{trek_id}',\App\Action\Treks\GetOrganizerDetails::class);
  $app->get('/treks/gettrekdetails/{organizer_id}',\App\Action\Treks\GetOrganizerTreks::class);
  $app->delete('/treks/deletorganizer/{id}',\App\Action\Treks\DeleteOrganizer::class);
  $app->post('/treks/updateorganizerstatus', \App\Action\Treks\UpdateOrganizerStatus::class);
  //Trek Coupons
  $app->post('/treks/addtrekcoupon',\App\Action\Treks\AddTrekCoupon::class);
  $app->get('/treks/gettrekcoupondetails/{trek_id}',\App\Action\Treks\GetTrekCoupons::class);
  $app->get('/treks/gettreksbycouponid/{coupon_id}',\App\Action\Treks\GetCouponTreks::class);
  $app->delete('/treks/deletetrekcoupon/{id}',\App\Action\Treks\DeleteTrekCoupon::class);
  $app->post('/treks/updatecouponstatus', \App\Action\Treks\UpdateCouponStatus::class);
  //Trek Gallery
  $app->get('/treks/trekgallery/{trek_id}',\App\Action\Treks\GetTrekGallery::class);
  $app->post('/treks/addtrekgallery',\App\Action\Treks\AddTrekGallery::class);
  $app->delete('/treks/galleryimagedelete/{image_id}',\App\Action\Treks\DeleteTrekGallery::class);
  $app->post('/treks/updatetrekimagestatus', \App\Action\Treks\UpdateTrekImageStatus::class);
  //Trek Reviews
  $app->get('/treks/trekreviews',\App\Action\Treks\GetTrekReviews::class);
  $app->post('/treks/addtrekreviews',\App\Action\Treks\AddTrekReview::class);
  $app->get('/treks/gettrekreviewbyid/{trek_id}',\App\Action\Treks\GetTrekReview::class);
  $app->post('/treks/updatereviewstatus',\App\Action\Treks\UpdateTrekReview::class);

  //Trek Rentals
  $app->post('/treks/addtrekrentals',\App\Action\Treks\AddTrekRentals::class);
  $app->get('/treks/gettrekrentalsdetails/{trek_id}',\App\Action\Treks\GetTrekRentals::class);
  $app->get('/treks/gettrekdetailsbyrentalid/{rental_id}',\App\Action\Treks\GetRentalTreks::class);
  $app->get('/treks/getrentaldetailsbybatchid/{batch_id}',\App\Action\Treks\GetBatchRentals::class);
  $app->get('/treks/gettrekbatchdetailsbyrentalid/{rental_id}',\App\Action\Treks\GetTrekBatchRental::class);
  $app->delete('/treks/deletetrekrentals/{id}',\App\Action\Treks\DeleteTrekRental::class);
  $app->post('/treks/updatetrekrentalstatus', \App\Action\Treks\UpdateTrekRentalStatus::class);
  // Treks Faq
  $app->get('/treks/getfaq/{trek_id}', \App\Action\Treks\GetFaq::class);
  $app->post('/treks/addtrekfaq',\App\Action\Treks\AddTrekFaq::class);
  $app->post('/treks/updatetrekfaq',\App\Action\Treks\UpdateTrekFaq::class);
  $app->post('/treks/updatetrekfaqstatus', \App\Action\Treks\UpdateTrekFaqStatus::class);

  

  //Bike Trips
  $app->get('/biketrips/getbiketrips',\App\Action\BikeTrips\GetBikeTrips::class);
  $app->post('/biketrips/addbiketrip', \App\Action\BikeTrips\AddBikeTrip::class);
  $app->get('/biketrips/getbiketrip/{tripId}', \App\Action\BikeTrips\GetBikeTrip::class);
  $app->post('/biketrips/updatebiketrip',\App\Action\BikeTrips\UpdateBikeTrip::class);
  $app->delete('/biketrips/deletebiketrip/{tripId}',\App\Action\BikeTrips\DeleteBikeTrip::class);
  $app->post('/biketrips/updatebiketripstatus',\App\Action\BikeTrips\UpdateBikeTripStatus::class);
  //Bike Trip Gallery
  $app->get('/biketrips/getgallery/{biketrip_id}',\App\Action\BikeTrips\GetGallery::class);
  $app->post('/biketrips/addgallery',\App\Action\BikeTrips\AddGallery::class);
  $app->delete('/biketrips/deletegallery/{image_id}',\App\Action\BikeTrips\DeleteGallery::class);
  $app->post('/biketrips/updatetripimagestatus',\App\Action\BikeTrips\UpdateTripImageStatus::class);
  //Bike Trip Batches
  $app->post('/biketrips/addbatch', \App\Action\BikeTrips\AddBatch::class);
  $app->get('/biketrips/getbatch/{batch_id}', \App\Action\BikeTrips\GetBatch::class);
  $app->post('/biketrips/updatebatch',\App\Action\BikeTrips\UpdateBatch::class);
  $app->delete('/biketrips/deletebatch/{batch_id}',\App\Action\BikeTrips\DeleteBatch::class);
  $app->post('/biketrips/updatebatchstatus',\App\Action\BikeTrips\UpdateBatchStatus::class);
  // Bike trip fee
  $app->get('/biketrips/gettripfeebyid/{biketrip_id}', \App\Action\BikeTrips\GetTripFee::class);
  $app->post('/biketrips/updatefee',\App\Action\BikeTrips\UpdateTripFee::class);

  // Bike trip Organizers
  $app->post('/biketrips/addorganizer',\App\Action\BikeTrips\AddOrganizer::class);
  $app->get('/biketrips/getorganizerdetails/{biketrip_id}',\App\Action\BikeTrips\GetOrganizerDetails::class);
  $app->get('/biketrips/gettripdetails/{organizer_id}',\App\Action\BikeTrips\GetOrganizerTrips::class);
  $app->delete('/biketrips/deletorganizer/{id}',\App\Action\BikeTrips\DeleteOrganizer::class);
  $app->post('/biketrips/updateorganizerstatus',\App\Action\BikeTrips\UpdateOrganizerStatus::class);

  //Bike trip Coupons
  $app->post('/biketrips/addtripcoupon',\App\Action\BikeTrips\AddTripCoupon::class);
  $app->get('/biketrips/gettripcoupondetails/{trip_id}',\App\Action\BikeTrips\GetTripCoupons::class);
  $app->get('/biketrips/gettripsbycouponid/{coupon_id}',\App\Action\BikeTrips\GetCouponTrips::class);
  $app->delete('/biketrips/deletetripcoupon/{id}',\App\Action\BikeTrips\DeleteTripCoupon::class);
  $app->post('/biketrips/updatecouponstatus',\App\Action\BikeTrips\UpdateCouponStatus::class);

  //Bike trip Rentals
  $app->post('/biketrips/addtriprentals',\App\Action\BikeTrips\AddTripRentals::class);
  $app->get('/biketrips/gettriprentalsdetails/{trip_id}',\App\Action\BikeTrips\GetTripRentals::class);
  $app->get('/biketrips/gettripdetailsbyrentalid/{rental_id}',\App\Action\BikeTrips\GetRentalTrips::class);
  $app->get('/biketrips/getrentaldetailsbybatchid/{batch_id}',\App\Action\BikeTrips\GetBatchRentals::class);
  $app->get('/biketrips/gettripbatchdetailsbyrentalid/{rental_id}',\App\Action\BikeTrips\GetTripBatchRental::class);
  $app->delete('/biketrips/deletetriprentals/{id}',\App\Action\BikeTrips\DeleteTripRental::class);
  $app->post('/biketrips/updaterentalstatus',\App\Action\BikeTrips\UpdateTripRentalStatus::class);

  //Bike trip Reviews
  $app->get('/biketrips/getreviews',\App\Action\BikeTrips\GetReviews::class);
  $app->post('/biketrips/addreview',\App\Action\BikeTrips\AddReview::class);
  $app->get('/biketrips/getreview/{trip_id}',\App\Action\BikeTrips\GetReview::class);
  $app->post('/biketrips/updatereview',\App\Action\BikeTrips\UpdateReview::class);
  $app->post('/biketrips/updatereviewstatus',\App\Action\BikeTrips\UpdateReviewStatus::class);

  //Bookings and details
  $app->get('/biketrips/getbookings',\App\Action\BikeTrips\GetBookings::class);
  $app->get('/biketrips/getbooking/{id}',\App\Action\BikeTrips\GetBooking::class);
  $app->get('/biketrips/getbatchbooking/{id}',\App\Action\BikeTrips\GetBatchBooking::class);
  $app->get('/biketrips/getparticipants/{booking_id}',\App\Action\BikeTrips\GetParticipants::class);
  $app->get('/biketrips/gettransactions',\App\Action\BikeTrips\GetTransactions::class);  
  $app->get('/biketrips/gettransaction/{id}',\App\Action\BikeTrips\GetTransaction::class);

  $app->post('/biketrips/addbikerentals', \App\Action\BikeTrips\AddBikeRentals::class);
  $app->delete('/biketrips/deleteiterinary/{id}',\App\Action\BikeTrips\DeleteIterinary::class);

   
};