<?php
namespace App\Domain\ContactUs;
use PDO;
/**
* Repository.
*/
class ContactRepository
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
  public function getContactUs(): array
  {      
    try {
      $sql = "SELECT `contactus_id` AS contactusId, `first_address` AS firstAddress, `second_address` AS secondAddress, `first_contact` AS firstContact, `second_contact` AS secondContact, `website`, `map`, `modified_date` AS modifiedDate, `modified_by` AS modifiedBy FROM sg_contactus";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $contact = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($contact)){
       $status = array(
         'status' =>ERR_OK,
         'message' =>"Success",
         'contact' => $contact);
        return $status;
      }else{
        $status = array('status'=>ERR_NO_DATA,
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
  public function updateContactUs($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE sg_contactus SET first_contact=:first_contact, second_contact=:second_contact, website = :website, first_address=:first_address, map=:map, modified_date=:modified_date, modified_by = :modified_by, email=:email WHERE contactus_id = :contactus_id";
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':first_contact', $firstContact);
      $stmt->bindParam(':second_contact', $secondContact);
      $stmt->bindParam(':website', $website);
      $stmt->bindParam(':first_address', $firstAddress);
      $stmt->bindParam(':map', $map);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':contactus_id', $contactusId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Not Updated Successfully");
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
  public function getEnqInfo() {
    try {
      $query = "SELECT `form_id` AS formId, `region`, `skill_level` AS skillLevel, `month`, `person_name` AS personName, `duration`, `person_email` AS personEmail, `person_contact` AS personContact, `created_date` AS createdDate FROM sg_searchformdetails";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'enqdetails' => $results);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
       'message'=>"Failure");
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
  public function getTrekBookingEnq() {
    try {
      $query = "SELECT `name`,`mobile`,`email`,`trek_name` AS trekName,`plan_trek_dates` AS planTrekDates,`no_persons` AS noPersons, `comments`,`created_date` as enquiryDate FROM sg_trekbookingenquiries";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'enqdetails' => $results);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
       'message'=>"No data found");
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
  public function getInTouchDetails() {
    try {
      $query = "SELECT `contactin_id` AS contactinId, `name`, `mobile`, `email`, `subject`, `message`, `created_date` AS createdDate  FROM sg_getincontacts";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'getintouchdetails' => $results);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
       'message'=>"Failure");
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
  public function getSubscribers() {
    try {
      $sql = "SELECT `subscribe_id` AS subscribeId, `subscribe_email` AS subscribeEmail, `created_date` AS createdDate FROM sg_subscribemails";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'emails' => $results);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
       'message'=>"Failure");
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