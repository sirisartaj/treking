<?php
namespace App\Domain\TravelExperts;
use PDO;
/**
* Repository.
*/
class TravelExpertsRepository
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
  public function getTravelExperts(): array
  {      
    try {
      $query = "SELECT `expert_id` AS expertId, `person_name` AS personName, `person_designation` AS personDesignation, `contact_no` AS contactNo, CONCAT('".UPLOADURL."travelexperts/',`expert_image`)  AS expertImage, `expert_status` AS expertStatus, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_expertdetails";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expertdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($expertdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expertdetails' => $expertdetails);
      }else {
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
  public function addTravelExpert($data) {
    try {
      extract($data);
      $query = "INSERT INTO ".DBPREFIX."_expertdetails SET person_name=:person_name, person_designation=:person_designation, contact_no=:contact_no , expert_image = :expert_image, expert_status = :expert_status , created_date = :created_date, created_by=:created_by";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':person_name', $personName);
      $stmt->bindParam(':person_designation', $personDesignation);
      $stmt->bindParam(':contact_no', $contactNo);
      $stmt->bindParam(':expert_image', $expertImage);
      $stmt->bindParam(':expert_status', $expertStatus);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $userBy);
      $stmt->execute();
      $expert_id = $this->connection->lastInsertId();
      if($expert_id!='')
      {
        $status = array(
          'status' => "200",
          'message' => "Travel Expert Added Successfully",
          'expert_id' => $expert_id);
      }
      else
      {
        $status = array(
        'status' => "304",
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
  public function getTravelExpert($data) {
    try {
      extract($data);
      $query = "SELECT `expert_id` AS expertId, `person_name` AS personName, `person_designation` AS personDesignation, `contact_no` AS contactNo, CONCAT('".UPLOADURL."travelexperts/',`expert_image`) AS expertImage, `expert_status` AS expertStatus, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_expertdetails WHERE expert_id = :expert_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expert_id' , $expert_id);
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      $status = array(
        "status" => "200",
        "message" =>  "Success",
        "expertdetails" => $res);
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateTravelExpert($data) {
    try {
      extract($data);
      $query  = "UPDATE sg_expertdetails SET person_name=:person_name, person_designation=:person_designation, contact_no=:contact_no , expert_image = :expert_image , expert_status = :expert_status ,modified_date = :modified_date, modified_by =:modified_by WHERE expert_id = :expert_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':person_name', $personName);
      $stmt->bindParam(':expert_image', $expertImage);
      $stmt->bindParam(':person_designation', $personDesignation);
      $stmt->bindParam(':contact_no', $contactNo);
      $stmt->bindParam(':expert_status',$expertStatus);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by' ,$userBy);
      $stmt->bindParam(':expert_id', $expertId);
      $res = $stmt->execute();
      if($res)
      {
        $status = array(
          'status' => "200",
          'message' => "Travel Expert Updated Successfully",
          'expert_id' => $expertId);
      }
      else
      {
        $status = array(
        'status' => "304",
        'message' => "Failure Not Updated Successfully");
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
  public function deleteTravelExpert($data) {
    try {
      extract($data);
      $query = "DELETE FROM sg_expertdetails WHERE expert_id = :expert_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expert_id',$expertid);
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
  public function updateTravelExpertStatus($data) {
    try {
      extract($data);
      $query  = "UPDATE sg_expertdetails SET expert_status = :expert_status, modified_date = :modified_date, modified_by =:modified_by WHERE expert_id = :expert_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':expert_status',$expertStatus);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by' ,$userBy);
      $stmt->bindParam(':expert_id', $expertId);
      $res = $stmt->execute();
      if($res)
      {
        $status = array(
          'status' => "200",
          'message' => "Travel Expert Updated Successfully",
          'expert_id' => $expertId);
      }
      else
      {
        $status = array(
        'status' => "304",
        'message' => "Failure Not Updated Successfully");
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