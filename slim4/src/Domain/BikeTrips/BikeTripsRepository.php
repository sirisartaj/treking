<?php

namespace App\Domain\BikeTrips;
use PDO;
/**
* Repository.
*/
class BikeTripsRepository
{
  /**
   * @var PDO The database connection
   */
  private $connection;
  /**
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  /**
   * Get Admin Roles rows.
   *
   * @return array 
   */
  public function getBikeTrips(): array
  {      
    $sql = "SELECT `biketrips_id` AS tripId, `trip_title` AS tripTitle, `trip_days` AS tripDays, `trip_nights` AS tripNights, `trip_fee` AS tripFee, CONCAT('".UPLOADURL."biketrips/', `trip_image`) AS tripImage, `difficulty`, `region`, `tripvideo_url` AS tripvideoUrl, `tripvideo_title` AS tripvideoTitle, `season`, `popular_trips` AS popularTrips, `spoc_name` AS spocName, `spoc_mobile` AS spocMobile, `spoc_email` AS spocEmail, `spoc_designation` AS spocDesignation, `trip_overview` AS tripOverview, `things_carry` AS thingsCarry, `terms_conditions` AS termsConditions, `how_to_reach` AS howToReach, `faq`, `altitude`, `visit_time` AS visitTime, `temparature`, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` AS createdBy, `modified_by` AS modifiedBy, CONCAT('".UPLOADURL."biketrips/', `trip_pagebanner`) AS tripPagebanner, trip_discount AS tripDiscount FROM sg_biketrips where status!='9'";    
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $results =$stmt->fetchAll(PDO::FETCH_OBJ);

    if(!empty($results)){
     $status = array(
       'status' =>"200",
       'message' =>"Success",
       'allBikeTrips' => $results);
       return $status;
    }else{
      $status = array('status'=>ERR_NO_DATA,
       'message'=>"No Data Found");
       return $status;
      }
  }
  public function insertTrip($data) {
    try {
      extract($data);
      $sql = "INSERT INTO sg_biketrips(trip_title,trip_days,trip_nights,trip_fee,trip_image,trip_pagebanner,difficulty,region,tripvideo_url,tripvideo_title,season,      spoc_name, spoc_mobile,spoc_email,spoc_designation,trip_overview,things_carry,      faq,terms_conditions,how_to_reach,altitude,visit_time,temparature,popular_trips,status,created_date,created_by)values(:trip_title,:trip_days,:trip_nights,:trip_fee,:trip_image, :trip_pagebanner,:difficulty,:region,:tripvideo_url,       :tripvideo_title,:season,:spoc_name,:spoc_mobile,:spoc_emailid,        :spoc_designation,:overview,:things_carry,:faq,:terms_conditions,       :how_to_reach,:altitude,:visit_time,:temparature,:popular_trips,:status,:created_date,:created_by)";
      $stmt = $this->connection->prepare($sql); 
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':trip_title', $tripTitle);
      $stmt->bindParam(':trip_days', $tripDays);
      $stmt->bindParam(':trip_nights', $tripNights);
      $stmt->bindParam(':trip_fee', $tripFee);
      $stmt->bindParam(':trip_image',$biketripImage);
      $stmt->bindParam(':trip_pagebanner',$tripPagebanner);
      $stmt->bindParam(':difficulty', $difficulty);
      $stmt->bindParam(':region', $region);
      $stmt->bindParam(':tripvideo_url', $tripvideoUrl);
      $stmt->bindParam(':tripvideo_title', $tripvideoTitle);
      $stmt->bindParam(':season', $season);
      $stmt->bindParam(':spoc_name', $spocName);
      $stmt->bindParam(':spoc_mobile', $spocMobile);
      $stmt->bindParam(':spoc_emailid', $spocEmailid);
      $stmt->bindParam(':spoc_designation',$spocDesignation);
      $stmt->bindParam(':overview', $overview);
      $stmt->bindParam(':things_carry', $thingsCarry);
      $stmt->bindParam(':faq',$faq);
      $stmt->bindParam(':terms_conditions', $termsConditions);
      $stmt->bindParam(':how_to_reach', $howToReach);
      $stmt->bindParam(':altitude', $altitude);
      $stmt->bindParam(':visit_time', $visitTime);
      $stmt->bindParam(':temparature', $temparature);
      $stmt->bindParam(':popular_trips', $popularTrips);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$createdDate);
      $stmt->bindParam(':created_by' , $createdBy);
      $stmt->execute();
      $trip_id= $this->connection->lastInsertId();
      return $trip_id;     
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addTripIterinaryDetails($data) {
    try {
      extract($data);
      $query2 = "INSERT INTO sg_tripitinerary SET title=:title,description=:description,trip_id=:trip_id,created_date =:created_date,created_by=:created_by";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->bindParam(':title',  $title);
      $stmt2->bindParam(':description',$description);
      $stmt2->bindParam(':trip_id',$trip_id);
      $stmt2->bindParam(':created_date', $createdDate);
      $stmt2->bindParam(':created_by', $createdBy);
      return $stmt2->execute();
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function checkTripName($trip_title) {
    $sql = "SELECT count(`biketrips_id`) as cnt FROM " . DBPREFIX . "_biketrips where  `trip_title`= :trip_title and status!='9'";
    $stmt = $this->connection->prepare($sql);
    $stmt->bindParam(':trip_title', $trip_title);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_OBJ);
    $cnt = $count->cnt;
    return $cnt;
  }
  public function updateTrip($data) {
    try {
      extract($data);
      $query  =  "UPDATE sg_biketrips SET trip_title=:trip_title,trip_days=:trip_days , trip_nights = :trip_nights, trip_fee = :trip_fee , trip_image = :trip_image , trip_pagebanner  = :trip_pagebanner, difficulty = :difficulty, region = :region , tripvideo_url = 
         :tripvideo_url, tripvideo_title = :tripvideo_title, season = :season ,spoc_name = :spoc_name,spoc_email = :spoc_emailid,spoc_designation = :spoc_designation,trip_overview = :overview,things_carry = :things_carry,faq=:faq,terms_conditions = :terms_conditions,how_to_reach = :how_to_reach,altitude = :altitude , visit_time = :visit_time ,temparature = :temparature ,popular_trips = :popular_trips,status = :status,modified_date = :modified_date,modified_by = :modified_by WHERE biketrips_id = :biketrips_id";
      $stmt = $this->connection->prepare($query);  
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':trip_title', $tripTitle);
      $stmt->bindParam(':trip_days', $tripDays);
      $stmt->bindParam(':trip_nights', $tripNights);
      $stmt->bindParam(':trip_fee', $tripFee);
      $stmt->bindParam(':trip_image',$biketripImage);
      $stmt->bindParam(':trip_pagebanner', $tripPagebanner);
      $stmt->bindParam(':difficulty', $difficulty);
      $stmt->bindParam(':region', $region);
      $stmt->bindParam(':tripvideo_url', $tripvideoUrl);
      $stmt->bindParam(':tripvideo_title', $tripvideoTitle);
      $stmt->bindParam(':season', $season);
      $stmt->bindParam(':spoc_name', $spocName);
      $stmt->bindParam(':spoc_emailid', $spocEmailid);
      $stmt->bindParam(':spoc_designation', $spocDesignation);
      $stmt->bindParam(':overview', $overview);
      $stmt->bindParam(':things_carry', $thingsCarry);
      $stmt->bindParam(':terms_conditions', $termsConditions);
      $stmt->bindParam(':faq',$faq);
      $stmt->bindParam(':how_to_reach', $howToReach);
      $stmt->bindParam(':altitude', $altitude);
      $stmt->bindParam(':visit_time', $visitTime);
      $stmt->bindParam(':temparature', $temparature);
      $stmt->bindParam(':popular_trips', $popularTrips);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modifiedDate);
      $stmt->bindParam(':modified_by', $modifiedBy);
      $stmt->bindParam(':biketrips_id',$biketripsId);
      return $res = $stmt->execute();
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateTripIterinaryDetails($data) {
    try {
      extract($data);
      if(@$data['id']){
        $query2 = "UPDATE sg_tripitinerary SET title=:title, description=:description,modified_date=:modified_date,modified_by=:modified_by where  tripitinerary_id = :tripitinerary_id";
        $stmt2 = $this->connection->prepare($query2);
        $stmt2->bindParam(':title', $title);
        $stmt2->bindParam(':description', $description);
        $stmt2->bindParam(':tripitinerary_id', $id);
        $stmt2->bindParam(':modified_date',$modifiedDate);
        $stmt2->bindParam(':modified_by',$modifiedBy);
        $res = $stmt2->execute();
      } 
      else {
        $query3 = "INSERT INTO sg_tripitinerary SET title=:title, description=:description , trip_id = :trip_id,created_date = :created_date,created_by=:created_by";
        $stmt3 = $db->prepare($query3);
        $stmt3->bindParam(':title',$title);
        $stmt3->bindParam(':iterinary_details', $description);
        $stmt3->bindParam(':trip_id', $biketripsId);
        $stmt3->bindParam(':created_date',$modifiedDate);
        $stmt3->bindParam(':created_by',$modifiedBy);
        $res = $stmt3->execute();
      }
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function checktrip($trip_title,$biketrips_id)
  {
   try {
      $sql = "SELECT count(`biketrips_id`) as cnt FROM ".DBPREFIX."_biketrips where `trip_title`=:trip_title and `biketrips_id`!= :biketrips_id and status!='9'";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':trip_title',$trip_title);
      $stmt->bindParam(':biketrips_id',$biketrips_id);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    }
    catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function getBikeTrip($data) {    
    try {
      extract($data);
      $query = "SELECT `biketrips_id` AS tripId, `trip_title` AS tripTitle, `trip_days` AS tripDays, `trip_nights` AS tripNights, `trip_fee` AS tripFee, CONCAT('".UPLOADURL."biketrips/', `trip_image`) AS tripImage, `difficulty`, `region`, `tripvideo_url` AS tripvideoUrl, `tripvideo_title` AS tripvideoTitle, `season`, `popular_trips` AS popularTrips, `spoc_name` AS spocName, `spoc_mobile` AS spocMobile, `spoc_email` AS spocEmail, `spoc_designation` AS spocDesignation, `trip_overview` AS tripOverview, `things_carry` AS thingsCarry, `terms_conditions` AS termsConditions, `how_to_reach` AS howToReach, `faq`, `altitude`, `visit_time` AS visitTime, `temparature`, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` AS createdBy, `modified_by` AS modifiedBy, CONCAT('".UPLOADURL."biketrips/', `trip_pagebanner`) AS tripPagebanner, trip_discount AS tripDiscount FROM sg_biketrips WHERE biketrips_id=:biketrip_id";
      $stmt = $this->connection->prepare( $query );
      $stmt->bindParam(':biketrip_id', $tripId);
      $stmt->execute();
      $res['trips'] = $stmt->fetch(PDO::FETCH_OBJ);
      $query2 = "SELECT * FROM sg_tripitinerary where trip_id = :biketrips_id";
      $stmt2 = $this->connection->prepare( $query2 );
      $stmt2->bindParam(':biketrips_id',$tripId);
      $stmt2->execute();
      $res['tripitinerary'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success",
                  'biketrip' => $res);
        return $status;
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status; 
    }
  }
  public function deleteBikeTrip($data) {
    try{
      extract($data);
      $sql = "UPDATE ".DBPREFIX."_biketrips set status ='9' WHERE biketrips_id = :biketrips_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(":biketrips_id",$biketrips_id);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
        return $status;
      }
    }
    catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addBatch($data) {
   try {
	    extract($data);
	    $query = "INSERT INTO sg_tripbatches(tripstart_date, tripend_date, tripbatch_size, tripbatch_status, trip_id, created_date, created_by) values(:tripstart_date, :tripend_date, :tripbatch_size, :tripbatch_status, :trip_id, :created_date, :created_by)";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripstart_date',$startDate);
      $stmt->bindParam(':tripend_date', $endDate);
      $stmt->bindParam(':tripbatch_size', $batchSize);
      $stmt->bindParam(':tripbatch_status',$batchStatus);
      $stmt->bindParam(":trip_id", $tripId);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$userBy);
      $stmt->execute();
      return $tripbatch_id = $this->connection->lastInsertId();
   }  catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBatch($data) {
    try {
      extract($data);
      $sql = "SELECT gettripname(`trip_id`) as tripTitle,`tripbatch_id` AS batchId,`tripstart_date` AS startDate,`tripend_date` AS endDate,  `tripbatch_status` AS status,`trip_id` AS tripId FROM sg_tripbatches WHERE `tripbatch_id`=:tripbatch_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(':tripbatch_id',$batch_id);  
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if($res!=''){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        'biketripdetails' => $res);
        return $status;
      }else{
        $status = array(
        'status' => "204",
        'message' => " No Data found");
       return $status;
      }
    } catch(PDOException $e) {
      $status = array(
      'status' => "500",
      'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function updateBatch($data) {
    try {
      extract($data);
      $sql  = "UPDATE  sg_tripbatches SET tripstart_date=:tripstart_date, tripend_date=:tripend_date , tripbatch_status = :tripbatch_status , trip_id = :trip_id,modified_date=:modified_date WHERE tripbatch_id = :tripbatch_id";
      $stmt = $this->connection->prepare($sql); 
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':tripstart_date', $startDate);
      $stmt->bindParam(':tripend_date', $endDate);
      $stmt->bindParam(':tripbatch_status', $batchStatus);
      $stmt->bindParam(':trip_id', $tripId);
      $stmt->bindParam(':tripbatch_id', $tripbatchId);
      $stmt->bindParam(':modified_date', $modified_date);
      $res = $stmt->execute();
      if($res=='true'){
        $status = array(
         'status' => ERR_OK,
         'message' => "Updated Successfully");
        return $status;
      }else{
         $status = array(
           'status' => ERR_NOT_MODIFIED,
           'message' => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
  public function deleteBatch($data) {
    try {
      $sql = "UPDATE ".DBPREFIX."_tripbatches set tripbatch_status ='9' WHERE tripbatch_id = :tripbatch_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":tripbatch_id",$tripbatch_id);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success Biketripbatch Deleted successfully"
        );
        return $status;
      }else{
        $status = array(
            'status' => ERR_NOT_MODIFIED,
            'message' => "Failure Biketripbatch Not Deleted successfully"
          );
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function getGallery($data) {
    try {
      extract($data);
      $query = "SELECT tripimage_id AS tripImageId, CONCAT('".UPLOADURL."biketripsgallery/', `image_name`) AS imageName, image_type AS imageType, trip_id AS tripId, status, created_date AS createdDate, created_by AS createdBy FROM sg_trip_gallery WHERE `trip_id`=:trip_id and status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trip_id', $biketrip_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        'gallery_image' => $res);
        return $status;
      }else{
        $status = array(
        'status' => "204",
        'message' => "No Data Found");
        return $status;
      }
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addGallery($data) {
    try {
      extract($data);
      $query = "INSERT INTO ".DBPREFIX."_trip_gallery(`image_name`,`trip_id`,`image_type`,created_date,created_by,status) values(:image_name,:trip_id,:image_type,:created_date,:created_by,:status)";
      $stmt = $this->connection->prepare($query);
      $created_date=date("Y-m-d H:i:s");
      $stmt->bindParam(':image_name', $tripgalImage);
      $stmt->bindParam(':trip_id', $tripId);
      $stmt->bindParam(':image_type', $ext);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->bindParam(':status',$status);
      $stmt->execute();
      $image_id = $this->connection->lastInsertId();
      if(!empty($image_id)){
        $status = array(
        'status' => ERR_OK,
        'message' => "Image Inserted Successfully");
      }else{
        $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Image Not Inserted Successfully");
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function deleteGallery($data) {
    try{
      extract($data);
      $query = "UPDATE sg_trip_gallery SET status='9' where tripimage_id=:tripimage_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripimage_id',$image_id);
      $res = $stmt->execute();
      if($res == 'true'){ 
        $status = array(
          'status' => ERR_OK,
          'message' => "Image Deleted Successfully");
        return $status;
      } else {
        $status = array(
        'status' => ERR_NOT_MODIFIED,
          'message' => "Error!!Image Not Deleted");
        return $status;
      }
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function getReviews() {
    try{
      $query ="SELECT `tripreview_id` AS reviewId, `name`, `mobile_no` AS mobile, `rating`, `review`, gettripname(`biketrip_id`) as bikeTripTitle, recordstatus AS status FROM sg_tripreviews WHERE status!='9'  ORDER BY tripreview_id DESC";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'trip_reviews' => $results
        );
      }else{
        $status = array(
        "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    }
    catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function addReview($data) {
    try{
      extract($data);
      if(empty($name)){
        $status = array(
          'status' => "206",
          'message' => "Failure name is required"
        );
      }
      else{
        $sql = "INSERT INTO sg_tripreviews (name, mobile_no, rating, review, biketrip_id, recordstatus, created_date, created_by, status) VALUES(:name, :mobile_no, :rating, :review, :biketrip_id, :recordstatus, :created_date, :created_by, :status)";
        $stmt = $this->connection->prepare($sql);
        $status = '1';
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":mobile_no",$mobile);
        $stmt->bindParam(":rating", $rating);
        $stmt->bindParam(":review", $review);
        $stmt->bindParam(":biketrip_id", $bikeTripId);
        $stmt->bindParam(":recordstatus", $status);
        $stmt->bindParam(":created_date",$created_date);
        $stmt->bindParam(":created_by", $createdBy);
        $stmt->bindParam(":status", $status);
        $res = $stmt->execute();
        if ($res =='true'){
          $status = array('status'=>"200",
          'message'=>"Success Review Added Successfully");
        }
        else{
          $status = array('status'=>"304",
          'message'=> "Sorry, Please try once again!");
        }
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getReview($data) {
    try{
      extract($data);
      $query ="SELECT tripreview_id AS reviewId, review, name, rating+0.0 as rating, mobile_no AS mobile, DATE_FORMAT(`created_date`,'%M %d,%Y') AS createdDate, recordstatus AS recordStatus FROM sg_tripreviews WHERE `biketrip_id`= :biketrip_id AND `status` !='9' order by tripreview_id desc";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':biketrip_id',$trip_id);
      $stmt->execute();
      $results = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($results)){
         $status = array(
          'status' => ERR_OK,
          'message' => "Success",
          'trip_reviews' => $results
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateReview($data) {
    try{
    extract($data);
    if($status == '0') {
      $upd_status = '1';
    } else {
      $upd_status = '0';
    }
    $query = "UPDATE sg_tripreviews SET recordstatus = :status, modified_by = :modified_by, modified_date=:modified_date WHERE tripreview_id = :tripreview_id";
    $modified_date = date("Y-m-d H:i:s");
    $stmt = $this->connection->prepare($query);
    $stmt->bindParam(':status',$upd_status);
    $stmt->bindParam(':modified_by',$modifiedBy);
    $stmt->bindParam(':modified_date',$modified_date);
    $stmt->bindParam(':tripreview_id',$tripReviewId);
    $res = $stmt->execute();
    if($res == 'true'){
      $status = array(
        'status' => ERR_OK,
        'message' => "Success");
    }else{
      $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure");
    }
    return $status;
   } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateReviewStatus($data) {
    try{
    extract($data);
    $query = "UPDATE sg_tripreviews SET recordstatus = :status, modified_by = :modified_by, modified_date=:modified_date WHERE tripreview_id = :tripreview_id";
    $modified_date = date("Y-m-d H:i:s");
    $stmt = $this->connection->prepare($query);
    $stmt->bindParam(':status',$status);
    $stmt->bindParam(':modified_by',$modifiedBy);
    $stmt->bindParam(':modified_date',$modified_date);
    $stmt->bindParam(':tripreview_id',$tripReviewId);
    $res = $stmt->execute();
    if($res == 'true'){
      $status = array(
        'status' => ERR_OK,
        'message' => "Success");
    }else{
      $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure");
    }
    return $status;
   } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBookings() {
    try{
      $query = "SELECT p.`name` as customerName, p.`mobile` as mobile, b.`tripbooking_id` AS tripBookingId, b.`address`, b.`state`, b.`city`, DATE_FORMAT(b.`created_date`,'%d %M %Y') as createdDate, gettripname(b.`trip_id`) as tripName, gettripparticipantscount(b.`tripbooking_id`) as personCnt, Concat(DATE_FORMAT(i.`tripstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`tripend_date`,'%d %M %Y')) AS batchDate, pm.`trippayment_id` AS paymentId, pm.`txn_id` AS txnId, IFNULL(gettrippayment_type(b.`tripbooking_id`),'pending Payment') as paymentType, pm.`amount` FROM sg_trippaymentdetails pm RIGHT JOIN sg_tripbookingdetails b ON pm.`tripbooking_id`=b.`tripbooking_id`, sg_tripbatches i,sg_tripparticipantdetails p where b.`batch` = i.`tripbatch_id` and b.`tripbooking_id` = p.tripbooking_id order by b.tripbooking_id desc";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $bookingdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($bookingdetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'bookingdeatils' => $bookingdetails
        );
      }else{
        $status = array(
          "status" => "204",
          "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getBooking($data) {
    try {
      extract($data);
      $query = "SELECT p.`name` AS customerName, p.`email` AS email, p.`age` AS age, p.`gender` AS gender, p.`height` AS `height`, p.`weight`, p.`mobile` AS mobile, b.`address` AS billing, b.`state`, b.`city`, DATE_FORMAT(b.`created_date`,'%d %M %Y') AS bookingDate, gettripname(b.`trip_id`) AS tripTitle, Concat(DATE_FORMAT(i.`tripstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`tripend_date`,'%d %M %Y')) AS batchDate, pm.`txn_id` as txnId, IFNULL(gettrippayment_type(b.`tripbooking_id`),'pending Payment') as paymentType, pm.`amount` as amount from sg_trippaymentdetails pm RIGHT JOIN sg_tripbookingdetails b ON pm.`tripbooking_id`=b.`tripbooking_id`, sg_tripbatches i, sg_tripparticipantdetails p   where b.`batch` = i.`tripbatch_id` and b.`tripbooking_id` = p.tripbooking_id and b.tripbooking_id = :tripbooking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripbooking_id',$id);
      $stmt->execute();
      $transactiondetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($transactiondetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'bookingdeatils' => $transactiondetails
        );
      }else{
        $status = array(
          "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getBatchBooking($data) {
    try {
      extract($data);
      $query = "SELECT p.`name` as customerName, p.`mobile`, p.`email`, b.`trip_id`, b.`tripbooking_id` AS tripBookingId, b.`address`, b.`state`, b.`city`, b.`created_date` as bookingDate, gettripname(b.`trip_id`) as tripTitle, gettripparticipantscount(b.`tripbooking_id`) as personCnt, i.`tripstart_date` AS tripStartDate, i.`tripend_date` AS tripEndDate, pm.`trippayment_id` AS tripPaymentId, pm.`original_amount` AS originalAmount, pm.`txn_id` AS txnId, gettrippayment_type(b.`tripbooking_id`) AS paymentType, pm.`amount` from sg_trippaymentdetails pm RIGHT JOIN sg_tripbookingdetails b ON pm.`tripbooking_id`=b.`tripbooking_id`, sg_tripbatches i,sg_tripparticipantdetails p  where b.`batch` = i.`tripbatch_id` and b.`tripbooking_id` = p.tripbooking_id and i.`tripbatch_id` = :batch_id and pm.`trippayment_id` = (SELECT max(trippayment_id) FROM sg_trippaymentdetails where tripbooking_id =b.tripbooking_id) order by b.tripbooking_id desc";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':batch_id',$id);
      $stmt->execute();
      $bookingdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($bookingdetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'batch_bookingdeatils' => $bookingdetails
        );
      }else{
        $status = array(
          "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getParticipants($data) {
    try {
      extract($data);
      $query = "SELECT `tripparticipant_id` AS tripParticipantId, `name`, `email`, `mobile`, `age`, `gender`, `height`, `weight`, `tripbooking_id` AS tripBookingId, `created_date` AS createdDate from sg_tripparticipantdetails where tripbooking_id=:tripbooking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripbooking_id',$booking_id);
      $stmt->execute();
      $participantdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($participantdetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'participantdetails' => $participantdetails
        );
      }else{
        $status = array(
          "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getTransactions() {
    try {
      $query = "SELECT b.`trip_id` AS tripId, b.`tripbooking_id` AS tripBookingId, b.`address`, b.`city`, b.`state`, gettripparticipantscount(b.`tripbooking_id`) AS personsCnt, pm.`trippayment_id` AS tripPaymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` AS amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as bookingDate, gettripname(b.`trip_id`) AS tripTitle, ib.`tripstart_date` AS tripStartDate, ib.`tripend_date` AS tripEndDate, bb.`buyer_name` AS customerName, bb.`phone` AS mobile, bb.`email` FROM sg_tripbeforebookingdetails bb,sg_tripbatches ib,sg_trippaymentdetails pm inner join sg_tripbookingdetails b on pm.`tripbooking_id` = b.`tripbooking_id` where ib.`tripbatch_id`=b.`batch` and bb.`tripbooking_id` = b.`tripbooking_id` order by pm.`trippayment_id` desc";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $transactiondetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($transactiondetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'transactiondetails' => $transactiondetails
       );
      }else{
        $status = array(
          "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getTransaction($data) {
    try {
      extract($data);
      $query = "SELECT b.`trip_id` AS tripId, b.`tripbooking_id` AS tripBookingId, b.`address` AS address, b.`city` AS city, b.`state` AS state, getparticipantscount(b.`tripbooking_id`) AS personsCnt, pm.`trippayment_id` AS tripPaymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` AS amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as bookingDate, gettripname(b.`trip_id`) as tripTitle,Concat(DATE_FORMAT(ib.`tripstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(ib.`tripend_date`,'%d %M %Y')) as tripBatch,bb.`buyer_name` as customerName,bb.`phone` as mobile,bb.`email` as email,getcutomergender(b.`tripbooking_id`) as gender FROM sg_tripbeforebookingdetails bb,sg_tripbatches ib,sg_trippaymentdetails pm inner join sg_tripbookingdetails b on pm.`tripbooking_id` = b.`tripbooking_id` where ib.`tripbatch_id`=b.`batch` and bb.`tripbooking_id` = b.`tripbooking_id` and  b.`tripbooking_id`=:tripbooking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripbooking_id',$id);
      $stmt->execute();
      $transactiondetail = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($transactiondetail)){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'transactiondetail' => $transactiondetail
       );
      }else{
        $status = array(
          "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function addBikeRentals($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_triprentalitems(`item_title`,item_cost,trip_id,status,created_date,created_by)values(:item_title,:item_cost ,:trip_id,:status,:created_date,:created_by)";
      $created_date = date("Y-m-d H:i:s"); 
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':item_title', $item_title);
      $stmt->bindParam(':item_cost', $item_cost);
      $stmt->bindParam(':trip_id', $trip_id);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $created_by);
      $res = $stmt->execute();
      $bikerental_id = $this->connection->lastInsertId();
      if($bikerental_id!='' && $bikerental_id!='0')
      {
        $status = array(
          'status' => ERR_OK,
          'message' => "biketrip rental Added Successfully",
          'bikerental_id' => $bikerental_id);
      }
      else
      {
        $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure Not Added Successfully");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function deleteIterinary($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_tripitinerary SET recordstatus='9' where tripitinerary_id=:tripitinerary_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tripitinerary_id',$id);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getTripFee($data) {
    try {
      extract($data);
      $query = "SELECT t.`biketrips_id` AS tripId, t.`trip_title` AS tripTitle, t.`trip_fee` AS tripFee, t.status, t.trip_discount AS tripDiscount FROM sg_biketrips t WHERE t.biketrips_id = :biketrips_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':biketrips_id', $biketrip_id);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);      
      if(!empty($results)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'tripfee' => $results);
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateTripFee($data) {
    try {
      extract($data);
      $query = "UPDATE sg_biketrips SET trip_fee = :trip_fee, trip_discount=:trip_discount WHERE biketrips_id = :biketrips_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trip_fee',$tripFees);
      $stmt->bindParam(':trip_discount',$tripDiscount);
      $stmt->bindParam(':biketrips_id',$id);
      $res=$stmt->execute();
      if($res='true'){
        $status = array(
          'status' => ERR_OK,
          'message' => "Success");
      }else{
        $status = array(
          'status' => ERR_NOT_MODIFIED,
          'message' => "Failure");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function addOrganizer($data) {
    try {
      extract($data);
      if(empty($id)||empty($selectOrg)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
      else{
        $query = "INSERT INTO sg_triporganizersmap (organizer_id, trip_id, status, created_date, created_by) VALUES(:organizer_id, :trip_id, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':organizer_id', $selectOrg);
        $stmt->bindParam(':trip_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $triporganizer_id = $this->connection->lastInsertId();
        if($triporganizer_id!='' && $triporganizer_id!='0'){
          $status = array(
            'status' => ERR_OK,
            'message' => 'Trip Organizer Added Successfully',
            'triporganizer_id' => $triporganizer_id);
          
        }else{
           $status = array(
                    'status' => ERR_NOT_MODIFIED,
                    'message' => "Not Added Successfully"
                );
        }
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getOrganizerDetails($data) {
    try {
      extract($data);
      $query = "SELECT organizer_id AS organizerId, org_name AS orgName, org_job AS orgJob, org_mobile AS orgMobile, where_reach AS whereReach, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_triporganizers WHERE organizer_id IN (SELECT organizer_id FROM sg_triporganizersmap WHERE trip_id = $biketrip_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $triporganizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($triporganizers!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'triporganizers' => $triporganizers);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getOrganizerTrips($data) {
    try {
      extract($data);
      $query = "SELECT trip_id AS tripId, gettripname(trip_id) as tripName FROM sg_triporganizersmap WHERE organizer_id='$organizer_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $tripdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($tripdetails!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'tripdetails' => $tripdetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function deleteOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_triporganizersmap SET status='9' where tr_org_id=:tr_org_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tr_org_id',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addTripCoupon($data) {
    try {
      extract($data);
      $tripid = $id;
      $couponid = $selectCoupon;
      if(empty($tripid)||empty($couponid)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
     else{
        $query = "INSERT INTO sg_tripcouponsmap(coupon_id,trip_id, status, created_date, created_by) VALUES(:coupon_id, :trip_id, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':coupon_id', $selectCoupon);
        $stmt->bindParam(':trip_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $tripcoupon_id = $this->connection->lastInsertId();
        if(!empty($tripcoupon_id) && $tripcoupon_id != '0'){
          $status = array(
            'status' => ERR_OK,
            'message' => 'Tripcoupon Added Successfully',
            'tripcoupon_id' => $tripcoupon_id);          
        }else{
           $status = array(
                    'status' => ERR_NOT_MODIFIED,
                    'message' => "Not Added Successfully"
                );
        }
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getTripCoupons($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id AS couponId, coupon_code as couponCode, coupon_name as couponName, valid_from as validFrom, valid_till as validTill, discount_amount AS discount, status, all_trips AS allTrips, coupon_type AS couponType, commision_status AS commisionStatus, commision_date AS commisionDate, commision_remarks AS commisionRemarks, coupon_limit AS couponLimit, coupon_value_limit AS couponValueLimit, coupon_value_decrease AS couponValueDecrease, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_tripcoupons WHERE coupon_id IN (SELECT coupon_id FROM sg_tripcouponsmap
               WHERE trip_id = '$trip_id' and status!='9')";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $tripcoupons  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($tripcoupons)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'tripcoupons' => $tripcoupons);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getCouponTrips($data) {
    try {
      extract($data);
      $query = "SELECT trip_id AS tripId, gettripname(trip_id) AS tripName FROM sg_tripcouponsmap WHERE coupon_id='$coupon_id' AND status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $tripdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($tripdetails != ''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'tripdetails' => $tripdetails);
      }
      else{
        $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function deleteTripCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_tripcouponsmap SET status='9' where tripcoupon_id=:tr_coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tr_coupon_id',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addTripRentals($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_triprentalitems(rentalitem, item_cost,
      tripbatch, trip_id, status, created_date, created_by) VALUES(:rentalitem, :item_cost, :tripbatch, :trip_id, :status, :created_date, :created_by)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':rentalitem', $rentalItem);
      $stmt->bindParam(':item_cost', $itemCost);
      $stmt->bindParam(':tripbatch', $tripBatch);
      $stmt->bindParam(':trip_id', $tripId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $triprental_id = $this->connection->lastInsertId();
      if(!empty($triprental_id) && $triprental_id != '0'){
        $status = array(
          'status' => ERR_OK,
          'message' => 'TripRental Added Successfully',
          'triprental_id' => $triprental_id);        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Not Added Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getTripRentals($data) {
    try {
      extract($data);
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, image_1, image_2, image_3, image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_triprentalitems WHERE trip_id = $trip_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $triprentals  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($triprentals)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'triprentals' => $triprentals);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getRentalTrips($data) {
    try {
      extract($data);
      $query = "SELECT trip_id AS tripId, gettripname(trip_id) AS tripName FROM sg_triprentalitems WHERE rentalitem='$rental_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $tripdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($tripdetails != ''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'tripdetails' => $tripdetails);
      }
      else{
        $status = array('status'=>"204",
          'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBatchRentals($data) {
    try {
      extract($data);
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, image_1, image_2, image_3, image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_triprentalitems WHERE tripbatch = $batch_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $rentaldetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($rentaldetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'rentaldetails' => $rentaldetails);
      }
      else{
        $status = array('status'=>"204",
       'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getTripBatchRental($data) {
    try {
      extract($data);
      $query = "SELECT b.tripbatch_id AS batchId, b.tripstart_date AS tripStartDate, b.tripend_date AS tripEndDate, b.tripbatch_size tripBatchSize, b.tripbatch_status AS tripBatchStatus
                FROM sg_tripbatches b  
                JOIN sg_triprentalitems r
                ON b.tripbatch_id = r.tripbatch";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $tripbatchdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($tripbatchdetails)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'tripbatchdetails' => $tripbatchdetails);
      }
      else{
        $status = array('status'=>"204",
          'message'=>"No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function deleteTripRental($data) {
    try {
      extract($data);
      $query = "UPDATE sg_triprentalitems SET status='9' WHERE triprentalitem_id=:triprentalid";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':triprentalid',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addTripFaq($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_trip_faq`(`trip_id`, `cat_id`, `question`, `answer`, `status`, `created_by`, `created_date`) VALUES(:trip_id, :cat_id, :question, :answer, :status, :created_by, :created_date)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trip_id', $tripId);
      $stmt->bindParam(':cat_id', $catId);
      $stmt->bindParam(':question', $question);
      $stmt->bindParam(':answer', $answer);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $tripfaq_id = $this->connection->lastInsertId();
      if(!empty($tripfaq_id) && $tripfaq_id != '0'){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Trip Faq Added Successfully',
          'tripfaq_id' => $tripfaq_id);        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Not Added Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateTripFaq($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_trip_faq` SET `trip_id` = :trip_id, `cat_id` = :cat_id, `question` = :question, `answer` = :answer, `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trip_id', $tripId);
      $stmt->bindParam(':cat_id', $catId);
      $stmt->bindParam(':question', $question);
      $stmt->bindParam(':answer', $answer);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by',$createdBy);
      $stmt->bindParam(':faq_id',$faqId);
      $res = $stmt->execute();
      if(!empty($res)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Trip Faq Updated Successfully');        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Not Updated Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getFaq($data) {
    try {
      extract($data);
      $query = "SELECT `faq_id` AS faqId, `trip_id` AS tripId, `cat_id` AS catId, `question`, `answer`, `status`, `created_by` AS createdBy, `created_date` AS createdDate, `modified_by` AS modifiedBy, `modified_date` AS modifiedDate FROM `sg_trip_faq` WHERE trip_id = :trip_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trip_id', $trip_id);
      $stmt->execute();
      $faq = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($faq)){
         $status = array(
          'status' => ERR_OK,
          'message' => "Success",
         'faq' => $faq
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateBikeTripStatus($data) {
    try {
      extract($data);
      $query  =  "UPDATE sg_biketrips SET status = :status, modified_date = :modified_date, modified_by = :modified_by WHERE biketrips_id = :biketrips_id";
      $stmt = $this->connection->prepare($query);  
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':biketrips_id',$biketripsId);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => "200",
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Updated Successfully");
        return $status;
      }
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateTripImageStatus($data) {
    try{
      extract($data);
      $query = "UPDATE sg_trip_gallery SET status=:status, modified_date = :modified_date, modified_by = :modified_by where tripimage_id=:tripimage_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':tripimage_id',$imageId);
      $res = $stmt->execute();
      if($res == 'true'){ 
        $status = array(
          'status' => ERR_OK,
          'message' => "Image Updated Successfully");
        return $status;
      } else {
        $status = array(
        'status' => ERR_NOT_MODIFIED,
          'message' => "Error!!Image Not Updated");
        return $status;
      }
    }catch(PDOException $e) {
      $status = array(
        'status' => "500",
        'message' => $e->getMessage()
      );
      return $status;
    }
  }
  public function updateBatchStatus($data) {
    try {
      extract($data);
      $sql  = "UPDATE  sg_tripbatches SET tripbatch_status = :tripbatch_status, modified_date=:modified_date WHERE tripbatch_id = :tripbatch_id";
      $stmt = $this->connection->prepare($sql); 
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':tripbatch_status', $batchStatus);
      $stmt->bindParam(':tripbatch_id', $tripbatchId);
      $stmt->bindParam(':modified_date', $modified_date);
      $res = $stmt->execute();
      if($res=='true'){
        $status = array(
         'status' => ERR_OK,
         'message' => "Updated Successfully");
        return $status;
      }else{
         $status = array(
           'status' => ERR_NOT_MODIFIED,
           'message' => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
  public function updateOrganizerStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_triporganizersmap SET status = :status WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':organizer_id', $organizerId);
      if($stmt->execute()){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success organizer updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure organizer Not updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
  public function updateCouponStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_tripcouponsmap SET status = :status WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':coupon_id', $couponId);
      if($stmt->execute()){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success coupon updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure coupon Not updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
  public function updateTripRentalStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_triprentalitems SET status = :status WHERE triprentalitem_id =:triprentalitem_id ";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':triprentalitem_id ', $itemId );
      if($stmt->execute()){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success rental item updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => ERR_NOT_MODIFIED,
        'message' => "Failure rental item Not updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
  public function updateTripFaqStatus($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_trip_faq` SET `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by',$userBy);
      $stmt->bindParam(':faq_id',$faqId);
      $res = $stmt->execute();
      if(!empty($res)){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Faq Updated Successfully');        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Not Updated Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
      );
      echo json_encode($status);
    }
  }
}