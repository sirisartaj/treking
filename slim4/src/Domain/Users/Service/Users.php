<?php
namespace App\Domain\Users\Service;

use App\Domain\Users\Repository\UsersRepository;
use App\Exception\ValidationException;
use App\Utilities\smtpHelper;
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
  /**
   * Create a new user.
   *
   * @param array $data The form data
   *
   * @return int The new user ID
   */
  public function getUsers(): array
  {  
    $users = $this->repository->getUsers();
    return $users;
  }
  public function checkLogin($data) 
  {
    $users = $this->repository->checkLogin($data);
    return $users;
  }
  public function addUser($data) {
    extract($data);
    $errors = [];
    extract($data);
    // Here you can also use your preferred validation library
    if(empty($email))
    {
      $errors['email']  = "Please enter email ID";      
    }
    $userExist = $this->repository->checkUserEmail($email);
    if ($userExist != '0')
    {
      $errors['email']  = "Email is already exists";     
    }
    if($errors) {
       $status = array(
            'status' => "500",
            'message' => $errors['email']);
      return $status;
    }
    //$this->validateUser($data);
    $userId = $this->repository->insertUser($data);
    return $userId;
  }
  public function updateUser($data) {
    //$this->validateEditUser($data);
    $errors = [];
    extract($data);
    // Here you can also use your preferred validation library
    if(empty($email))
    {
      $errors['email']  = "Please enter email ID";      
    }
    // $userExist = $this->repository->checkUserEmail($email);
    // if ($userExist != '0')
    // {
    //   $errors['email']  = "Email is already exists";     
    // }
    if ($errors) {
       $status = array(
            'status' => "500",
            'message' => $errors['email']);
      return $status;
    }
    $userId = $this->repository->updateUser($data);
    return $userId;
  }
  public function getUser($data) {
    $users = $this->repository->getUser($data);
    return $users;
  }
  public function deleteUser($data) {
    $users = $this->repository->deleteUser($data);
    return $users;
  }
  public function deleteSiteUser($data) {
    $users = $this->repository->deleteSiteUser($data);
    return $users;
  }
  public function forgotPassword($data) {
    try {
      extract($data);
      $result = $this->repository->procesCheckEmail($email);
      if($result == 1) {   
        $randName = rand(101010, 909090);
        $tempPasswordResult = $this->repository->processPasswordUpdate($email,$randName);
        $final = str_rot13($update->email) .'|' .$this->repository->PassHash($randName);
        $username = $this->repository->getUsername($email);
        $first_name = $username->user_fname;
        $last_name = $username->user_lname;
        if($tempPasswordResult) {
          $subject = "Forgot Password Details";
          $message='<p>Dear  '.$first_name." ".$last_name.',</p>'; 
          $message.="<p style='color:black'>Your temporary password is : ".$randName;
          $message.="<p style='color:black'>To change your password to something more memorable, after logging in go to  Change Password</p>";
          $smtpHelper = new smtpHelper;
          $smtpHelper->email = $email;   
          $smtpHelper->subject = $subject;          
          $smtpHelper->message = $message;
          $response = $smtpHelper->SendEmail();
          if($response){
            $status = array(
            'status' => "200",
            'message' => "temporary password details send to your email");
            return $status; 
          }else {
            $status = array(
              'status' => "400",
              'message' => "Please enter existed email");
            return $status; 
          }
        } 
      }else{
        $status = array(
        'status' => "400",
        'message' => "Please enter existed email");
        return $status; 
      }
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status; 
    }
  }
  public function updateUserPassword($data) {      
    $status = $this->repository->updateUserPassword($data);      
    return $status;  
  }
  private function validateUser(array $data): void
  {
    $errors = [];
    extract($data);
    // Here you can also use your preferred validation library
    if(empty($email))
    {
      $errors['email']  = "Please enter email ID";      
    }
    $userExist = $this->repository->checkUserEmail($email);
    if ($userExist != '0')
    {
      $errors['email']  = "Email is already exists";     
    }
    if ($errors) {
        throw new ValidationException('Please check your input', $errors,201);
    }
  }
  private function validateEditUser(array $data): void
  {
    $errors = [];
    extract($data);
    // Here you can also use your preferred validation library
    if(empty($email))
    {
      $errors['email']  = "Please enter email ID";      
    }
    // $userExist = $this->repository->checkUserEmail($email);
    // if ($userExist != '0')
    // {
    //   $errors['email']  = "Email is already exists";     
    // }
    if ($errors) {
        throw new ValidationException('Please check your input', $errors,201);
    }
  }
  public function getSiteusers()
  {
    $status = $this->repository->getSiteusers();
    return $status;
  }
  public function updateUserStatus($data) {
    $user = $this->repository->updateUserStatus($data);
    return $user;
  }
}