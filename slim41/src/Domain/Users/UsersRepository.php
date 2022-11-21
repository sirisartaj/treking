<?php
namespace App\Domain\Users;
use PDO;
/**
* Repository.
*/
class UsersRepository
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
  public function getUsers(): array
  {      
    try {
      $sql = "SELECT user_id , user_mobile,user_email,user_fname,user_lname,user_gender,user_dob,user_level,user_avatar,user_create,lastlogin,user_status,modified_date, created_by AS createdBy, modified_by AS modifiedBy FROM  sg_users";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $users = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($users)){
       $status = array(
         'status' =>ERR_OK,
         'message' =>"Success",
         'users' => $users);
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
  public function getuser($data) {
    try {
      extract($data);
      $sql = "SELECT user_id , user_mobile,user_email,user_fname,user_lname,user_gender,user_dob,user_level,user_avatar,user_create,lastlogin,user_status,modified_date, created_by AS createdBy, modified_by AS modifiedBy FROM ".DBPREFIX."_users WHERE user_id=:user_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":user_id", $userId); 
      $stmt->execute();
      $userdetails = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($userdetails)){
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success",
                  'user' => $userdetails);
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
  public function deleteuser($data) {    
    try {
      $sql = "DELETE FROM ".DBPREFIX."users WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":user_id",$userId);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => ERR_OK,
          "message" => "Deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
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
  public function addUser($data) {
    try {      
      extract($data);
      $sql = "INSERT INTO ".DBPREFIX."_users SET user_fname=:user_fname, user_lname=:user_lname ,user_gender=:user_gender,user_mobile=:user_mobile,user_email=:user_email,user_password=:user_password,temp_password=:temp_password,user_dob=:user_dob,user_level=:user_level, user_avatar = :user_avatar,user_create=:user_create,lastlogin=:lastlogin, user_status = :user_status , created_by = :created_by";
      $stmt = $this->connection->prepare($sql);  
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(":user_fname", $user_fname); 
      $stmt->bindParam(":user_lname", $user_lname); 
      $stmt->bindParam(":user_avatar", $user_avatar);
      $stmt->bindParam(":user_gender", $user_gender);
      $stmt->bindParam(":user_mobile", $user_mobile);
      $stmt->bindParam(":user_email", $user_email);
      $stmt->bindParam(":user_password", $user_password);
      $stmt->bindParam(":temp_password", $temp_password);
      $stmt->bindParam(":user_dob", $user_dob);
      $stmt->bindParam(":user_level", $user_level);
      $stmt->bindParam(":lastlogin", $lastlogin);
      $stmt->bindParam(":user_status", $user_status);
      $stmt->bindParam(':user_create',date('Y-m-d H:i:s'));
      $stmt->bindParam(':created_by',$user_id);
      $res = $stmt->execute();
      $user_id = $this->connection->lastInsertId();
      if($user_id != ''  && $user_id != '0'){
        $status = array(
          "status" => ERR_OK,
          "message" => "Added Successfully");
        return $status;
      }else{
        //print_r($res);
        $status = array(
          "status" => ERR_NOT_MODIFIED,
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
  public function updateUser($data) 
  {
    try {
      //print_r($data);exit;
      extract($data);

      
      $sql  = "UPDATE ".DBPREFIX."_users SET user_fname=:user_fname, user_lname=:user_lname, user_gender=:user_gender, user_mobile=:user_mobile,user_email=:user_email,user_level=:user_level,user_dob=:user_dob, user_status = :user_status ,modified_date = :modified_date, modified_by = :modified_by WHERE user_id = :user_id";   
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");  
      $modified_by = "1";  
      $stmt->bindParam(":user_id", $user_id); 
      $stmt->bindParam(":user_fname", $user_fname); 
      $stmt->bindParam(":user_lname", $user_lname);
      $stmt->bindParam(":user_gender", $user_gender);
      $stmt->bindParam(":user_mobile", $user_mobile);
      $stmt->bindParam(":user_email", $user_email);      
      $stmt->bindParam(":user_dob", $user_dob);
      $stmt->bindParam(":user_level", $user_level);
      $stmt->bindParam(":user_status", $user_status);
      $stmt->bindParam(":modified_date", $modified_date);
      $stmt->bindParam(":modified_by", $modified_by);
      //print_r($sql);exit;
      $res = $stmt->execute();
     /* echo " ---------user_id : ".$user_id;
      echo ",user_fname : ".$user_fname;
      echo ",user_lname : ".$user_lname;
      echo ",user_gender : ".$user_gender;
      echo ",user_mobile : ".$user_mobile;
      echo ",user_email : ".$user_email;
      echo ",user_dob : ".$user_dob;
      echo ",user_level : ".$user_level;
      echo ",user_status : ".$user_status;
      echo ",modified_date : ".$modified_date;
      echo ",modified_by : ".$modified_by;*/
      //print_r($this->connection->mysql_error());exit;
      if($res){
        //print_r($res);exit;
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
  public function updateUserStatus($data) {    
    try {
      extract($data);
      $sql = "UPDATE sg_Userdetails SET status=:status, modified_by=:modified_by WHERE User_id = :User_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":User_id",$UserId);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":modified_by",$userBy);
      $res = $stmt->execute();
      if($res == 'true'){
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

  public function updateUserPassword($data) {    
    try {
      extract($data);
      $sql = "UPDATE sg_users SET user_password=:user_password,temp_password = :temp_password, modified_by=:modified_by WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($sql);  
      $userBy = "1";
      $stmt->bindParam(":user_id",$user_id);
      $stmt->bindParam(":user_password", $user_password);
      $stmt->bindParam(":temp_password", $temp_password);
      $stmt->bindParam(":modified_by",$userBy);
      $res = $stmt->execute();
      if($res == 'true'){
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



}