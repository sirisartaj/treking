<?php
namespace App\Domain\Leads;
use PDO;
/**
* Repository.
*/
class LeadsRepository
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
  public function getLeads(): array
  {      
    try {
      $query = "SELECT `lead_id` AS leadId, `customer_name` AS customerName, `email`, `mobile`, `country`, `city`, `state`, `followup_date` AS followupDate, `executive`, `comments`, `status`, `created_date` AS createdDate, `modified_date` As modifiedDate, `alternate_mobile` As alternateMobile, `looking_category` AS lookingCategory, `looking_for` AS lookingFor, `when_date` AS whenDate, `how_did_hear_us` AS howDidHearUs, `lead_source` AS leadSource, `last_join_with_us` AS lastJoinWithUs, `last_enq_about` AS lastEnqAbout, `total_trips` AS totalTrips, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM `sg_leaddetails` WHERE 1";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'leads' => $res);
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
  public function getLead($data) {
    try {
      extract($data);
      $query =  "SELECT `lead_id` AS leadId, `customer_name` AS customerName, `email`, `mobile`, `country`, `city`, `state`, `followup_date` AS followupDate, `executive`, `comments`, `status`, `created_date` AS createdDate, `modified_date` As modifiedDate, `alternate_mobile` As alternateMobile, `looking_category` AS lookingCategory, `looking_for` AS lookingFor, `when_date` AS whenDate, `how_did_hear_us` AS howDidHearUs, `lead_source` AS leadSource, `last_join_with_us` AS lastJoinWithUs, `last_enq_about` AS lastEnqAbout, `total_trips` AS totalTrips, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM sg_leaddetails WHERE lead_id = :lead_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);  
      $stmt->bindParam(":lead_id", $lead_id); 
      $stmt->execute();
      $leaddetails = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($leaddetails)){
        $status = array(
                  'status' => "200",
                  'message' => "Success",
                  'lead' => $leaddetails);
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
  public function addLead($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_leaddetails`(`customer_name`, `email`, `mobile`, `country`, `city`, `state`, `followup_date`, `executive`, `comments`, `status`, `created_date`, `alternate_mobile`, `looking_category`, `looking_for`, `when_date`, `how_did_hear_us`, `lead_source`, `last_join_with_us`, `last_enq_about`, `total_trips`, `created_by`) VALUES(:customer_name, :email, :mobile, :country, :city, :state, :followup_date,:executive, :comments, :status, :created_date, :alternate_mobile, :looking_category, :looking_for, :when_date, :how_did_hear_us, :lead_source, :last_join_with_us, :last_enq_about, :total_trips, :created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':customer_name', $customerName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mobile', $mobile);
      $stmt->bindParam(':country',$country);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state' ,$state);
      $stmt->bindParam(':followup_date', $followupDate);
      $stmt->bindParam(':executive', $executive);
      $stmt->bindParam(':comments', $comments);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':alternate_mobile', $alternateMobile);
      $stmt->bindParam(':looking_category' ,$lookingCategory);
      $stmt->bindParam(':looking_for', $lookingFor);
      $stmt->bindParam(':when_date', $whenDate);
      $stmt->bindParam(':how_did_hear_us', $howDidHearUs);
      $stmt->bindParam(':lead_source', $leadSource);
      $stmt->bindParam(':last_join_with_us', $lastJoinWithUs);
      $stmt->bindParam(':last_enq_about', $lastEnqAbout);
      $stmt->bindParam(':total_trips', $totalTrips);
      $stmt->bindParam(':created_by', $createdBy);
      $stmt->execute();
      $lead_id = $this->connection->lastInsertId();
      if($lead_id){
        $status = array(
          "status" => "200",
          "message" => "Added Successfully",
          'lead_id' => $lead_id);
        return $status;
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Added Successfully");
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
  public function updateLead($data) 
  {
    try {
      extract($data);
      $query = "UPDATE sg_leaddetails SET customer_name=:customer_name, email=:email, mobile=:mobile ,country = :country,  city = :city, state = :state,followup_date =:followup_date, executive = :executive, comments=:comments, status = :status, modified_date=:modified_date, `alternate_mobile`=:alternate_mobile, `looking_category` =:looking_category, `looking_for` =:looking_for, `when_date` = :when_date, `how_did_hear_us` =:how_did_hear_us, `lead_source` = :lead_source, `last_join_with_us` = :last_join_with_us, `last_enq_about` = :last_enq_about, `total_trips` =:total_trips, modified_by = :modified_by WHERE lead_id=:lead_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':customer_name', $customerName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mobile', $mobile);
      $stmt->bindParam(':country',$country);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state' ,$state);
      $stmt->bindParam(':followup_date', $followupDate);
      $stmt->bindParam(':executive', $executive);
      $stmt->bindParam(':comments', $comments);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':alternate_mobile', $alternateMobile);
      $stmt->bindParam(':looking_category' ,$lookingCategory);
      $stmt->bindParam(':looking_for', $lookingFor);
      $stmt->bindParam(':when_date', $whenDate);
      $stmt->bindParam(':how_did_hear_us', $howDidHearUs);
      $stmt->bindParam(':lead_source', $leadSource);
      $stmt->bindParam(':last_join_with_us', $lastJoinWithUs);
      $stmt->bindParam(':last_enq_about', $lastEnqAbout);
      $stmt->bindParam(':total_trips', $totalTrips);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by', $modifiedBy);
      $stmt->bindParam(':lead_id', $leadId);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function addLeadFollowup($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_leadfollowups`(`lead_id`, `followup_by`, `followup_date`, `comments`, `followup_status`, `created_date`, `created_by`, `followup_type`, `next_followup`, `status`) VALUES (:lead_id, :followup_by, :followup_date, :comments, :followup_status, :created_date, :created_by, :followup_type, :next_followup, :status)";
      $stmt = $this->connection->prepare($query);
      $createdDate = date("Y-m-d H:i:s");
      $stmt->bindParam(':lead_id', $leadId);
      $stmt->bindParam(':followup_by', $followupBy);
      $stmt->bindParam(':followup_date', $followupDate);
      $stmt->bindParam(':comments', $comments);
      $stmt->bindParam(':followup_status',$followupStatus);
      $stmt->bindParam(':created_date',$createdDate);
      $stmt->bindParam('created_by',$createdBy);
      $stmt->bindParam(':followup_type', $followupType);
      $stmt->bindParam(':next_followup', $nextFollowup);
      $stmt->bindParam(':status', $status);
      $stmt->execute();
      $followup_id = $this->connection->lastInsertId();
      if($followup_id!='' && $followup_id != '0'){
        $status = array(
          'status' => '200',
          'message' => ' leadfollowup details Added Successfully',
          'followup_id' => $followup_id);
      }else{
         $status = array(
                  'status' => "304",
                  'message' => "Lead Not Added Successfully"
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
  public function getLeadFollowups($data) {
    try {
      extract($data);
      $query = "SELECT l.`customer_name` AS customerName, l.`email`,l.`mobile`,l.`country`,l.`status`,lf.`followup_by` AS followupBy,lf.`followup_date` AS followupDate,lf.`comments`,lf.`followup_status` AS followupStatus, lf.next_followup AS nextFollowup, lf.followup_type AS followupType FROM sg_leaddetails l inner join sg_leadfollowups lf on l.`lead_id` = lf.`lead_id` WHERE l.`lead_id` = :lead_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':lead_id', $lead_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (!empty($res))
      {
        $status = array(
                'status' => "200",
                'message' => "success",
                'followups'=>$res
            );
      }else{
          $status = array(
              'status' => "204",
              'message' => "No data found"
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
  public function deleteLead($data) {
    try {
      extract($data);
      $query = "UPDATE sg_leaddetails SET status = '9', modified_date=:modified_date WHERE lead_id=:lead_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':lead_id', $lead_id);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function getFollowupDetails($data) {
    try {
      extract($data);
      $query = "SELECT lf.`followup_by` AS followupBy,lf.`followup_date` AS followupDate,lf.`comments`,lf.`followup_status` AS followupStatus, lf.next_followup AS nextFollowup, lf.followup_type AS followupType, lf.created_date AS createdDate, lf.created_by AS createdBy FROM  sg_leadfollowups lf WHERE lf.`leadfollowup_id` = :leadfollowup_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':leadfollowup_id', $followup_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (!empty($res))
      {
        $status = array(
                'status' => "200",
                'message' => "success",
                'followup'=>$res
            );
      }else{
          $status = array(
              'status' => "204",
              'message' => "No data found"
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
  public function updateLeadFollowup($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_leadfollowups` SET `followup_by`=:followup_by,`followup_date`=:followup_date,`comments`=:comments,`followup_status`=:followup_status,`followup_type`=:followup_type,`next_followup`=:next_followup,`status`=:status WHERE leadfollowup_id=:leadfollowup_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':followup_by', $followupBy);
      $stmt->bindParam(':followup_date', $followupDate);
      $stmt->bindParam(':comments', $comments);
      $stmt->bindParam(':followup_status',$followupStatus);
      $stmt->bindParam(':followup_type', $followupType);
      $stmt->bindParam(':next_followup', $nextFollowup);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':leadfollowup_id', $leadfollowupId);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function deleteLeadFollowup($data) {
    try {
      extract($data);
      $query = "UPDATE sg_leadfollowups SET status = '9'  WHERE leadfollowup_id=:leadfollowup_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
     //$stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':leadfollowup_id', $followup_id);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function getUpcomingFollowups() {
    try {
      $query = "SELECT l.`customer_name` AS customerName, l.`email`,l.`mobile`,l.`country`,l.`status`,lf.`followup_by` AS followupBy,lf.`followup_date` AS followupDate,lf.`comments`,lf.`followup_status` AS followupStatus, lf.next_followup AS nextFollowup, lf.followup_type AS followupType FROM sg_leaddetails l inner join sg_leadfollowups lf on l.`lead_id` = lf.`lead_id` WHERE lf.`next_followup` >= NOW() AND lf.status != '9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (!empty($res))
      {
        $status = array(
                'status' => "200",
                'message' => "success",
                'upcoming_followups'=>$res
            );
      }else{
          $status = array(
              'status' => "204",
              'message' => "No data found"
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
  public function updateLeadStatus($data) 
  {
    try {
      extract($data);
      $query = "UPDATE sg_leaddetails SET status = :status, modified_date=:modified_date, modified_by = :modified_by WHERE lead_id=:lead_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':lead_id', $leadId);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateLeadFollowupStatus($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_leadfollowups` SET `status`=:status WHERE leadfollowup_id=:leadfollowup_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':leadfollowup_id', $leadfollowupId);
      $res = $stmt->execute();
      if($res){
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}