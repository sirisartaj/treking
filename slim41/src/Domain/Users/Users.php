<?php
namespace App\Domain\Users;

use App\Domain\Users\UsersRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Users
{
  /**
   * @var UsersRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param UsersRepository $repository The repository
   */
  public function __construct(UsersRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getUsers(): array
  {        
    $Users = $this->repository->getUsers();
    return $Users;
  }
  public function getUser($data): array 
  {
    $Users = (array) $this->repository->getUser($data);
    return $Users;
  }
  public function deleteUser($data) :array 
  {
    $User = $this->repository->deleteUser($data);
    return $User;
  }
  public function addUser($data) : array 
  {
    try {
      extract($data);

      if(isset($user_avatar)&&!empty($user_avatar)){
        $filedir = UPLOADPATH."Users/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "User_". $randName;
        $ext = substr($user_avatar['name'], strrpos($user_avatar['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $user_avatar;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $user_avatar = $newName.".".strtolower($ext);
      }
      $data['user_avatar'] = $user_avatar;
      $res = $this->repository->addUser($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateUser($data) : array 
  {
    try {
      //print_r($data);echo "in userco";exit;
      extract($data);

      /*if(isset($user_avatar)&&!empty($user_avatar)){
        $filedir = UPLOADPATH."Users/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "User_". $randName;
        $ext = substr($user_avatar['name'], strrpos($user_avatar['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $user_avatar;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $user_avatar = $newName.".".strtolower($ext);
      }*/
      //$data['user_avatar'] = $user_avatar;
      $res = $this->repository->updateUser($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateUserStatus($data) {
    $User = $this->repository->updateUserStatus($data);
    return $User;
  }
  public function updateUserPassword($data) {
    $User = $this->repository->updateUserPassword($data);
    return $User;
  }
}