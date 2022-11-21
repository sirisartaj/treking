<?php
namespace App\Domain\Roles;

use App\Domain\Roles\RolesRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Roles
{
  /**
   * @var RolesRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param RolesRepository $repository The repository
   */
  public function __construct(RolesRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getRoles(): array
  {        
    $Roles = $this->repository->getRoles();
    return $Roles;
  }
  public function getRole($data): array 
  {
    $Roles = (array) $this->repository->getRole($data);
    return $Roles;
  }
  public function getRolePriviliges($data): array 
  {
    $Roles = (array) $this->repository->getRolePriviliges($data);
    return $Roles;
  }
  public function getModules(): array 
  {
    $Roles = (array) $this->repository->getModules();
    return $Roles;
  }
  public function deleteRole($data) :array 
  {
    $Role = $this->repository->deleteRole($data);
    return $Role;
  }
  public function addRole($data) : array 
  {
    try {
      extract($data);

      if(isset($Role_avatar)&&!empty($Role_avatar)){
        $filedir = UPLOADPATH."Roles/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "Role_". $randName;
        $ext = substr($Role_avatar['name'], strrpos($Role_avatar['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $Role_avatar;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $Role_avatar = $newName.".".strtolower($ext);
      }
      $data['Role_avatar'] = $Role_avatar;
      $res = $this->repository->addRole($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateRole($data) : array 
  {
    try {
      //print_r($data);echo "in Roleco";exit;
      extract($data);

      /*if(isset($Role_avatar)&&!empty($Role_avatar)){
        $filedir = UPLOADPATH."Roles/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "Role_". $randName;
        $ext = substr($Role_avatar['name'], strrpos($Role_avatar['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $Role_avatar;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $Role_avatar = $newName.".".strtolower($ext);
      }*/
      //$data['Role_avatar'] = $Role_avatar;
      $res = $this->repository->updateRole($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }

  public function updatePrivilies($data) : array 
  {
    try {
      //print_r($data);echo "in Roleco";exit;
      extract($data);
      $res = $this->repository->updatePrivilies($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateRoleStatus($data) {
    $Role = $this->repository->updateRoleStatus($data);
    return $Role;
  }
  
}