<?php
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

return function (App $app) {
  //$app->get('/', \App\Action\HomeAction::class);
  $app->get('/', \App\Action\Banners\GetBanners::class);
  //Admin roles and privileges
  $app->get('/roles/getroles', \App\Action\Roles\GetRoles::class);
  $app->post('/roles/addrole', \App\Action\Roles\AddRole::class);
  $app->get('/roles/getrole/{roleId}', \App\Action\Roles\GetRole::class);
  $app->post('/addadminrole', \App\Action\AddAdminRole::class);
  $app->post('/roles/updaterole', \App\Action\Roles\UpdateRole::class);
  $app->delete('/deleteadminrole/{roleId}', \App\Action\DeleteAdminRole::class);
  $app->get('/roles/getrolepriviliges/{roleId}', \App\Action\Roles\GetRolePrivileges::class);
  $app->get('/roles/getmodules', \App\Action\Roles\GetModules::class);
  $app->post('/editprivileges', \App\Action\EditPrivileges::class);
  $app->post('/updaterolestatus', \App\Action\UpdateRoleStatus::class);
  $app->post('/roles/updateprivilies', \App\Action\Roles\UpdatePrivilies::class);

  //Admin Users 
  $app->post('/users/checklogin',\App\Action\CheckLogin::class);
	//$app->post('/users/adduser',\App\Action\AddUser::class);
  $app->post('/users/adduser', \App\Action\Users\AddUser::class);
	$app->get('/users/getuser/{userId}', \App\Action\Users\GetUser::class);
	$app->get('/users/getusers',\App\Action\Users\GetUsers::class);
	$app->post('/users/updateuser',\App\Action\Users\UpdateUser::class);
	$app->post('/users/updateuserpassword',\App\Action\Users\UpdateUserPassword::class);
	$app->post('/users/forgotpassword',\App\Action\ForgotPassword::class);
	$app->delete('/users/deleteuser/{userId}',\App\Action\DeleteUser::class);
  $app->post('/users/updateuserstatus', \App\Action\UpdateUserStatus::class);
  //Site Users
  $app->get('/users/getsiteusers', \App\Action\GetSiteUsers::class);
  $app->delete('/users/deletesiteuser/{userId}',\App\Action\DeleteSiteUser::class);
  // $app->get('/users/getuserroles','getUserroles');

  // Dashboard
  $app->get('/dashboard/getdashboarddetails',\App\Action\Dashboard\GetDashboard::class);

  // Enquiries
  $app->get('/enqmgmt/getenqinfo',\App\Action\ContactUs\GetEnqInfo::class);
  $app->get('/enqmgmt/gettrekbookingenq',\App\Action\ContactUs\GetTrekBookingEnq::class);

  //Contact Us  
  $app->get('/contactus/getcontactus',\App\Action\ContactUs\GetContactUs::class);
  $app->POST('/contactus/updatecontactus',\App\Action\ContactUs\UpdateContactUs::class);
  $app->get('/getintouch/getintouchdetails',\App\Action\ContactUs\GetInTouchDetails::class);
  $app->get('/subscribeemails/getsubscribeemail',\App\Action\ContactUs\GetSubscribers::class);

  //Treks
  $app->get('/treks/gettreks',\App\Action\Treks\GetTreks::class);
  $app->post('/treks/addtrek',\App\Action\Treks\AddTrek::class);
  $app->post('/treks/updatetrek',\App\Action\Treks\UpdateTrek::class);
  $app->get('/treks/gettrek/{trekId}', \App\Action\Treks\GetTrek::class);
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

  //Banners
  $app->get('/banners/getbanners', \App\Action\Banners\GetBanners::class);
  $app->post('/banners/addbanner', \App\Action\Banners\AddBanner::class);
  
  $app->get('/banners/getbanner/{bannerId}', \App\Action\Banners\GetBanner::class);
  $app->post('/banners/updatebanner', \App\Action\Banners\UpdateBanner::class);
  $app->delete('/banners/deletebanner/{bannerId}', \App\Action\Banners\DeleteBanner::class);
  $app->post('/banners/updatebannerstatus', \App\Action\Banners\UpdateBannerStatus::class);

  //Videos
  $app->post('/videos/addvideo',\App\Action\Videos\AddVideo::class);
  $app->get('/videos/getvideo/{videoId}', \App\Action\Videos\GetVideo::class);
  $app->get('/videos/getvideos',\App\Action\Videos\GetVideos::class);
  $app->post('/videos/updatevideo', \App\Action\Videos\UpdateVideo::class);
  $app->delete('/videos/deletevideo/{videoId}',\App\Action\Videos\DeleteVideo::class);
  $app->post('/videos/updatevideostatus', \App\Action\Videos\UpdateVideoStatus::class);
  //Blog
  $app->get('/blog/getblogs', \App\Action\Blog\GetBlogs::class);
  $app->get('/blog/getblog/{blogId}', \App\Action\Blog\GetBlog::class);
  $app->post('/blog/updateblog', \App\Action\Blog\UpdateBlog::class);  
  $app->post('/blog/updateblogstatus', \App\Action\Blog\UpdateBlogStatus::class);  
  $app->get('/blog/getblogarticles', \App\Action\Blog\GetBlogArticles::class);
  $app->get('/blog/getblogarticledetails/{id}', \App\Action\Blog\GetBlogArticleDetails::class);
  $app->get('/blog/getblogcategories', \App\Action\Blog\GetBlogCategories::class);
  $app->post('/blog/addblogarticle', \App\Action\Blog\AddBlogArticle::class);
  $app->post('/blog/updateblogarticle', \App\Action\Blog\UpdateBlogArticle::class);
  $app->post('/blog/updatearticlestatus', \App\Action\Blog\UpdateArticleStatus::class); 
  $app->delete('/blog/deletearticle/{id}',\App\Action\Blog\DeleteArticle::class);

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

  // Bike trips Faq
  $app->get('/biketrips/getfaq/{trip_id}', \App\Action\BikeTrips\GetFaq::class);
  $app->post('/biketrips/addtripfaq',\App\Action\BikeTrips\AddTripFaq::class);
  $app->post('/biketrips/updatetripfaq',\App\Action\BikeTrips\UpdateTripFaq::class);
  $app->post('/biketrips/updatetripfaqstatus',\App\Action\BikeTrips\UpdateTripFaqStatus::class);

  // Travel Experts
  $app->get('/travelexperts/gettravelexperts',\App\Action\TravelExperts\GetTravelExperts::class);
  $app->post('/travelexperts/addtravelexpert',\App\Action\TravelExperts\AddTravelExpert::class);
  $app->get('/travelexperts/gettravelexpert/{expert_id}',\App\Action\TravelExperts\GetTravelExpert::class);
  $app->post('/travelexperts/updatetravelexpert',\App\Action\TravelExperts\UpdateTravelExpert::class);
  $app->delete('/travelexperts/deletetravelexpert/{expert_id}',\App\Action\TravelExperts\DeleteTravelExpert::class);
  $app->post('/travelexperts/updatetravelexpertstatus',\App\Action\TravelExperts\UpdateTravelExpertStatus::class);

  // Celebrity trips
  $app->get('/celebritytrips/gettrips',\App\Action\CelebrityTrips\GetTrips::class);
  $app->get('/celebritytrips/gettripenquiries', \App\Action\CelebrityTrips\GetTripEnquiries::class);
  $app->post('/celebritytrips/addtrip', \App\Action\CelebrityTrips\AddTrip::class);
  $app->get('/celebritytrips/gettrip/{trip_id}', \App\Action\CelebrityTrips\GetTrip::class);
  $app->post('/celebritytrips/updatetrip', \App\Action\CelebrityTrips\UpdateTrip::class);
  $app->post('/celebritytrips/updatetripstatus', \App\Action\CelebrityTrips\UpdateTripStatus::class);

  /* Trek Organizers */
  $app->get('/organizers/getorganizerdetails',\App\Action\Organizers\GetOrganizers::class);
  $app->post('/organizers/addorganizer',\App\Action\Organizers\AddOrganizer::class);
  $app->get('/organizers/getorganizerbyid/{organizer_id}',\App\Action\Organizers\GetOrganizer::class);
  $app->post('/organizers/updateorganizer',\App\Action\Organizers\UpdateOrganizer::class);
  $app->delete('/organizers/deletorganizer/{organizer_id}',\App\Action\Organizers\DeleteOrganizer::class);
  $app->post('/organizers/updateorganizerstatus',\App\Action\Organizers\UpdateOrganizerStatus::class);

  /* Bike trips Organizers */
  $app->get('/organizers/gettriporganizers',\App\Action\Organizers\GetTripOrganizers::class);
  $app->post('/organizers/addtriporganizer',\App\Action\Organizers\AddTripOrganizer::class);
  $app->get('/organizers/gettriporganizerbyid/{organizer_id}',\App\Action\Organizers\GetTripOrganizer::class);
  $app->post('/organizers/updatetriporganizer',\App\Action\Organizers\UpdateTripOrganizer::class);
  $app->delete('/organizers/delettriporganizer/{organizer_id}',\App\Action\Organizers\DeleteTripOrganizer::class);
  $app->post('/organizers/updatetriporganizerstatus',\App\Action\Organizers\UpdateTripOrganizerStatus::class);

  /* Expedition Organizers */
  $app->get('/organizers/getexpeditionorganizers',\App\Action\Organizers\GetExpeditionOrganizers::class);
  $app->post('/organizers/addexpeditionorganizer',\App\Action\Organizers\AddExpeditionOrganizer::class);
  $app->get('/organizers/getexpeditionorganizerbyid/{organizer_id}',\App\Action\Organizers\GetExpeditionOrganizer::class);
  $app->post('/organizers/updateexpeditionorganizer',\App\Action\Organizers\UpdateExpeditionOrganizer::class);
  $app->delete('/organizers/deletexpeditionorganizer/{organizer_id}',\App\Action\Organizers\DeleteExpeditionOrganizer::class);
  $app->post('/organizers/updateexpeditionorganizerstatus',\App\Action\Organizers\UpdateExpeditionOrganizerStatus::class);

  //Trek Coupons management
  $app->get('/coupons/getcouponsdetails',\App\Action\Coupons\GetCoupons::class);
  $app->post('/coupons/addcoupon',\App\Action\Coupons\AddCoupon::class);
  $app->get('/coupons/getcoupondetailsbyid/{coupon_id}',\App\Action\Coupons\GetCoupon::class);
  $app->post('/coupons/updatecoupondetails',\App\Action\Coupons\UpdateCoupon::class);
  $app->delete('/coupons/deletcoupon/{coupon_id}',\App\Action\Coupons\DeleteCoupon::class);
  $app->post('/coupons/updatecouponstatus',\App\Action\Coupons\UpdateCouponStatus::class);

  //Trip Coupons management
  $app->get('/coupons/gettripcoupons',\App\Action\Coupons\GetTripCoupons::class);
  $app->post('/coupons/addtripcoupon',\App\Action\Coupons\AddTripCoupon::class);
  $app->get('/coupons/gettripcoupondetailsbyid/{coupon_id}',\App\Action\Coupons\GetTripCoupon::class);
  $app->post('/coupons/updatetripcoupon',\App\Action\Coupons\UpdateTripCoupon::class);
  $app->delete('/coupons/delettripcoupon/{coupon_id}',\App\Action\Coupons\DeleteTripCoupon::class);
  $app->post('/coupons/updatetripcouponstatus',\App\Action\Coupons\UpdateTripCouponStatus::class);

  //Expedition Coupons management
  $app->get('/coupons/getexpeditioncoupons',\App\Action\Coupons\GetExpeditionCoupons::class);
  $app->post('/coupons/addexpeditioncoupon',\App\Action\Coupons\AddExpeditionCoupon::class);
  $app->get('/coupons/getexpeditioncoupondetailsbyid/{coupon_id}',\App\Action\Coupons\GetExpeditionCoupon::class);
  $app->post('/coupons/updateexpeditioncoupon',\App\Action\Coupons\UpdateExpeditionCoupon::class);
  $app->delete('/coupons/deletexpeditioncoupon/{coupon_id}',\App\Action\Coupons\DeleteExpeditionCoupon::class);
  $app->post('/coupons/updateexpeditioncouponstatus',\App\Action\Coupons\UpdateExpeditionCouponStatus::class);

  //Leads
  $app->post('/leads/addleads', \App\Action\Leads\AddLead::class);
  $app->post('/leads/addfollowups', \App\Action\Leads\AddLeadFollowup::class);
  $app->get('/leads/editleads/{lead_id}', \App\Action\Leads\GetLead::class);
  $app->post('/leads/updateleaddetails',\App\Action\Leads\UpdateLead::class);
  $app->delete('/leads/deletelead/{lead_id}',\App\Action\Leads\DeleteLead::class);
  $app->post('/leads/updateleadstatus',\App\Action\Leads\UpdateLeadStatus::class);
  $app->get('/leads/getleads',\App\Action\Leads\GetLeads::class);
  $app->get('/leads/getfollowups/{lead_id}',\App\Action\Leads\GetLeadFollowups::class);
  $app->get('/leads/getfollowupdetails/{followup_id}',\App\Action\Leads\GetFollowupDetails::class);
  $app->post('/leads/updatefollowup', \App\Action\Leads\UpdateLeadFollowup::class);
  $app->delete('/leads/deleteleadfollowup/{followup_id}',\App\Action\Leads\DeleteLeadFollowup::class);
  $app->post('/leads/updatefollowupstatus', \App\Action\Leads\UpdateLeadFollowupStatus::class);
  $app->get('/leads/upcomingfollowups',\App\Action\Leads\GetUpcomingFollowups::class);
  /*
Send SMS
Send Email
Upcoming Follow Ups
*/
   // Campaign Management
  $app->get('/campaignmanagement/getallparticipantdetails',\App\Action\CampaignManagement\GetParticipants::class);
  $app->get('/campaignmanagement/getcampaigndetails',\App\Action\CampaignManagement\GetCampaignDetails::class);
  $app->get('/campaignmanagement/getcampaigntemplatedetails',\App\Action\CampaignManagement\GetTemplates::class);
  $app->get('/campaignmanagement/getcontacts',\App\Action\CampaignManagement\GetContacts::class);
  $app->get('/campaignmanagement/getenquser',\App\Action\CampaignManagement\GetEnqUser::class);
  $app->get('/campaignmanagement/getparticipantdetails',\App\Action\CampaignManagement\GetParticipantDetails::class);
  $app->post('/campaignmanagement/addcampaigntemplate',\App\Action\CampaignManagement\AddTemplate::class);
  $app->get('/campaignmanagement/editcampaigntemplate/{template_id}',\App\Action\CampaignManagement\GetTemplateDetails::class);
  $app->post('/campaignmanagement/updatecampaigntemplate',\App\Action\CampaignManagement\UpdateTemplate::class);
  $app->post('/campaignmanagement/addemailcampaign',\App\Action\CampaignManagement\AddEmailCampaign::class);

  // Hostels
  $app->get('/hostels/gethosteldetails', \App\Action\Hostels\GetHostels::class);
  $app->post('/hostels/addhosteldetails', \App\Action\Hostels\AddHostel::class);
  $app->get('/hostels/edithosteldetails/{hostel_id}', \App\Action\Hostels\GetHostelDetails::class);
  $app->post('/hostels/updatehosteldetails', \App\Action\Hostels\UpdateHostel::class);
  $app->post('/hostels/addhostelenqdetails', \App\Action\Hostels\AddHostelEnquiry::class);
  $app->post('/hostels/updatestatus', \App\Action\Hostels\UpdateHostelStatus::class);
  $app->get('/hostels/gethostelenquires', \App\Action\Hostels\GetHostelEnquiries::class);
  $app->get('/hostels/gethostelenquiredbyid/{id}', \App\Action\Hostels\GetHostelEnquiryId::class);
  
  $app->post('/hostels/addhostelgallery', \App\Action\Hostels\AddHostelGallery::class);  
  $app->get('/hostels/gethostelgallery', \App\Action\Hostels\GetHostelGallery::class);

  //Expeditions
  $app->get('/expeditions/getexpeditions', \App\Action\Expeditions\GetExpeditions::class);
  $app->post('/expeditions/addexpeditions', \App\Action\Expeditions\AddExpedition::class);
  $app->get('/expeditions/getexpeditondetails/{expeditionId}', \App\Action\Expeditions\GetExpedition::class);
  $app->post('/expeditions/updateexpedition', \App\Action\Expeditions\UpdateExpedition::class);
  $app->post('/expeditions/updateexpeditionstatus', \App\Action\Expeditions\UpdateExpeditionStatus::class);
  // Expeditions batches
  $app->post('/expeditions/addexpeditionbatchdetails', \App\Action\Expeditions\AddBatch::class);
  $app->get('/expeditions/editexpeditionbatchdetails/{batch_id}', \App\Action\Expeditions\GetBatch::class);
  $app->post('/expeditions/updateexpeditionbatchdetails', \App\Action\Expeditions\UpdateBatch::class);
  $app->post('/expeditions/updateexpeditionbatchstatus', \App\Action\Expeditions\UpdateBatchStatus::class);
  // Expeditions Fee
  $app->get('/expeditions/getexpeditionfeebyid/{expedition_id}', \App\Action\Expeditions\GetExpeditionFee::class);
  $app->post('/expeditions/updatefee',\App\Action\Expeditions\UpdateExpeditionFee::class);
  $app->post('/expeditions/updatepopular',\App\Action\Expeditions\UpdatePopular::class);

  // Expeditions Bookings
  $app->get('/expeditions/getbatchbookingdeatils/{id}',\App\Action\Expeditions\GetBatchBookings::class);
  $app->get('/expeditions/getbookingdetails',\App\Action\Expeditions\GetBookings::class);
  $app->get('/expeditions/getparticipantsdetails/{booking_id}',\App\Action\Expeditions\GetParticipants::class);
  $app->get('/expeditions/getbookingdetailsbyid/{id}',\App\Action\Expeditions\GetBookingDetails::class);

  //Expeditions Transactions
  $app->get('/expeditions/gettransactiondetails', \App\Action\Expeditions\GetTransactions::class);
  $app->get('/expeditions/gettransactiondetailsbyid/{id}',\App\Action\Expeditions\GetTransactionDetails::class);

  //Expeditions Organizers
  $app->post('/expeditions/addorganizer',\App\Action\Expeditions\AddOrganizer::class);
  $app->get('/expeditions/getorganizerdetails/{expedition_id}',\App\Action\Expeditions\GetOrganizerDetails::class);
  $app->get('/expeditions/getexpeditiondetails/{organizer_id}',\App\Action\Expeditions\GetOrganizerExpeditions::class);
  $app->delete('/expeditions/deletorganizer/{id}',\App\Action\Expeditions\DeleteOrganizer::class);
   $app->post('/expeditions/updateorganizerstatus',\App\Action\Expeditions\UpdateOrganizerStatus::class);
  //Expeditions Coupons
  $app->post('/expeditions/addexpeditioncoupon',\App\Action\Expeditions\AddExpeditionCoupon::class);
  $app->get('/expeditions/getexpeditioncoupondetails/{expedition_id}',\App\Action\Expeditions\GetExpeditionCoupons::class);
  $app->get('/expeditions/getexpeditionsbycouponid/{coupon_id}',\App\Action\Expeditions\GetCouponExpeditions::class);
  $app->delete('/expeditions/deleteexpeditioncoupon/{id}',\App\Action\Expeditions\DeleteExpeditionCoupon::class);
  $app->post('/expeditions/updatecouponstatus',\App\Action\Expeditions\UpdateCouponStatus::class);
  //Expeditions Gallery
  $app->get('/expeditions/expeditiongallery/{expedition_id}',\App\Action\Expeditions\GetExpeditionGallery::class);
  $app->post('/expeditions/addexpeditiongallery',\App\Action\Expeditions\AddExpeditionGallery::class);
  $app->delete('/expeditions/galleryimagedelete/{image_id}',\App\Action\Expeditions\DeleteExpeditionGallery::class);
  $app->post('/expeditions/updateexpeditionimagestatus',\App\Action\Expeditions\UpdateExpeditionImageStatus::class);

  //Expeditions Reviews
  $app->get('/expeditions/expeditionreviews',\App\Action\Expeditions\GetExpeditionReviews::class);
  $app->post('/expeditions/addexpeditionreviews',\App\Action\Expeditions\AddExpeditionReview::class);
  $app->get('/expeditions/getexpeditionreviewbyid/{expedition_id}',\App\Action\Expeditions\GetExpeditionReview::class);
  $app->post('/expeditions/updatereviewstatus',\App\Action\Expeditions\UpdateExpeditionReview::class);

  //Expeditions Rentals
  $app->post('/expeditions/addexpeditionrentals',\App\Action\Expeditions\AddExpeditionRentals::class);
  $app->get('/expeditions/getexpeditionrentalsdetails/{expedition_id}',\App\Action\Expeditions\GetExpeditionRentals::class);
  $app->get('/expeditions/getexpeditiondetailsbyrentalid/{rental_id}',\App\Action\Expeditions\GetRentalExpeditions::class);
  $app->get('/expeditions/getrentaldetailsbybatchid/{batch_id}',\App\Action\Expeditions\GetBatchRentals::class);
  $app->get('/expeditions/getexpeditionbatchdetailsbyrentalid/{rental_id}',\App\Action\Expeditions\GetExpeditionBatchRental::class);
  $app->delete('/expeditions/deleteexpeditionrentals/{id}',\App\Action\Expeditions\DeleteExpeditionRental::class);
  $app->post('/expeditions/updateexpeditionrentalstatus',\App\Action\Expeditions\UpdateExpeditionRentalStatus::class);

  // Expeditions Faq
  $app->get('/expeditions/getfaq/{expedition_id}', \App\Action\Expeditions\GetFaq::class);
  $app->post('/expeditions/addexpeditionfaq',\App\Action\Expeditions\AddExpeditionFaq::class);
  $app->post('/expeditions/updateexpeditionfaq',\App\Action\Expeditions\UpdateExpeditionFaq::class);
  $app->post('/expeditions/updateexpeditionfaqstatus',\App\Action\Expeditions\UpdateExpeditionFaqStatus::class);

  // LeisurePackeges
  $app->get('/leisurepackages/getleisurepackages', \App\Action\LeisurePackages\GetLeisurePackages::class);
  $app->post('/leisurepackages/addleisurepackages', \App\Action\LeisurePackages\AddLeisurePackage::class);
  $app->get('/leisurepackages/editleisurepackages/{lepkg_id}', \App\Action\LeisurePackages\GetLeisurePackage::class);
  $app->post('/leisurepackages/updateleisurepackages', \App\Action\LeisurePackages\UpdateLeisurePackage::class);
  $app->post('/leisurepackages/updateleisurepackagestatus', \App\Action\LeisurePackages\UpdateLeisurePackageStatus::class);

  $app->post('/leisurepackages/addpaddonactivities', \App\Action\LeisurePackages\AddAddOnActivity::class);
  $app->get('/leisurepackages/editaddonactivity/{activity_id}', \App\Action\LeisurePackages\GetAddOnActivity::class);
  $app->post('/leisurepackages/updateaddonactivity', \App\Action\LeisurePackages\UpdateAddOnActivity::class);
  $app->post('/leisurepackages/updateaddonactivitystatus', \App\Action\LeisurePackages\UpdateAddOnActivityStatus::class);

  // Promotions
  $app->get('/promotions/getpromotions', \App\Action\Promotions\GetPromotions::class);
  $app->post('/promotions/addpromotion', \App\Action\Promotions\AddPromotion::class);
  $app->get('/promotions/editpromotiondetails/{promotion_id}', \App\Action\Promotions\GetPromotion::class);
  $app->post('/promotions/updatepromotiondetails', \App\Action\Promotions\UpdatePromotion::class);
  $app->post('/promotions/updatepromotionstatus', \App\Action\Promotions\UpdatePromotionStatus::class);

  //Rental Items
  $app->get('/rentals/getrentals', \App\Action\Rentals\GetRentalItems::class);
  $app->post('/rentals/addrentals', \App\Action\Rentals\AddRentalItem::class);
  $app->get('/rentals/getrentalsbyid/{rental_id}', \App\Action\Rentals\GetRentalItemDetails::class);
  $app->post('/rentals/updaterentals', \App\Action\Rentals\UpdateRentalItem::class);
  $app->delete('/rentals/deletrentals/{id}', \App\Action\Rentals\DeleteRentalItem::class);
  $app->post('/rentals/updaterentalstatus', \App\Action\Rentals\UpdateRentalItemStatus::class);

  // Pages
  $app->get('/pages/getpages',\App\Action\Pages\GetPages::class);
  $app->get('/pages/getpagedetails/{id}', \App\Action\Pages\GetPageDetails::class);
  $app->post('/pages/updatepage', \App\Action\Pages\UpdatePage::class);
  $app->get('/pages/getawards', \App\Action\Pages\GetAwards::class);
  $app->post('/pages/addaward', \App\Action\Pages\AddAward::class);
  $app->get('/pages/getawarddetails/{award_id}', \App\Action\Pages\GetAwardDetails::class);
  $app->post('/pages/updateaward', \App\Action\Pages\UpdateAward::class);
  $app->get('/pages/getmedia', \App\Action\Pages\GetMedia::class);
  $app->post('/pages/addmedia', \App\Action\Pages\AddMedia::class);
  $app->get('/pages/getmediadetails/{media_id}', \App\Action\Pages\GetMediaDetails::class);
  $app->post('/pages/updatemedia',\App\Action\Pages\UpdateMedia::class);

  // Featured content
  $app->get('/featuredcontent/getfeaturedcontent','getFeaturedcontent');
  $app->get('/featuredcontent/editfeaturedcontent/:id','editFeaturedcontent');
  $app->post('/featuredcontent/updatecontentdetails','updateContentDetails');

  // FAQ
  $app->get('/faq/getfaqcategories',\App\Action\Faq\GetFaqCategories::class);

  //Front End services
  
  $app->get('/ridingsolo/offers', \App\Action\Ridingsolo\GetOffers::class);
  $app->get('/ridingsolo/difficulties', \App\Action\Ridingsolo\GetDifficulties::class);
  $app->get('/ridingsolo/bikedifficulties', \App\Action\Ridingsolo\GetBikeDifficulties::class);
  $app->get('/ridingsolo/biketerrains', \App\Action\Ridingsolo\GetBikeTerrains::class);
  $app->get('/ridingsolo/lpterrains', \App\Action\Ridingsolo\GetLpTerrains::class);
  $app->get('/ridingsolo/hostelterrains', \App\Action\Ridingsolo\GetHostelTerrains::class);

  $app->get('/ridingsolo/getmonths', \App\Action\Ridingsolo\GetMonths::class);
  $app->get('/ridingsolo/getslabs', \App\Action\Ridingsolo\GetSlabs::class);
  $app->get('/ridingsolo/getaltitude', \App\Action\Ridingsolo\GetAltitudes::class);  
  $app->get('/ridingsolo/travelexperts', \App\Action\Ridingsolo\GetTravelExperts::class);
  $app->get('/ridingsolo/blogarticles', \App\Action\Ridingsolo\GetBlogArticles::class);
  $app->get('/ridingsolo/howdidyoufindus', \App\Action\Ridingsolo\GetHowDidYouFindUs::class);
  $app->get('/ridingsolo/haveyoutrekkedwithus', \App\Action\Ridingsolo\GetHaveYouTrekkedWithUs::class);
  $app->get('/ridingsolo/getregions', \App\Action\Ridingsolo\GetRegions::class);
  $app->get('/ridingsolo/getstates', \App\Action\Ridingsolo\GetStates::class);

  $app->get('/ridingsolo/getcountries', \App\Action\Ridingsolo\GetCountries::class);
  $app->post('/ridingsolo/getcountrystates', \App\Action\Ridingsolo\GetCountryStates::class);
  $app->post('/ridingsolo/getstatecities', \App\Action\Ridingsolo\GetStateCities::class);

  // Treks
  $app->get('/ridingsolo/populartreks', \App\Action\Ridingsolo\GetPopularTreks::class);
  $app->get('/ridingsolo/upcomingtreks', \App\Action\Ridingsolo\GetUpcomingTreks::class);
  $app->post('/ridingsolo/searchalltreks', \App\Action\Ridingsolo\GetSearchAllTreks::class);
  $app->post('/ridingsolo/filteralltreks', \App\Action\Ridingsolo\GetFilterAllTreks::class);
  $app->get('/ridingsolo/alltreks', \App\Action\Ridingsolo\GetAllTreks::class);
  $app->get('/ridingsolo/gettrekdetails/{trekId}', \App\Action\Ridingsolo\GetTrekDetails::class);
  $app->get('/ridingsolo/trekreviews', \App\Action\Ridingsolo\GetTrekReviews::class);
  $app->post('/ridingsolo/addtrekreviews', \App\Action\Ridingsolo\AddTrekReview::class);
  //Booking process through batch id and mobile number
  $app->post('/ridingsolo/bookingprocess', \App\Action\Ridingsolo\BookingProcess::class); 
  $app->post('/ridingsolo/insertbookingdetails', \App\Action\Ridingsolo\AddBookingDetails::class);
  //payment page with booking id and mobile number
  $app->post('/ridingsolo/paymentpage', \App\Action\Ridingsolo\PaymentPage::class);
  $app->get('/ridingsolo/gettransactiondetails/{userId}', \App\Action\Ridingsolo\GetTransactionDetails::class);    
  $app->post('/ridingsolo/viewinvoice', \App\Action\Ridingsolo\ViewInvoice::class);    
  $app->get('/ridingsolo/getbookingdetails/{userId}', \App\Action\Ridingsolo\GetBookingDetails::class);
  $app->post('/ridingsolo/viewinvoicebd', \App\Action\Ridingsolo\ViewInvoiceBD::class);  
  $app->post('/ridingsolo/getedittrekkerdetails', \App\Action\Ridingsolo\GetEditTrekkerDetails::class);  
  $app->get('/ridingsolo/paymettype', \App\Action\Ridingsolo\GetPaymentType::class);
  $app->post('/ridingsolo/validatepromocode', \App\Action\Ridingsolo\ValidatePromoCode::class);
  $app->post('/ridingsolo/proceedtopay', \App\Action\Ridingsolo\ProceedtoPay::class);
  $app->get('/ridingsolo/bookingsuccess', \App\Action\Ridingsolo\BookingSuccess::class);
  $app->post('/ridingsolo/sendsuccessrequestid', \App\Action\Ridingsolo\SendSuccessRequestId::class);
  $app->post('/ridingsolo/paybalanceamount', \App\Action\Ridingsolo\PayBalanceAmount::class);
  $app->post('/ridingsolo/getsuccessbookingdetails',\App\Action\Ridingsolo\GetSuccessBookingDetails::class);
  $app->get('/ridingsolo/getpaymentdetails/{paymentId}', \App\Action\Ridingsolo\GetPaymentDetails::class);
  //Bike trips
  $app->get('/ridingsolo/populartrips', \App\Action\Ridingsolo\GetPopularTrips::class);
  $app->get('/ridingsolo/upcomingtrips', \App\Action\Ridingsolo\GetUpcomingTrips::class);
  $app->post('/ridingsolo/searchalltrips', \App\Action\Ridingsolo\GetSearchAllTrips::class);
  $app->post('/ridingsolo/filteralltrips', \App\Action\Ridingsolo\GetFilterAllTrips::class);
  $app->get('/ridingsolo/gettripdetails/{tripId}', \App\Action\Ridingsolo\GetTripDetails::class);
  $app->post('/ridingsolo/addtripreviews', \App\Action\Ridingsolo\AddTripReview::class);
  //Booking process through batch id and mobile number
  $app->post('/ridingsolo/tripbookingprocess', \App\Action\Ridingsolo\TripBookingProcess::class);
  $app->post('/ridingsolo/inserttripbookingdetails', \App\Action\Ridingsolo\AddTripBookingDetails::class);
  //payment page with booking id and mobile number
  $app->post('/ridingsolo/trippaymentpage', \App\Action\Ridingsolo\TripPaymentPage::class);
  $app->post('/ridingsolo/gettriptransactiondetails', \App\Action\Ridingsolo\GetTripTransactionDetails::class);
  $app->post('/ridingsolo/viewtripinvoice', \App\Action\Ridingsolo\ViewTripInvoice::class);
  $app->post('/ridingsolo/gettripbookingdetails', \App\Action\Ridingsolo\GetTripBookingDetails::class);
  $app->post('/ridingsolo/viewtripinvoicebd', \App\Action\Ridingsolo\ViewTripInvoiceBD::class);
  $app->post('/ridingsolo/validatetrippromocode', \App\Action\Ridingsolo\ValidateTripPromoCode::class);
  $app->post('/ridingsolo/proceedtopaytrip', \App\Action\Ridingsolo\ProceedtoPayTrip::class);
  $app->get('/ridingsolo/bookingsuccesstrip', \App\Action\Ridingsolo\BookingSuccessTrip::class);
  $app->post('/ridingsolo/sendsuccessrequestidtrip', \App\Action\Ridingsolo\SendSuccessRequestIdTrip::class);
  $app->post('/ridingsolo/paybalanceamounttrip', \App\Action\Ridingsolo\PayBalanceAmountTrip::class);
  $app->post('/ridingsolo/getsuccessbookingdetailstrip',\App\Action\Ridingsolo\GetSuccessBookingDetailsTrip::class);
  $app->get('/ridingsolo/gettrippaymentdetails/{paymentId}', \App\Action\Ridingsolo\GetTripPaymentDetails::class);

  //Expeditions
  $app->get('/ridingsolo/popularexpeditions', \App\Action\Ridingsolo\GetPopularExpeditions::class);
  $app->get('/ridingsolo/upcomingexpeditions', \App\Action\Ridingsolo\GetUpcomingExpeditions::class);
  $app->post('/ridingsolo/searchallexpeditions', \App\Action\Ridingsolo\GetSearchAllExpeditions::class);
  $app->post('/ridingsolo/filterallexpeditions', \App\Action\Ridingsolo\GetFilterAllExpeditions::class);
  $app->get('/ridingsolo/getexpeditiondetails/{expeditionId}', \App\Action\Ridingsolo\GetExpeditionDetails::class);
  $app->post('/ridingsolo/addexpeditionreviews', \App\Action\Ridingsolo\AddExpeditionReview::class);
  //Booking process through batch id and mobile number
  $app->post('/ridingsolo/expeditionbookingprocess', \App\Action\Ridingsolo\ExpeditionBookingProcess::class);
  $app->post('/ridingsolo/insertexpeditionbookingdetails', \App\Action\Ridingsolo\AddExpeditionBookingDetails::class);
  //payment page with booking id and mobile number
  $app->post('/ridingsolo/expeditionpaymentpage', \App\Action\Ridingsolo\ExpeditionPaymentPage::class);
  $app->post('/ridingsolo/getexpeditiontransactiondetails', \App\Action\Ridingsolo\GetExpeditionTransactionDetails::class);
  $app->post('/ridingsolo/viewexpeditioninvoice', \App\Action\Ridingsolo\ViewExpeditionInvoice::class);
  $app->post('/ridingsolo/getexpeditionbookingdetails', \App\Action\Ridingsolo\GetExpeditionBookingDetails::class);
  $app->post('/ridingsolo/viewexpeditioninvoicebd', \App\Action\Ridingsolo\ViewExpeditionInvoiceBD::class);
  $app->post('/ridingsolo/validateexpeditionpromocode', \App\Action\Ridingsolo\ValidateExpeditionPromoCode::class);
  $app->post('/ridingsolo/proceedtopayexpedition', \App\Action\Ridingsolo\ProceedtoPayExpedition::class);
  $app->get('/ridingsolo/bookingsuccessexpedition', \App\Action\Ridingsolo\BookingSuccessExpedition::class);
  $app->post('/ridingsolo/sendsuccessrequestidexpedition', \App\Action\Ridingsolo\SendSuccessRequestIdExpedition::class);
  $app->post('/ridingsolo/paybalanceamountexpedition', \App\Action\Ridingsolo\PayBalanceAmountExpedition::class);
  $app->post('/ridingsolo/getsuccessbookingdetailsexpedition',\App\Action\Ridingsolo\GetSuccessBookingDetailsExpedition::class);
  $app->get('/ridingsolo/getexppaymentdetails/{paymentId}', \App\Action\Ridingsolo\GetExpPaymentDetails::class);

  // Leisure packages
  $app->get('/ridingsolo/popularleisuretrips', \App\Action\Ridingsolo\GetPopularLeisureTrips::class);
  $app->get('/ridingsolo/upcomingleisuretrips', \App\Action\Ridingsolo\GetUpcomingLeisureTrips::class);
  $app->post('/ridingsolo/searchallleisuretrips', \App\Action\Ridingsolo\GetSearchAllLeisureTrips::class);
  $app->post('/ridingsolo/filterallleisuretrips', \App\Action\Ridingsolo\GetFilterAllLeisureTrips::class);
  $app->get('/ridingsolo/getleisuretripdetails/{trip_id}', \App\Action\Ridingsolo\GetLeisureTripDetails::class);
  $app->post('/ridingsolo/addleisuretripreviews', \App\Action\Ridingsolo\AddLeisureTripReview::class);

  $app->post('/ridingsolo/lpbookingprocess', \App\Action\Ridingsolo\LpBookingProcess::class); 
  $app->post('/ridingsolo/insertlpbookingdetails', \App\Action\Ridingsolo\AddLpBookingDetails::class);
  $app->post('/ridingsolo/lppaymentpage', \App\Action\Ridingsolo\LpPaymentPage::class);


  $app->post('/ridingsolo/getlptransactiondetails', \App\Action\Ridingsolo\GetLpTransactionDetails::class);
  $app->post('/ridingsolo/viewlpinvoice', \App\Action\Ridingsolo\ViewLpInvoice::class);
  $app->post('/ridingsolo/getlpbookingdetails', \App\Action\Ridingsolo\GetLpBookingDetails::class);
  $app->post('/ridingsolo/viewlpinvoicebd', \App\Action\Ridingsolo\ViewLpInvoiceBD::class);
  $app->post('/ridingsolo/validatelppromocode', \App\Action\Ridingsolo\ValidateLpPromoCode::class);
  $app->post('/ridingsolo/proceedtopaylp', \App\Action\Ridingsolo\ProceedtoPayLp::class);
  $app->get('/ridingsolo/bookingsuccesslp', \App\Action\Ridingsolo\BookingSuccessLp::class);
  $app->post('/ridingsolo/sendsuccessrequestidlp', \App\Action\Ridingsolo\SendSuccessRequestIdLp::class);
  $app->post('/ridingsolo/paybalanceamountlp', \App\Action\Ridingsolo\PayBalanceAmountLp::class);
  $app->post('/ridingsolo/getsuccessbookingdetailslp',\App\Action\Ridingsolo\GetSuccessBookingDetailsLp::class);
  $app->get('/ridingsolo/getlppaymentdetails/{paymentId}', \App\Action\Ridingsolo\GetLpPaymentDetails::class);


  // Hostels
  $app->get('/ridingsolo/popularhostels', \App\Action\Ridingsolo\GetPopularExpeditions::class);
  $app->get('/ridingsolo/upcominghostels', \App\Action\Ridingsolo\GetUpcomingExpeditions::class);
  $app->post('/ridingsolo/searchallhostels', \App\Action\Ridingsolo\GetSearchAllHostels::class);
  $app->post('/ridingsolo/filterallhostels', \App\Action\Ridingsolo\GetFilterAllHostels::class);
  $app->get('/ridingsolo/gethosteldetails/{hostel_id}', \App\Action\Ridingsolo\GetHostelDetails::class);
  $app->post('/ridingsolo/inserthostelbooking', \App\Action\Ridingsolo\AddHostelBookingDetails::class);

  // Calebrity Trips
  $app->get('/ridingsolo/getcelebritytrips', \App\Action\Ridingsolo\GetCelebrityTrips::class);
  $app->get('/ridingsolo/getcelebritytripdetails/{trip_id}', \App\Action\Ridingsolo\GetCelebrityTripDetails::class);
  $app->post('/ridingsolo/insertcelebrityenquiry', \App\Action\Ridingsolo\AddCelebrityTripEnquiry::class);

  //Dashboard
  $app->post('/ridingsolo/dashboard', \App\Action\Ridingsolo\GetDashboard::class);
  // View user profile
  $app->post('/ridingsolo/getuserdetails', \App\Action\Ridingsolo\GetUserDetails::class);
  // Update user profile
  $app->post('/ridingsolo/updateuserdetails', \App\Action\Ridingsolo\UpdateUserDetails::class);
  // Booking History
  $app->post('/ridingsolo/getbookinghistory', \App\Action\Ridingsolo\GetBookingHistory::class);
  //login otp
  $app->post('/ridingsolo/getloginotp', \App\Action\Ridingsolo\GetLoginOtp::class);
  //Rakesh done this for registered user otp validation
  $app->post('/ridingsolo/getregisteruserotp', \App\Action\Ridingsolo\GetRegisterUserOtp::class);
  //verifying otp got through email and sms
  $app->post('/ridingsolo/getverifyotp', \App\Action\Ridingsolo\GetVerifyOtp::class);
  //registeration form mobilenumber
  $app->post('/ridingsolo/insertuserdetails', \App\Action\Ridingsolo\AddUserDetails::class);
  
  //for gmail login
  $app->post('/ridingsolo/gmaillogin', \App\Action\Ridingsolo\GmailLogin::class);
  //registeration to email id
  $app->post('/ridingsolo/insertuserdetailsgmail', \App\Action\Ridingsolo\AddUserDetailsGmail::class);
  
  $app->post('/ridingsolo/resendotp', \App\Action\Ridingsolo\ResendOtp::class);
  $app->post('/ridingsolo/insertuserparticipantdetails', \App\Action\Ridingsolo\AddUserParticipants::class);
  $app->post('/ridingsolo/getalluserparticipantdetails', \App\Action\Ridingsolo\GetAllUserParticipantDetails::class);
  $app->post('/ridingsolo/updateuserparticipantdetails', \App\Action\Ridingsolo\UpdateUserParticipantDetails::class);
  $app->delete('/ridingsolo/deleteuserparticipant/{partcipantId}', \App\Action\Ridingsolo\DeleteUserParticipant::class);
  $app->post('/ridingsolo/addwishlist', \App\Action\Ridingsolo\AddUserWishlist::class);
  $app->get('/ridingsolo/getwishlist/{userId}', \App\Action\Ridingsolo\GetUserWishlist::class);
  $app->post('/ridingsolo/updatebatchdate', \App\Action\Ridingsolo\UpdateBatchDate::class);

  //Support ticketing
  //front end
  $app->get('/tickets/getticketcategory', \App\Action\Tickets\GetTicketCategories::class);
  $app->get('/tickets/getticketpriority', \App\Action\Tickets\GetTicketPriority::class);
  $app->get('/tickets/getticketclassification', \App\Action\Tickets\GetTicketClassification::class);          
  $app->get('/tickets/getticketstatus', \App\Action\Tickets\GetTicketStatus::class);
  $app->post('/tickets/getallusertickets', \App\Action\Tickets\GetAllUserTickets::class);
  $app->post('/tickets/addticket',\App\Action\Tickets\AddSupportTicket::class);
  $app->get('/tickets/getticketdetails/{t_code}', \App\Action\Tickets\GetTicketDetails::class);
  $app->post('/tickets/updateticket',\App\Action\Tickets\UpdateSupportTicket::class);
  $app->delete('/tickets/deleteticket/{ticket_id}', \App\Action\Tickets\DeleteSupportTicket::class);
  $app->get('/tickets/getattachments/{code}', \App\Action\Tickets\GetTicketAttachments::class);
  $app->post('/tickets/addusercomment', \App\Action\Tickets\AddUserComment::class);
  $app->get('/tickets/getallcomments/{ticket_id}', \App\Action\Tickets\GetTicketComments::class); 

  // Admin
  $app->get('/tickets/getalltickets', \App\Action\Tickets\GetAllTickets::class);
  $app->get('/tickets/getticketdetailsbycode/{t_code}', \App\Action\Tickets\GetTicketDetailsByCode::class);
  $app->get('/tickets/gettickethistorydetails/{ticket_id}', \App\Action\Tickets\GetTicketHistory::class);
  $app->post('/tickets/addadmincomment', \App\Action\Tickets\AddAdminComment::class);

  //$app->post('/tickets/searchtickets2', \App\Action\Tickets\SearchTickets2::class);
  $app->post('/tickets/updateticketdetails', \App\Action\Tickets\UpdateTicketDetails::class);
  $app->get('/tickets/getticketnotesdetails/{t_code}', \App\Action\Tickets\GetTicketNotes::class);
  $app->post('/tickets/addnote', \App\Action\Tickets\AddTicketNote::class);
  $app->post('/tickets/updateticketnotes', \App\Action\Tickets\UpdateTicketNote::class);
  $app->delete('/tickets/deletenotes/{note_id}', \App\Action\Tickets\DeleteTicketNotes::class);
  //$app->delete('/tickets/deleteattachment/{attach_id}', \App\Action\Tickets\DeleteAttachment::class);
  $app->post('/tickets/searchtickets', \App\Action\Tickets\SearchTickets::class);
  
  //aboutus
  $app->get('/ridingsolo/aboutus', \App\Action\Ridingsolo\AboutUsPage::class);    
  //contactus
  $app->get('/ridingsolo/contactus', \App\Action\Ridingsolo\ContactUsPage::class);
  //submit contact us form
  $app->post('/ridingsolo/submitcontactus', \App\Action\Ridingsolo\SubmitContactUs::class);
  //terms&condition and privacy
  $app->get('/ridingsolo/termsprivacy', \App\Action\Ridingsolo\TermsPrivacyPage::class);  
  $app->get('/ridingsolo/medicaldeclaration', \App\Action\Ridingsolo\MedicalPage::class);  
  $app->get('/ridingsolo/liabilities', \App\Action\Ridingsolo\LiabilitiesPage::class);  

  $app->get('/ridingsolo/testimonials', \App\Action\Ridingsolo\TestimonialsPage::class);  
  $app->post('/ridingsolo/submitpartnerwithus', \App\Action\Ridingsolo\SubmitPartnerWithUs::class);

  //blog
  $app->get('/ridingsolo/getblogcategories', \App\Action\Ridingsolo\GetBlogPageCategories::class);
  $app->get('/ridingsolo/getrecentposts', \App\Action\Ridingsolo\GetBlogRecentPosts::class);
  $app->get('/ridingsolo/getunkonwnpath', \App\Action\Ridingsolo\GetBlogUnkonwnPath::class);
  $app->get('/ridingsolo/getblogarticles', \App\Action\Ridingsolo\GetBlogPageArticles::class);
  $app->get('/ridingsolo/getblogarticledetails/{id}', \App\Action\Ridingsolo\GetBlogPageArticleDetails::class);
  $app->post('/ridingsolo/submitcomment', \App\Action\Ridingsolo\SubmitArticleComment::class);
  $app->get('/ridingsolo/getcategoryblogarticles/{category_id}', \App\Action\Ridingsolo\GetCategoryBlogArticles::class);

  $app->post('/ridingsolo/addingtrekbackend', \App\Action\Ridingsolo\AddingTrekBackend::class);

  $app->get('/ridingsolo/getpromocodes', \App\Action\Ridingsolo\GetPromoCodes::class);

  //hotels ezee technosys
  $app->post('/ridingsolo/listallhotels', \App\Action\Ridingsolo\GetListHotels::class);
  $app->post('/ridingsolo/gethoteldetails', \App\Action\Ridingsolo\GetHotelDetails::class);
  $app->post('/ridingsolo/inserthotelbooking', \App\Action\Ridingsolo\AddHotelBooking::class);
  $app->post('/ridingsolo/processhotelbooking', \App\Action\Ridingsolo\ProcessHotelBooking::class);

  //get quote
  $app->post('/ridingsolo/insertquote', \App\Action\Ridingsolo\AddQuoteDetails::class);  
};