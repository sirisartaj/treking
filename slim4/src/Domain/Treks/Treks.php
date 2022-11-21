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
    if(empty($trekTitle))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure trekname is required"
      );
    }else{
      $trekExist = $this->repository->checkTrekName($trekTitle);
      if($trekExist == '0')
      {
        if(isset($trekImage['name'])&&!empty($trekImage['name']))
        {
          $filedir = UPLOADPATH."treks/"; 
          $randName = rand(10101010, 9090909090);
          $newName = "trek_". $randName;
          $ext = substr($trekImage['name'], strrpos($trekImage['name'], '.') + 1);
          list($width, $height) = getimagesize($trekImage['tmp_name']); 
          if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $trekImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = $width;
            $ImageUpload->NewHeight = $height;
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $trekImage = $newName.".".strtolower($ext);
          }
          else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
            return $status;
          }
        }
        if(isset($overviewImage['name'])&&!empty($overviewImage['name'])){
          $filedir = UPLOADPATH."treks/"; 
          $randName = rand(10101010, 9090909090);
          $newName = "trekpagebanner_". $randName;
          $ext = substr($overviewImage['name'], strrpos($overviewImage['name'], '.') + 1);
          list($width, $height) = getimagesize($overviewImage['tmp_name']); 
          if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $trekImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = $width;
            $ImageUpload->NewHeight = $height;
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $overviewImage = $newName.".".strtolower($ext);
          }
          else{
            $status = array(
              'status' => "304",
              'message' => "Failure Please upload jpg,png,gift,jpeg images only"
            );
            return $status;
          }
        }
        $created_date = date("Y-m-d H:i:s");
        $data['trekImage'] = $trekImage;
        $data['overviewImage'] = $overviewImage;
        $data['createdDate'] = $created_date;
        $trekId = $this->repository->insertTrek($data);
        if(!empty($trekId)){          
          $count = 0;
          $data1['description'] = $description;
          $data1['title'] = @$title;
          foreach($data1 as $value){
            $count = sizeof($value); 
          } 
          for($x = 0;$x < $count;$x++){
            $data1['trekId'] = $trekId;
            $data1['description'] = $description[$x];
            $data1['title'] = @$title[$x];
            $data1['createdDate'] = $created_date;
            $data1['createdBy'] = $created_by;
            $data1['status'] = $status;
            $iterinary = $this->repository->addTrekIterinaryDetails($data1);
          }
          if(isset($pumpupImage['name'])&&!empty($pumpupImage['name'])){
            $filedir = UPLOADPATH."treks/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "trekpumpup_". $randName;
            $ext = substr($pumpupImage['name'], strrpos($pumpupImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($pumpupImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $pumpupImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $pumpupImage = $newName.".".strtolower($ext);
            }else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($bfImage['name'])&&!empty($bfImage['name'])){
            $filedir = UPLOADPATH."treks/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "trekbf_". $randName;
            $ext = substr($bfImage['name'], strrpos($bfImage['name'], '.') + 1);
            list($width, $height) = getimagesize($bfImage['tmp_name']);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){ 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $bfImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $bfImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($lunchImage['name'])&&!empty($lunchImage['name'])){
            $filedir = UPLOADPATH."treks/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "treklunchImage_". $randName;
            $ext = substr($lunchImage['name'], strrpos($lunchImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($lunchImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $lunchImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $lunchImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($evngImage['name'])&&!empty($evngImage['name'])){
            $filedir = UPLOADPATH."treks/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "trekevngImage_". $randName;
            $ext = substr($evngImage['name'], strrpos($evngImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($evngImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $evngImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $evngImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          $data['pumpupImage'] = $pumpupImage;
          $data['bfImage'] = $bfImage;
          $data['lunchImage'] = $lunchImage;
          $data['evngImage'] = $evngImage;
          $data['trekId'] = $trekId;
          $foodMenu = $this->repository->addTrekFoodmenu($data);
          $status = array(
                    'status' => "200",
                    'message' => "Treks Details Added Successfully",
                    'trek_id' => $trekId
                    );
        } else {
          $status = array(
                    'status' => "304",
                    'message' => "Treks Details Not Added Successfully");
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