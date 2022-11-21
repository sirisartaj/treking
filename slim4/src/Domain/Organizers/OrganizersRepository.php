<?php
namespace App\Domain\Organizers;
use PDO;
/**
* Repository.
*/
class OrganizersRepository
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
  public function getOrganizers(): array
  {      
    try{
      $query = "SELECT organizer_id as id, org_name as name, org_job as designation, org_mobile as mobile, where_reach AS whereReach, org_email as email, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_trekorganizers WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $organizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($organizers!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'organizers' => $organizers);
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
  public function addOrganizer($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_trekorganizers(org_name,org_job,org_mobile,where_reach,
      status,org_email,created_date,created_by)VALUES(:org_name,:org_job,:org_mobile,:where_reach,:status,:org_email,:created_date,:created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by' ,$userBy);
      $stmt->execute();
      $organizer_id = $this->connection->lastInsertId();
      if($organizer_id!=''){
        $status = array(
          'status' => '200',
          'message' => 'Organizer Added Successfully',
          'organizer_id' => $organizer_id);
      }else{
        $status = array(
                'status' => "304",
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
  public function checkOrganizer($mobile) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM " . DBPREFIX . "_trekorganizers where `org_mobile`='$mobile'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getOrganizer($data) {
    try {
      extract($data);
      $query ="SELECT organizer_id,org_name as organiserName ,org_job as designation,org_mobile as mobileNumber,where_reach as whereTo, org_email as email,status,created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_trekorganizers WHERE organizer_id = :organizer_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':organizer_id', $organizer_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
          $status = array(
          "status" => "200",
          "message" =>  "Success",
          "organozerdetails" => $res);
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
  public function checkOrgMobile($mobileNumber, $id) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM " .DBPREFIX. "_trekorganizers where `org_mobile`='$orgmobile'and organizer_id!='$orgid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekorganizers SET org_name=:org_name, org_job=:org_job, org_mobile=:org_mobile, where_reach = :where_reach,org_email=:org_email, status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
  public function deleteOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_trekorganizers SET status='9' where organizer_id=:organizer_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':organizer_id',$organizer_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Organizer Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Organizer Not Deleted Successfully");
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
  public function updateOrganizerStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekorganizers SET status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
  /*
  *Trip Organizers
  */
  public function getTripOrganizers(): array
  {      
    try{
      $query = "SELECT organizer_id as id, org_name as name, org_job as designation, org_mobile as mobile, where_reach AS whereReach, org_email as email, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_triporganizers WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $organizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($organizers!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'organizers' => $organizers);
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
  public function addTripOrganizer($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_triporganizers(org_name,org_job,org_mobile,where_reach,
      status,org_email,created_date,created_by)VALUES(:org_name,:org_job,:org_mobile,:where_reach,:status,:org_email,:created_date,:created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by' ,$userBy);
      $stmt->execute();
      $organizer_id = $this->connection->lastInsertId();
      if($organizer_id!=''){
        $status = array(
          'status' => '200',
          'message' => 'Organizer Added Successfully',
          'organizer_id' => $organizer_id);
      }else{
        $status = array(
                'status' => "304",
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
  public function checkTripOrganizer($mobile) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM sg_triporganizers where `org_mobile`='$mobile'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getTripOrganizer($data) {
    try {
      extract($data);
      $query ="SELECT organizer_id,org_name as organiserName ,org_job as designation,org_mobile as mobileNumber,where_reach as whereTo, org_email as email,status,created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_triporganizers WHERE organizer_id = :organizer_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':organizer_id', $organizer_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
          $status = array(
          "status" => "200",
          "message" =>  "Success",
          "organozerdetails" => $res);
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
  public function checkTripOrgMobile($mobileNumber, $id) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM sg_triporganizers where `org_mobile`='$orgmobile'and organizer_id!='$orgid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateTripOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_triporganizers SET org_name=:org_name, org_job=:org_job, org_mobile=:org_mobile, where_reach = :where_reach,org_email=:org_email, status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
  public function deleteTripOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_triporganizers SET status='9' where organizer_id=:organizer_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':organizer_id',$organizer_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Organizer Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Organizer Not Deleted Successfully");
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
  public function updateTripOrganizerStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_triporganizers SET status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
  /*
  *Expedition Organizers
  */
  public function getExpeditionOrganizers(): array
  {      
    try{
      $query = "SELECT organizer_id as id, org_name as name, org_job as designation, org_mobile as mobile, where_reach AS whereReach, org_email as email, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_expeditionorganizers WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $organizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($organizers!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'organizers' => $organizers);
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
  public function addExpeditionOrganizer($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_expeditionorganizers(org_name,org_job,org_mobile,where_reach,
      status,org_email,created_date,created_by)VALUES(:org_name,:org_job,:org_mobile,:where_reach,:status,:org_email,:created_date,:created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by' ,$userBy);
      $stmt->execute();
      $organizer_id = $this->connection->lastInsertId();
      if($organizer_id!=''){
        $status = array(
          'status' => '200',
          'message' => 'Organizer Added Successfully',
          'organizer_id' => $organizer_id);
      }else{
        $status = array(
                'status' => "304",
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
  public function checkExpeditionOrganizer($mobile) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM sg_expeditionorganizers where `org_mobile`='$mobile'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getExpeditionOrganizer($data) {
    try {
      extract($data);
      $query ="SELECT organizer_id,org_name as organiserName ,org_job as designation,org_mobile as mobileNumber,where_reach as whereTo, org_email as email,status,created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_expeditionorganizers WHERE organizer_id = :organizer_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':organizer_id', $organizer_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
          $status = array(
          "status" => "200",
          "message" =>  "Success",
          "organozerdetails" => $res);
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
  public function checkExpeditionOrgMobile($mobileNumber, $id) {
    try {
      $sql = "SELECT count(`organizer_id`) as cnt FROM sg_expeditionorganizers where `org_mobile`='$orgmobile'and organizer_id!='$orgid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function updateExpeditionOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditionorganizers SET org_name=:org_name, org_job=:org_job, org_mobile=:org_mobile, where_reach = :where_reach,org_email=:org_email, status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':org_name', $organiserName);
      $stmt->bindParam(':org_job', $designation);
      $stmt->bindParam(':where_reach', $whereTo);
      $stmt->bindParam(':org_mobile', $mobileNumber);
      $stmt->bindParam(':org_email', $email);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
  public function deleteExpeditionOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditionorganizers SET status='9' where organizer_id=:organizer_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':organizer_id',$organizer_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Organizer Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Organizer Not Deleted Successfully");
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
  public function updateExpeditionOrganizerStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditionorganizers SET status = :status, modified_date = :modified_date,modified_by=:modified_by WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':organizer_id', $id);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Organizer Updated Successfully");         
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Organizer Not Updated Successfully"
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
}