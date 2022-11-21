<?php
namespace App\Domain\Hostels;
use PDO;
/**
* Repository.
*/
class HostelsRepository
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
  public function getHostels(): array
  {      
    try {
      $query = "SELECT `hostel_id` AS hostelId, `hostel_name` AS hostelName, `email`, `mobile`, `landline`, `address`, CONCAT('".UPLOADURL."hostels/', `logo`) AS logo, `location`, `city`, `state`, `status`, `spoc_name` AS spocName, `spoc_number` AS spocNumber, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_hosteldetails";
      $stmt = $this->connection->prepare($query);  
      $stmt->execute();
      $Hostels = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($Hostels)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'Hostels' => $Hostels);
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
  public function getHostelDetails($data) {
    try {
      extract($data);
      $query = "SELECT `hostel_id` AS hostelId, `hostel_name` AS hostelName, `email`, `mobile`, `landline`, `address`, CONCAT('".UPLOADURL."hostels/', `logo`) AS logo, `location`, `city`, `state`, `status`, `spoc_name` AS spocName, `spoc_number` AS spocNumber, `created_date` AS createdDate, `modified_date` AS modifiedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_hosteldetails WHERE hostel_id = :hostel_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);  
      $stmt->bindParam(":hostel_id", $hostel_id); 
      $stmt->execute();
      $hostel = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($hostel)){
        $status = array(
                  'status' => "200",
                  'message' => "Success",
                  'hostel' => $hostel);
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
  public function addHostel($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_hosteldetails SET hostel_name=:hostel_name, email=:email, mobile=:mobile , landline = :landline,  address=:address, logo=:logo, location = :location , city = :city, state = :state,  status =:status, spoc_name=:spoc_name, spoc_number=:spoc_number, created_date=:created_date, created_by = :created_by";
      $stmt = $this->connection->prepare($query);  
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':hostel_name', $hostelName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mobile', $mobile);
      $stmt->bindParam(':landline', $landline);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':logo', $hostelImage);
      $stmt->bindParam(':location', $location);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state' , $state);
      $stmt->bindParam(':status' , $status);
      $stmt->bindParam(':spoc_name', $spocName);
      $stmt->bindParam(':spoc_number', $spocNumber);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $userBy);
      $res = $stmt->execute();
      $hostel_id = $this->connection->lastInsertId();
      if($hostel_id){
        $status = array(
          "status" => "200",
          "message" => "Added Successfully",
          "hostelid" => $hostel_id);
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
  public function updateHostel($data) 
  {
    try {
      extract($data);
      $query = "UPDATE sg_hosteldetails SET hostel_name=:hostel_name, email=:email, mobile=:mobile , landline = :landline, address=:address, logo=:logo, location = :location , city = :city, state = :state,  status =:status, spoc_name=:spoc_name, spoc_number=:spoc_number, modified_date=:modified_date, modified_by = :modified_by WHERE hostel_id = :hostel_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");  
      $stmt->bindParam(':hostel_name', $hostelName);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mobile', $mobile);
      $stmt->bindParam(':landline', $landline);
      $stmt->bindParam(':address', $address);
      $stmt->bindParam(':logo', $hostelImage);
      $stmt->bindParam(':location', $location);
      $stmt->bindParam(':city', $city);
      $stmt->bindParam(':state' , $state);
      $stmt->bindParam(':status' , $status);
      $stmt->bindParam(':spoc_name', $spocName);
      $stmt->bindParam(':spoc_number', $spocNumber);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':hostel_id', $hostelId);
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
  public function addHostelEnquiry($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_hostelenquiries(name,email,mobile,hostel_name,login_user, from_date,to_date , no_persons,created_date)VALUES(:name,:email,:mobile, :hostel_name, :login_user,:from_date,:to_date,:no_persons,:created_date)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':mobile', $mobile);
      $stmt->bindParam(':hostel_name', $hostelName);
      $stmt->bindParam(':login_user' , $loginUser);
      $stmt->bindParam(':from_date', $fromDate);
      $stmt->bindParam(':to_date', $toDate);
      $stmt->bindParam(':no_persons', $noPersons);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->execute();
      $hostelenq_id = $this->connection->lastInsertId();
      if($hostelenq_id!=''){
        $status = array(
          'status' => '200',
          'message' => ' hostel enquery details Added Successfully',
          'hostelenq_id' => $hostelenq_id);
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "hostel enquery Not Added Successfully"
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
  public function addHostelGallery($data) {
    try {
      extract($data);
      $query ="INSERT INTO sg_hostelgallery(image_name,hostel_id, status,created_date, created_by)VALUES(:image_name,:hostel_id,:status,:created_date, :created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':image_name', $hostelImage);
      $stmt->bindParam(':hostel_id', $hostelId);
      $stmt->bindParam(':status' , $status);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$userBy);
      $res=$stmt->execute();
      $hostelgallery_id = $this->connection->lastInsertId();
      if($hostelgallery_id!='' && $hostelgallery_id!='0'){
          $status = array(
          'status' => "200",
          'message' => "Hostel Details Added Successfully",
          'hostelgalleryid' => $hostelgallery_id);
       }
       else{
        $status = array(
          'status' => "304",
          'message' => "Hostel Details Not Added Successfully");
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
  public function getHostelEnquiries() {
    try {
      $sql = "SELECT `hostelenquiry_id` AS id, `name`, `email`, `mobile`, `hostel_name` AS hostelName, `login_user` AS loginUser, `from_date` AS fromDate, `to_date` AS toDate, `no_persons` AS noPersons, `created_date` AS createdDate FROM `sg_hostelenquiries` WHERE 1";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $Hostels = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($Hostels)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'HostelsEnquiries' => $Hostels);
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
  public function getHostelEnquiryId($data) {
    try {
      extract($data);
      $sql = "SELECT `hostelenquiry_id` AS id, `name`, `email`, `mobile`, `hostel_name` AS hostelName, `login_user` AS loginUser, `from_date` AS fromDate, `to_date` AS toDate, `no_persons` AS noPersons, `created_date` AS createdDate FROM `sg_hostelenquiries` WHERE hostelenquiry_id = $id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $Hostels = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($Hostels)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'HostelsEnquiry' => $Hostels);
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
  public function getHostelGallery() {
    try {
      $sql = "SELECT `hostelgallery_id` AS id, CONCAT('".UPLOADURL."hostels/', `image_name`) AS imageName, `hostel_id` AS hostelId, `status`, `modified_date` AS modifiedDate, `created_date` AS createdDate, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM `sg_hostelgallery` WHERE 1";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $Hostels = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($Hostels)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'Hostelsgallery' => $Hostels);
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
  public function updateHostelStatus($data) 
  {
    try {
      extract($data);
      $query = "UPDATE sg_hosteldetails SET status =:status, modified_date=:modified_date, modified_by = :modified_by WHERE hostel_id = :hostel_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");  
      $stmt->bindParam(':status' , $status);
      $stmt->bindParam(':modified_date', $modified_date);
      $stmt->bindParam(':modified_by', $userBy);
      $stmt->bindParam(':hostel_id', $hostelId);
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