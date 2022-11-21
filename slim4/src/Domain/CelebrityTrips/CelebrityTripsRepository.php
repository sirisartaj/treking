<?php
namespace App\Domain\CelebrityTrips;
use PDO;
/**
* Repository.
*/
class CelebrityTripsRepository
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
  public function getCelebrityTrips(): array
  {      
    try {
      $query = "SELECT `celebritytrip_id` AS celebritytripId, `trip_title` AS tripTitle, `trip_days` AS tripDays, `trip_nights` AS tripNights, `trip_fee` AS tripFee, `trip_overview` AS tripOverview, `celebrity_name` AS celebrityName, CONCAT('".UPLOADURL."celebritytrips/',`trip_image`) AS tripImage, CONCAT('".UPLOADURL."celebritytrips/',`trip_pagebanner`)  AS tripPagebanner, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_celebritytrip";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $celebritytrips  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($celebritytrips!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'celebritytrips' => $celebritytrips);
      }else {
        $status = array(
          "status" => ERR_NO_DATA,
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
  public function getTripEnquiries(): array
  {      
    try {
      $query = "SELECT `tripenq_id` AS tripEnqId, `name`, `email`, `mobile`, `city`, `state`, `no_persons` AS noPersons, `created_date` AS createdDate  FROM sg_celebritytripenquiry";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $celebritytrips  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($celebritytrips!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'celebritytrips' => $celebritytrips);
      }else {
        $status = array(
          "status" => ERR_NO_DATA,
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
  public function addTrip($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_celebritytrip SET trip_title=:trip_title, trip_days=:trip_days , trip_nights = :trip_nights, trip_fee = :trip_fee, trip_overview = :trip_overview,   celebrity_name = :celebrity_name, trip_image = :trip_image, trip_pagebanner = :trip_pagebanner, status = :status, created_date = :created_date, created_by = :created_by";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':trip_title', $tripTitle);
      $stmt->bindParam(':trip_days', $tripDays);
      $stmt->bindParam(':trip_nights', $tripNights);
      $stmt->bindParam(':trip_fee', $tripFee);
      $stmt->bindParam(':trip_overview', $tripOverview);
      $stmt->bindParam(':celebrity_name', $celebrityName);
      $stmt->bindParam(':trip_image', $celebritytripImage);
      $stmt->bindParam(':trip_pagebanner', $tripPagebanner);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $createdBy);
      $stmt->execute();
      $celeb_id = $this->connection->lastInsertId();
      if($celeb_id!='' && $celeb_id!='0')
      {
        $data1['description'] = $description;
        $data1['title'] = @$title;
        $count = 0;
        foreach($data1 as $value){
          $count = sizeof($value); 
        } 
        for($x=0;$x<$count;$x++){
          $query2 = "INSERT INTO sg_celbtripitinerary SET title=:title, description=:description , celbtrip_id = :celbtrip_id,created_date = :created_date";
          $stmt2 = $this->connection->prepare($query2);
          $stmt2->bindParam(':title', $data1['title'][$x]);
          $stmt2->bindParam(':description', $data1['description'][$x]);
          $stmt2->bindParam(':celbtrip_id', $celeb_id);
          $stmt2->bindParam(':created_date', $created_date);
          $stmt2->execute();
        }
         $celbtripitinerary_id = $this->connection->lastInsertId();
         if($celbtripitinerary_id != ''){
            $status = array(
            'status' => ERR_OK,
            'message' => "Trips Details Added Successfully",
            'celbtripitineraryid' => $celbtripitinerary_id);
         }
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
  public function getCelebrityTrip($data) {
    try {
      extract($data);
      $query = "SELECT `celebritytrip_id` AS celebritytripId, `trip_title` AS tripTitle, `trip_days` AS tripDays, `trip_nights` AS tripNights, `trip_fee` AS tripFee, `trip_overview` AS tripOverview, `celebrity_name` AS celebrityName, CONCAT('".UPLOADURL."celebritytrips/',`trip_image`) AS tripImage, CONCAT('".UPLOADURL."celebritytrips/',`trip_pagebanner`) AS tripPagebanner, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_celebritytrip WHERE celebritytrip_id = :celebritytrip_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':celebritytrip_id' , $trip_id);
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      $status = array(
        "status" => ERR_OK,
        "message" =>  "Success",
        "celebritytrips" => $res);
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateTrip($data) {
    try {
      extract($data);
      $query = "UPDATE sg_celebritytrip SET trip_title=:trip_title, trip_days=:trip_days, trip_nights = :trip_nights, trip_fee = :trip_fee, trip_overview = :trip_overview,  celebrity_name = :celebrity_name, trip_image = :trip_image, trip_pagebanner = :trip_pagebanner, status = :status, modified_date = :modified_date, modified_by=:modified_by where celebritytrip_id = :celebritytrip_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':trip_title', $tripTitle);
      $stmt->bindParam(':trip_days', $tripDays);
      $stmt->bindParam(':trip_nights', $tripNights);
      $stmt->bindParam(':trip_fee', $tripFee);
      $stmt->bindParam(':trip_overview', $tripOverview);
      $stmt->bindParam(':celebrity_name', $celebrityName);
      $stmt->bindParam(':trip_image', $celebritytripImage);
      $stmt->bindParam(':trip_pagebanner', $tripPagebanner);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':celebritytrip_id', $celebritytripId);
      $res = $stmt->execute();
      if($res){
        $data1['description'] = $description;
        $data1['title'] = @$title;
        $data1['id'] = $celbtripitineraryId;
        $count = 0;
        foreach($data1 as $value){
          $count = sizeof($value); 
        } 
        for($x=0;$x<$count;$x++){
          $id = @$data1['id'][$x];
          if(@$id){
            $query2 = "UPDATE sg_celbtripitinerary SET title=:title, description=:description ,modified_date = :modified_date where celbtripitinerary_id = :celbtripitinerary_id";
            $stmt2 = $this->connection->prepare($query2);
            $stmt2->bindParam(':title', $data1['title'][$x]);
            $stmt2->bindParam(':description', $data1['description'][$x]);
            $stmt2->bindParam(':modified_date', $modified_date);
            $stmt2->bindParam(':celbtripitinerary_id', $id);
            $stmt2->execute();
          }
          else {
            $query3 = "INSERT INTO sg_celbtripitinerary SET title=:title, description=:description , celbtrip_id = :celbtrip_id,created_date = :created_date";
            $stmt3 = $this->connection->prepare($query3);          
            $stmt3->bindParam(':title', $data1['title'][$x]);
            $stmt3->bindParam(':description', $data1['description'][$x]);
            $stmt3->bindParam(':celbtrip_id', $celebritytripId);
            $stmt3->bindParam(':created_date', $modified_date);
            $stmt3->execute();
          }
        }
        $status = array(
          'status' => ERR_OK,
          'message' => "Successfully Updated");
      }else{
        $status = array(
          'status' => ERR_NOT_MODIFIED,
          'message' => "celebritytrips Not Updated Successfully");
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
  public function updateTripStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_celebritytrip SET status = :status, modified_date = :modified_date, modified_by=:modified_by where celebritytrip_id = :celebritytrip_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':celebritytrip_id', $celebritytripId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          'status' => ERR_OK,
          'message' => "Successfully Updated");
      }else{
        $status = array(
          'status' => ERR_NOT_MODIFIED,
          'message' => "celebritytrips Not Updated Successfully");
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
}