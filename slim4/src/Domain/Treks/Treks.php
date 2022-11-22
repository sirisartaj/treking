<?php
namespace App\Domain\Treks;

use App\Domain\Treks\TreksRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Treks
{
  /**
   * @var TreksRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param TreksRepository $repository The repository
   */
  public function __construct(TreksRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getTreks(): array
  {        
    $Treks = $this->repository->getTreks();
    return $Treks;
  }
  public function addTrek($data) {
    extract($data);
    if(empty($trek_title))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure trekname is required1"
      );
    }else{
      $trekExist = $this->repository->checkTrekName($trek_title);
      if($trekExist == '0')
      {
        
        
        $trekId = $this->repository->insertTrek($data);
         if($trekId){
           $status = array(
              'status' => "200",
              'message' => "Inserted Successfully"
           );
         }
      }
      else{
        $status = array(
          'status' => "208",
          'message' => "Failure Trek name exist"
       );
      } 
    }
    return $status;
  }

  public function addTrekIterinary($data) {
    extract($data);
    if(empty($iterinary_title))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure iterinary title is required"
      );
    }else{
            
        $trekId = $this->repository->addTrekIterinaryDetails($data);
         if($trekId){
           $status = array(
              'status' => "200",
              'message' => "Inserted Successfully"
           );
         }
      
    }
    return $status;
  }

  public function editTrekIterinary($data) {
    
    extract($data);
    if(empty($iterinary_title))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure iterinary title is required"
      );
    }else{
            
        $trekId = $this->repository->updateTrekIterinaryDetails($data);
         if($trekId){
           $status = array(
              'status' => "200",
              'message' => "Inserted Successfully"
           );
         }
      
    }
    return $status;
  }
  public function updateTrek($data) {
    extract($data);
    if(empty($trek_title))
    {
      $status = array(
                'status' => "208",
                'message' => "Failure trekname is required"
                );
    }else{
       $status = $this->repository->updateTrek($data);      
    }    
    return $status;
  }
  public function getTrek($data) {
    $trek = $this->repository->getTrek($data);
    return $trek;
  }
  public function getItineraryTrek($data) { 
    $trek = $this->repository->getItineraryTrek($data);
    return $trek;
  }
  
  public function deleteTrek($data) {
    $trek = $this->repository->deleteTrek($data);
    return $trek;
  }
  public function getBatches($data) {
    $trek = $this->repository->getBatches($data);
    return $trek;
  }
  public function addBatch($data) {
    $trek = $this->repository->addBatch($data);
    return $trek;
  }
  public function getBatch($data) {
    $trek = $this->repository->getBatch($data);
    return $trek;
  }
  public function updateBatch($data) {
    $trek = $this->repository->updateBatch($data);
    return $trek;
  }
  public function getTrekFee($data) {
    $trek = $this->repository->getTrekFee($data);
    return $trek;
  }
  public function updateTrekFee($data) {
    $trek = $this->repository->updateTrekFee($data);
    return $trek;
  }
  public function updatePopular($data) {
    $trek = $this->repository->updatePopular($data);
    return $trek;
  }
  public function getBatchBookings($data) {
    $trek = $this->repository->getBatchBookings($data);
    return $trek;
  }
  public function getBookings() {
    $trek = $this->repository->getBookings();
    return $trek;
  }
  public function getParticipants($data) {
    $trek = $this->repository->getParticipants($data);
    return $trek;
  }
  public function getBookingDetails($data) {
    $trek = $this->repository->getBookingDetails($data);
    return $trek;
  }
  public function addOrganizer($data) {
    $trek = $this->repository->addOrganizer($data);
    return $trek;
  }
  public function getOrganizerDetails($data) {
    $trek = $this->repository->getOrganizerDetails($data);
    return $trek;
  }
  public function getOrganizerTreks($data) {
    $trek = $this->repository->getOrganizerTreks($data);
    return $trek;
  }
  public function deleteOrganizer($data) {
    $trek = $this->repository->deleteOrganizer($data);
    return $trek;
  }
  public function addTrekCoupon($data) {
    $trek = $this->repository->addTrekCoupon($data);
    return $trek;
  }
  public function getTrekCoupons($data) {
    $trek = $this->repository->getTrekCoupons($data);
    return $trek;
  }
  public function getCouponTreks($data) {
    $trek = $this->repository->getCouponTreks($data);
    return $trek;
  }
  public function deleteTrekCoupon($data) {
    $trek = $this->repository->deleteTrekCoupon($data);
    return $trek;
  }
  public function getTrekGallery($data) {
    $trek = $this->repository->getTrekGallery($data);
    return $trek;
  }
  public function addTrekGallery($data) {
    extract($data);
    if(isset($trekgalImage['name'])&&!empty($trekgalImage['name'])){
      $filedir = UPLOADPATH."treks/gallery/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "trek_". $randName;
      $ext = substr($trekgalImage['name'], strrpos($trekgalImage['name'], '.') + 1);
      if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
        list($width, $height) = getimagesize($trekgalImage['tmp_name']); 
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $trekgalImage;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = $width;
        $ImageUpload->NewHeight = $height;
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $trekgalImage = $newName.".".strtolower($ext);
      }else{
        $status = array(
            'status' => "400",
            'message' => "Failure Please upload jpg,png,gift,jpeg images only"
        );
        return $status;
      }
    }
    $data['trekgalImage'] = $trekgalImage;
    $trek = $this->repository->addTrekGallery($data);
    return $trek;
  }
  public function deleteTrekGallery($data) {
    $trek = $this->repository->deleteTrekGallery($data);
    return $trek;
  }
  public function getTrekReviews() {
    $trek = $this->repository->getTrekReviews();
    return $trek;
  }
  public function addTrekReview($data) {
    extract($data);
    if(empty($name))
    {
      $status = array(
      'status' => "206",
      'message' => "Failure name is required"
      );
    }else{
      $status = $this->repository->addTrekReview($data);
    }
    return $status;
  }
  public function getTrekReview($data) {
    $trek = $this->repository->getTrekReview($data);
    return $trek;
  }
  public function updateTrekReview($data) {
    $trek = $this->repository->updateTrekReview($data);
    return $trek;
  }
  public function addTrekRentals($data) {
    extract($data);
    if(empty($trekId)||empty($rentalItem)){
      $status = array(
      'status' => "206",
      'message' => "Failure Please enter proper data"
      );
    }
    else{
      $status = $this->repository->addTrekRentals($data);
    }
    return $status;
  }
  public function getTrekRentals($data) {
    $trek = $this->repository->getTrekRentals($data);
    return $trek;
  }
  public function getRentalTreks($data) {
    $trek = $this->repository->getRentalTreks($data);
    return $trek;
  }
  public function getBatchRentals($data) {
    $trek = $this->repository->getBatchRentals($data);
    return $trek;
  }
  public function getTrekBatchRental($data) {
    $trek = $this->repository->getTrekBatchRental($data);
    return $trek;
  }
  public function deleteTrekRental($data) {
    $trek = $this->repository->deleteTrekRental($data);
    return $trek;
  }
  public function getTransactions() {
    $trek = $this->repository->getTransactions();
    return $trek;
  }
  public function getTransactionDetails($data) {
    $trek = $this->repository->getTransactionDetails($data);
    return $trek;
  }
  public function addTrekFaq($data) {
    $trek = $this->repository->addTrekFaq($data);
    return $trek;
  }
  public function updateTrekFaq($data) {
    $trek = $this->repository->updateTrekFaq($data);
    return $trek;
  }
  public function getFaq($data) {
    $trek = $this->repository->getFaq($data);
    return $trek;
  }
  public function updateTrekStatus($data) {
    $trek = $this->repository->updateTrekStatus($data);
    return $trek;
  }
  public function updateBatchStatus($data) {
    $trek = $this->repository->updateBatchStatus($data);
    return $trek;
  }
  public function updateOrganizerStatus($data) {
    $trek = $this->repository->updateOrganizerStatus($data);
    return $trek;
  }
  public function updateCouponStatus($data) {
    $trek = $this->repository->updateCouponStatus($data);
    return $trek;
  }
  public function updateTrekImageStatus($data) {
    $trek = $this->repository->updateTrekImageStatus($data);
    return $trek;
  }
  public function updateTrekRentalStatus($data) {
    $trek = $this->repository->updateTrekRentalStatus($data);
    return $trek;
  }
  public function updateTrekFaqStatus($data) {
    $trek = $this->repository->updateTrekFaqStatus($data);
    return $trek;
  }
  public function generateCertificate($data) {
    $trek = $this->repository->generateCertificate($data);
    return $trek;
  }
}