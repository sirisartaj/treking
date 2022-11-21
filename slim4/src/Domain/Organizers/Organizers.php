<?php
namespace App\Domain\Organizers;

use App\Domain\Organizers\OrganizersRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Organizers
{
  /**
   * @var OrganizersRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param OrganizersRepository $repository The repository
   */
  public function __construct(OrganizersRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getOrganizers(): array
  {        
    $Organizers = $this->repository->getOrganizers();
    return $Organizers;
  }
  public function addOrganizer($data) {
    extract($data);
    if(empty($organiserName)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer name is required"
                );
    }elseif(empty($mobileNumber)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer mobile number is required"
                );
    } else{
      $orgExist = $this->repository->checkOrganizer($mobileNumber);
      if ($orgExist == '0')
      {
        $status = $this->repository->addOrganizer($data);        
      }else{
        $status = array(
                'status' => "208",
                'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function getOrganizer($data) {
    $Organizers = $this->repository->getOrganizer($data);
    return $Organizers;
  }
  public function updateOrganizer($data) {
    extract($data);
    $orgname=$update->organiserName;
    $orgmobile=$update->mobileNumber;
    $orgid=$update->id;
    if(empty($organiserName)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer name is required"
      );
    }elseif(empty($mobileNumber)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer mobile number is required"
      );
    }
    else{
      $orgExist = $this->repository->checkOrgMobile($mobileNumber,$id);
      if($orgExist == '0')
      {
        $status = $this->repository->updateOrganizer($data);  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function deleteOrganizer($data) {
    $Organizers = $this->repository->deleteOrganizer($data);
    return $Organizers;
  }
  public function updateOrganizerStatus($data) {
    $Organizers = $this->repository->updateOrganizerStatus($data);
    return $Organizers;
  }
  /*
  * Trip Organizers
  */
  public function getTripOrganizers(): array
  {        
    $Organizers = $this->repository->getTripOrganizers();
    return $Organizers;
  }
  public function addTripOrganizer($data) {
    extract($data);
    if(empty($organiserName)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer name is required"
                );
    }elseif(empty($mobileNumber)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer mobile number is required"
                );
    } else{
      $orgExist = $this->repository->checkTripOrganizer($mobileNumber);
      if ($orgExist == '0')
      {
        $status = $this->repository->addTripOrganizer($data);        
      }else{
        $status = array(
                'status' => "208",
                'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function getTripOrganizer($data) {
    $Organizers = $this->repository->getTripOrganizer($data);
    return $Organizers;
  }
  public function updateTripOrganizer($data) {
    extract($data);
    $orgname=$update->organiserName;
    $orgmobile=$update->mobileNumber;
    $orgid=$update->id;
    if(empty($organiserName)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer name is required"
      );
    }elseif(empty($mobileNumber)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer mobile number is required"
      );
    }
    else{
      $orgExist = $this->repository->checkTripOrgMobile($mobileNumber,$id);
      if($orgExist == '0')
      {
        $status = $this->repository->updateTripOrganizer($data);  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function deleteTripOrganizer($data) {
    $Organizers = $this->repository->deleteTripOrganizer($data);
    return $Organizers;
  }
  public function updateTripOrganizerStatus($data) {
    $Organizers = $this->repository->updateTripOrganizerStatus($data);
    return $Organizers;
  }
  /*
  * Expedition Organizers
  */
  public function getExpeditionOrganizers(): array
  {        
    $Organizers = $this->repository->getExpeditionOrganizers();
    return $Organizers;
  }
  public function addExpeditionOrganizer($data) {
    extract($data);
    if(empty($organiserName)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer name is required"
                );
    }elseif(empty($mobileNumber)){
      $status = array(
                'status' => "206",
                'message' => "Failure organizer mobile number is required"
                );
    } else{
      $orgExist = $this->repository->checkExpeditionOrganizer($mobileNumber);
      if ($orgExist == '0')
      {
        $status = $this->repository->addExpeditionOrganizer($data);        
      }else{
        $status = array(
                'status' => "208",
                'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function getExpeditionOrganizer($data) {
    $Organizers = $this->repository->getExpeditionOrganizer($data);
    return $Organizers;
  }
  public function updateExpeditionOrganizer($data) {
    extract($data);
    $orgname=$update->organiserName;
    $orgmobile=$update->mobileNumber;
    $orgid=$update->id;
    if(empty($organiserName)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer name is required"
      );
    }elseif(empty($mobileNumber)){
      $status = array(
      'status' => "206",
      'message' => "Failure organizer mobile number is required"
      );
    }
    else{
      $orgExist = $this->repository->checkExpeditionOrgMobile($mobileNumber,$id);
      if($orgExist == '0')
      {
        $status = $this->repository->updateExpeditionOrganizer($data);  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Organizer mobile number already exist"
                );
      }
    }
    return $status;
  }
  public function deleteExpeditionOrganizer($data) {
    $Organizers = $this->repository->deleteExpeditionOrganizer($data);
    return $Organizers;
  }
  public function updateExpeditionOrganizerStatus($data) {
    $Organizers = $this->repository->updateExpeditionOrganizerStatus($data);
    return $Organizers;
  }
}