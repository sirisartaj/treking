<?php
namespace App\Domain\Users\Repository;
use PDO;
use App\Utilities\ImageUpload;
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
  public function getUsers(): array {
    try {
      $query = "SELECT `user_id` as id, user_fname as firstName, user_lname as lastName, concat(user_fname,' ',user_lname) as displayName, user_email as email, `user_mobile` as mobile, `user_create` as createdOn, lastlogin AS lastLogin, user_status AS status, created_by AS createdBy  FROM sg_users where user_status in(0,1)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        'users' => $results);
      }else{
         $status = array(
        'status' => ERR_NO_DATA,
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
  public function checkLogin($data):array {
    try{
      extract($data);
      $passwordEn = $this->PassHash($password);
      if(empty($email) || empty($password))
      {
        $status = array(
                'status' => ERR_PARTIAL_CONT,
                'message' => "Failure email is required"
                );
      }
      else{
        $sql ="SELECT user_id as id, user_fname as firstName,user_lname AS lastName,user_email AS email,user_mobile AS mobile, user_gender AS gender, DATE_FORMAT(user_dob, '%d %M %Y') AS dob, user_level AS roleId, user_avatar AS avatar, user_status AS status FROM sg_users WHERE user_email = '". $email ."' AND  user_password = '". $passwordEn ."' AND user_status = '0'"; 
        $stmt = $this->connection->prepare($sql);  
        $stmt->execute();
        $users = $stmt->fetch(PDO::FETCH_OBJ);
        if($users!=''){
          $status = array('status' => ERR_OK,
                  'message' => "Success",
                  'userDetails' => $users);      
        }
        else{
          $status = array(
                  'status' => ERR_NO_DATA,
                  'message' => "Failure Please enter correct email&password"
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
  public function PassHash($password = NULL) {
    if(isset($password)) {
      if($password != NULL) {
        return hash('sha256', $password);
      }else {
        echo "Wrong way to call method";
      }
    }
  }
  public function checkUserEmail($email) {
    try {
      $sql = "SELECT count(`user_id`) as cnt FROM " . DBPREFIX . "_users where `user_email`='$email'";
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
  public function moveUploadedFile($directory, UploadedFileInterface $uploadedFile)
  {
      $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
      $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
      $filename = sprintf('%s.%0.8s', $basename, $extension);

      $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

      return $filename;
  }

  public function insertUser($data) {
    try {
      extract($data);
      if(empty($email))
      {
         $status = array(
        'status' => "206",
        'message' => "Failure email is required"
        );
      }
      else{
        $userExist = $this->checkUserEmail($email);
        if($userExist == '0')
        {
          if(isset($userImage)&&!empty($userImage)){
            $filedir = UPLOADPATH."users/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "user_". $randName;
            $imagesize= getimagesize($userImage['tmp_name']);
            $ext = substr($userImage['name'], strrpos($userImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $userImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '100';
              $ImageUpload->NewHeight = '100';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $user_photo = $newName.".".strtolower($ext);
            }else{
              $status = array(
                     'status' => "206",
                     'message' => "Failure Please upload jpg,png,gift,jpeg images only"
                    );
              return $status;
            }
          }
          $sql = "INSERT INTO sg_users SET user_fname=:user_fname, user_lname=:user_lname, user_mobile=:user_mobile, user_email = :user_email, user_password = :user_password, user_level=:user_level,user_dob = :user_dob, user_avatar = :user_avatar, user_gender = :user_gender,user_status = :user_status,user_create = :created_date,created_by=:created_by";      
        $stmt = $this->connection->prepare($sql);  
        $created_date = date("Y-m-d H:i:s");
        $password = $this->PassHash($password);
        $stmt->bindParam(":user_fname", $firstName);
        $stmt->bindParam(":user_lname", $lastName);
        $stmt->bindParam(":user_mobile",  $mobile);
        $stmt->bindParam(":user_email",  $email);
        $stmt->bindParam(":user_password", $password); 
        $stmt->bindParam(":user_level",   $roleId);
        $stmt->bindParam(":user_dob", $dob);
        $stmt->bindParam(":user_avatar", $user_photo);
        $stmt->bindParam(":user_gender",  $gender);
        $stmt->bindParam(":user_status",  $status);
        $stmt->bindParam(":created_date", $created_date); 
        $stmt->bindParam(":created_by", $userBy); 
        $res = $stmt->execute();
        $user_id = $this->connection->lastInsertId();
        if($user_id){
          $status = array(
            'status' => "200",
            'message' => "User Added Successfully",
            'id' => $user_id);
        }
        else{
          $status = array(
            'status' => "304",
            'message' => "User Not Added Successfully");
        }
      }
      else
      {
        $status = array(
                    'status' => "208",
                    'message' => "Failure user email already existed"
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
  public function updateUser($data) {
    try{
      extract($data);
      if(empty($email))
      {
         $status = array(
        'status' => "206",
        'message' => "Failure email is required"
        );
      }else{
        $userExist = $this->checkemail($email,$id);
        if ($userExist == '0')
        {
          if(isset($userImage)&&!empty($userImage)){
            $filedir = UPLOADPATH."users/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "user_". $randName;
            $ext = substr($userImage['name'], strrpos($userImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $userImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = '100';
              $ImageUpload->NewHeight = '100';
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $user_avatar = $newName.".".strtolower($ext);
             }
            else {
              $status = array(
                 'status' => "206",
                 'message' => "Failure Please upload jpg,png,gift,jpeg images only"
                );
                return $status;               
            }
          }
          $sql  = "UPDATE sg_users SET user_fname=:user_fname, user_lname=:user_lname, user_email=:user_email, user_mobile = :user_mobile, user_level=:user_level,user_dob = :user_dob, user_avatar = :user_avatar, user_gender = :user_gender,user_status = :user_status,modified_date = :modified_date,modified_by=:modified_by where user_id=:user_id";
          $stmt = $this->connection->prepare($sql);  
          $modified_date = date("Y-m-d H:i:s");
          $stmt->bindParam(":user_fname",   $firstName);
          $stmt->bindParam(":user_lname",   $lastName);
          $stmt->bindParam(":user_email",  $email);
          $stmt->bindParam(":user_mobile",  $mobile);
          $stmt->bindParam(":user_level",   $roleId);
          $stmt->bindParam(":user_dob",     $dob);
          $stmt->bindParam(":user_avatar",  $user_avatar);
          $stmt->bindParam(":user_gender",  $gender);
          $stmt->bindParam(":user_status",  $status);
          $stmt->bindParam(":user_id",      $id);
          $stmt->bindParam(":modified_date", $modified_date); 
          $stmt->bindParam(":modified_by", $userBy); 
          $res = $stmt->execute();
          if($stmt->execute()){
          $status = array(
           'status' => "200",
           'message' => "User Details Updated Successfully");
          }else{
            $status = array(
            'status' => "304",
            'message' => "Sorry,User Details Not Updated ");
          }
        }
        else
        {
          $status = array(
                    'status' => "208",
                    'message' => "Failure user email already existed"
                );
        }
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
  public function checkemail($email,$userid)
  {     
    try {
      $sql = "SELECT count(`user_id`) as cnt FROM " . DBPREFIX . "_users where `user_email`='$email'and user_id!='$userid'";
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
  public function getUser($data) {
    try {
      extract($data);
      $query = "SELECT user_id as id, user_fname as firstName, user_lname as lastName,`user_mobile` as mobile, user_gender as gender, user_dob as dob, user_avatar as userImage, user_level as roleId, user_status as status, user_email as email,(SELECT adminrole_name FROM sg_adminroles WHERE adminrole_id=user_level LIMIT 0,1) AS roleName, created_by AS createdBy, user_create AS createdDate FROM sg_users WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':user_id', $userId);
      $stmt->execute();
      $adminuserdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($adminuserdetails!=''){
        $status = array(
        'status' => "200",
        'message' => "Success",
        'user' => $adminuserdetails);
        return $status;
      }else{
       $status = array(
      'status' => "204",
      'message' => "Failure");
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
  public function deleteUser($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_users SET user_status = '9' WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':user_id',$userId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success user deleted Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure user Not deleted Successfully");
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
  public function deleteSiteUser($data) {
    try {
      extract($data);
      $query = "DELETE  sg_regestration WHERE registration_id = :user_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':user_id',$userId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success user deleted Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure user Not deleted Successfully");
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
  public function procesCheckEmail($email) {
    try {
      $sql = "SELECT *,count('user_id') as cnt FROM sg_users WHERE user_email = '$email'";
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
  public function processPasswordUpdate($email,$rand) {
    try {
      $user_password = $this->PassHash($rand);
      $query = "UPDATE ".DBPREFIX."_users SET `user_password`= :temp_pass where user_email=:user_email";
      $stmt2 = $this->connection->prepare($query);
      $stmt2->bindParam(':temp_pass',$user_password);
      $stmt2->bindParam(':user_email',$email);
      $res=$stmt2->execute();
      return $res;  
    } catch(PDOException $e) {        
      $status = array(
                'status' => "500",
                'message' => $e->getMessage()
                );
      return $status;       
    }    
  }
  public function getUsername($email) {
    try {
      $sql = "SELECT * FROM sg_users WHERE user_email = '$email'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);  
      return $count;
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
      $old_password = $this->PassHash($oldPassword);
      $sql = "SELECT count(1) as usercount FROM ".DBPREFIX."_users WHERE user_id=:user_id AND user_password = :pass";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':user_id',$userId);
      $stmt->bindParam(':pass',$old_password);
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if($res->usercount =='0') {
        $status = array(
                  'status' => "206",
                  'message' => "Old password not match");
        return $status; 
      }
      $query = "UPDATE ".DBPREFIX."_users SET `user_password`= :new_pass where user_id=:user_id";
      $stmt2 = $this->connection->prepare($query);
      $new_pass = $this->PassHash($password);
      $stmt2->bindParam(':new_pass',$new_pass);
      $stmt2->bindParam(':user_id',$userId);
      $stmt2->execute();
      $status = array(
                  'status' => "200",
                  'message' => "password updated Successfully");
      return $status; 
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status; 
    }
  }
  public function getSiteUsers() {
    try {
      $query = "SELECT `first_name` AS firstName,`last_name` AS lastName,`email`,`mobile`,`created_date` AS createdDate,getbookingcount(`email`) as bookingcnt, getsuccessbooking(`email`) as successbookingcnt FROM sg_regestration";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!=''){
        $status = array(
          'status' => "200",
          'message' => "Success",
          'siteusers' => $results);
        return $status;
      }else{
        $status = array(
          'status' => "204",
          'message' => "Failure");
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
      $query = "UPDATE  sg_users SET user_status = :status WHERE user_id = :user_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':user_id', $userId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success user updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure user Not updated Successfully");
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