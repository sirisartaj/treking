<?php
namespace App\Domain\AdminRoles\Repository;
use PDO;
/**
* Repository.
*/
class AdminRolesRepository
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
  public function getAdminRoles(): array
  {  
    try {    
      $sql = "SELECT `adminrole_id` AS id,`adminrole_name` AS roleName,`adminrole_status` AS status, created_by AS createdBy, created_date AS createdDate FROM ".DBPREFIX."_adminroles where `adminrole_status`!='9'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($results!='')
      {
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        'admin_roles' => $results);
      }
      else
      {
        $status = array(
                'status' => ERR_NO_DATA,
                'message' => "No Data Found"
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
  public function getAdminRole($args): array 
  {
    try {
      extract($args);
      $sql = "SELECT adminrole_name AS roleName, adminrole_status AS status, created_by AS createdBy, created_date AS createdDate FROM ".DBPREFIX."_adminroles WHERE adminrole_id = :adminrole_id ";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':adminrole_id',$roleId);
      $stmt->execute();
      $roledetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($roledetails!='')
      {
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        'role_details' => $roledetails);
      }
      else
      {
        $status = array(
                'status' => ERR_NO_DATA,
                'message' => "No data found",
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
  public function getPrivileges($args): array {
    try {
      $sql = "SELECT `add`,`access`,`edit`,`delete`,`status`,up_id  FROM ".DBPREFIX."_userpermissions WHERE adminrole_id = :adminrole_id LIMIT 0,1";
      $row = [
            'adminrole_id' => $args['roleId']
        ];
      $stmt = $this->connection->prepare($sql);
      $stmt->execute($row);
      $results = (array) $stmt->fetch(PDO::FETCH_OBJ);
      return $results;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function insertAdminRole(array $user): array
  {
    try {
      extract($user);
      if(empty($roleName))
      {
        $status = array(
          'status' => ERR_PARTIAL_CONT,
          'message' => "Failure rolename is required"
        );
      }
      else {
        $roleExist = $this->checkrolename($user['roleName']);
        if ($roleExist == '0')
        {
          $sql = "INSERT INTO ".DBPREFIX."_adminroles(adminrole_name,adminrole_status,created_date,created_by)VALUES(:adminrole_name,:adminrole_status,:created_date,:created_by)";
          $stmt = $this->connection->prepare($sql);
          $created_date = date("Y-m-d H:i:s");
          $stmt->bindParam(':adminrole_name',$roleName);
          $stmt->bindParam(':adminrole_status',$status);
          $stmt->bindParam(':created_date',$created_date);
          $stmt->bindParam(':created_by',$createdBy);
          $stmt->execute();
          $role_id = $this->connection->lastInsertId();
          if($role_id!='' && $role_id != '0')
          {
            $status = array(
            'status' => ERR_OK,
            'message' => "Role Added Successfully",
            'role_id' => $role_id);      
          }
          else
          {
            $status = array(
                    'status' => ERR_NOT_MODIFIED,
                    'message' => "Failure Not Added Successfully"
                    );    
          }
        }
        else
        {
          $status = array(
              'status' => ERR_EXISTS,
              'message' => "Failure Role name exist"
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
  public function checkrolename($rolename)
  {
    try {
      $sql = "SELECT count(`adminrole_id`) as cnt FROM " . DBPREFIX . "_adminroles where `adminrole_name`='$rolename' and adminrole_status in (0,1)";
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
  public function updateAdminRole(array $user): array
  {
    try {
      extract($user);
      if(empty($roleName))
      {
        $status = array(
                'status' => ERR_PARTIAL_CONT,
                'message' => "Failure rolename is required"
                );
      
      }
      else
      {
        $roleExist = $this->checkrole($roleName,$id);
        if ($roleExist == '0')
        {
          $sql = "UPDATE ".DBPREFIX."_adminroles SET adminrole_name=:adminrole_name, adminrole_status = :adminrole_status,modified_date=:modified_date,modified_by=:modified_by where adminrole_id=:adminrole_id";
          $stmt = $this->connection->prepare($sql);
          $modified_date = date("Y-m-d H:i:s");
          $stmt->bindParam(':adminrole_name',$roleName);
          $stmt->bindParam(':adminrole_status',$status);
          $stmt->bindParam(':adminrole_id',$id);
          $stmt->bindParam(':modified_date',$modified_date);
          $stmt->bindParam(':modified_by',$userBy);
          $stmt->execute();
          if($stmt->execute())
          {
            $status = array(
                     'status' => ERR_OK,
                     'message' => "Role Name Updated Successfully"
                     );          
          }
          else
          {
            $status = array(
                     'status' => ERR_NOT_MODIFIED,
                     'message' => "Not Updated Successfully"
                     );
          }
        }
        else
        {
          $status = array(
                  'status' => ERR_EXISTS,
                  'message' => "Failure Role name exist"
                  );
        }
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
  public function checkrole($rolename,$id)
  {   
    try {
      $sql = "SELECT count(`adminrole_id`) as cnt FROM " . DBPREFIX . "_adminroles where `adminrole_name`='$rolename'and adminrole_id!='$id'";
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
  public function deleteAdminRole(array $user): array {
    try {
      extract($user);
      $sql = "UPDATE ".DBPREFIX."_adminroles SET adminrole_status='9' where adminrole_id=:adminrole_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':adminrole_id',$roleId);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
             'status' => ERR_OK,
             'message' => "Success Role Deleted successfully"
        );
      }
      else
      {
        $status = array(
             'status' => ERR_NOT_MODIFIED,
             'message' => "Failure Role Not Deleted successfully"
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
  public function editPrivileges(array $user): array
  {
    try {
      extract($user);
      $sql = "SELECT * FROM ".DBPREFIX."_userpermissions WHERE adminrole_id = :adminrole_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':adminrole_id',$id);
      $stmt->execute();
      $accessRoles = $stmt->fetch(PDO::FETCH_ASSOC);
      $id=$user['id'];
      $status = $user['status'];
      $accessname = $user['accessName'];
      $slugName =  $user['slugName'];
      if($status == '0') {
        if($accessRoles != '') {
          if($accessRoles['access'] != '') {
            $access = $accessRoles['access'] . ',' .$slugName;  
          } else {
            $access = $slugName;
          }
          $sql2 = "UPDATE ".DBPREFIX."_userpermissions SET `".$accessname."` = '".$access."' WHERE adminrole_id = :adminrole_id";
          $stmt2= $this->connection->prepare($sql2);
          $stmt2->bindParam(':adminrole_id',$id);
          if($stmt2->execute()){
            $status = array(
                    'status' => ERR_OK,
                    'message' => "Success");
          }else {
            $status = array(
                     'status' => ERR_NOT_MODIFIED,
                     'message' => "Failure");
          }  
        } 
        else {
          $access = $slugName;
          $adminrole_id = $id;
          $sql2 = "INSERT INTO ".DBPREFIX."_userpermissions SET `".$accessname."` = '".$access."' WHERE adminrole_id = :adminrole_id";
          $stmt2= $this->connection->prepare($sql2);
          $stmt2->bindParam(':adminrole_id',$id);
          if($stmt2->execute()){
              $status = array(
             'status' => ERR_OK,
             'message' => "Success");
          }else {
              $status = array(
             'status' => ERR_NOT_MODIFIED,
             'message' => "Failure");
          }  
        }
      } 
      else {
          $values = explode(',', $accessRoles['access']);
          $slugArray = array($slugName);
          $newValues = array_diff( $values, $slugArray);
          $savedValues = implode($newValues, ',');
          $access = $savedValues;
          $sql2 = "UPDATE ".DBPREFIX."_userpermissions SET `".$accessname."` = '".$access."' WHERE adminrole_id = :adminrole_id";
          $stmt2= $this->connection->prepare($sql2);
          $stmt2->bindParam(':adminrole_id',$id);
          if($stmt2->execute()){
          $status = array(
                   'status' => ERR_OK,
                   'message' => "Success");
          }else {
           $status = array(
                   'status' => ERR_NOT_MODIFIED,
                   'message' => "Failure");
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
  public function updateRoleStatus($data) {
    try {
      extract($data);
      $sql = "UPDATE ".DBPREFIX."_adminroles SET adminrole_status= :status where adminrole_id =:adminrole_id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':status',$status);
      $stmt->bindParam(':adminrole_id',$roleId);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
             'status' => ERR_OK,
             'message' => "Success Role Updated successfully"
        );
      }
      else
      {
        $status = array(
             'status' => ERR_NOT_MODIFIED,
             'message' => "Failure Role Not Updated successfully"
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