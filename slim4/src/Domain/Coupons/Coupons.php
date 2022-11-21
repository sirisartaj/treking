<?php
namespace App\Domain\Coupons;

use App\Domain\Coupons\CouponsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Coupons
{
  /**
   * @var CouponsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param CouponsRepository $repository The repository
   */
  public function __construct(CouponsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getCoupons(): array
  {        
    $Coupons = $this->repository->getCoupons();
    return $Coupons;
  }
  public function addCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
      'status' => "206",
      'message' => "Failure couponname is required"
      );
    }elseif(empty($couponCode)){
      $status = array(
      'status' => "206",
      'message' => "Failure couponcode is required"
      );
    }else{
      $couponnameExist = $this->repository->checkCouponName($couponName);
      $couponcodeExist = $this->repository->checkCouponCode($couponCode);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->addCoupon($data);   
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
         }     
      }else{
        $status = array(
                'status' => "208",
                'message' => "Coupon name already exist"
                );
      }
    }
    return $status;
  }
  public function getCoupon($data) {
    $Coupons = $this->repository->getCoupon($data);
    return $Coupons;
  }
  public function updateCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
                'status' => "206",
                'message' => "Failure couponname is required"
                );
    }elseif(empty($couponCode)){
      $status = array(
                'status' => "206",
                'message' => "Failure couponcode is required"
                );
    }else{
      $couponnameExist = $this->repository->checkNameCoupon($couponName,$couponId);
      $couponcodeExist = $this->repository->checkCodeCoupon($couponCode,$couponId);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->updateCoupon($data);
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
        }  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Failure coupon name exist"
                );
      }
    }
    return $status;
  }
  public function deleteCoupon($data) {
    $Coupons = $this->repository->deleteCoupon($data);
    return $Coupons;
  }
  public function updateCouponStatus($data) {
    $Coupons = $this->repository->updateCouponStatus($data);
    return $Coupons;
  }
  /*
  * Trip Coupons
  */
  public function getTripCoupons(): array
  {        
    $Coupons = $this->repository->getTripCoupons();
    return $Coupons;
  }
  public function addTripCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
      'status' => "206",
      'message' => "Failure couponname is required"
      );
    }elseif(empty($couponCode)){
      $status = array(
      'status' => "206",
      'message' => "Failure couponcode is required"
      );
    }else{
      $couponnameExist = $this->repository->checkTripCouponName($couponName);
      $couponcodeExist = $this->repository->checkTripCouponCode($couponCode);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->addTripCoupon($data);   
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
         }     
      }else{
        $status = array(
                'status' => "208",
                'message' => "Coupon name already exist"
                );
      }
    }
    return $status;
  }
  public function getTripCoupon($data) {
    $Coupons = $this->repository->getTripCoupon($data);
    return $Coupons;
  }
  public function updateTripCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
                'status' => "206",
                'message' => "Failure couponname is required"
                );
    }elseif(empty($couponCode)){
      $status = array(
                'status' => "206",
                'message' => "Failure couponcode is required"
                );
    }else{
      $couponnameExist = $this->repository->checkTripNameCoupon($couponName,$couponId);
      $couponcodeExist = $this->repository->checkTripCodeCoupon($couponCode,$couponId);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->updateTripCoupon($data);
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
        }  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Failure coupon name exist"
                );
      }
    }
    return $status;
  }
  public function deleteTripCoupon($data) {
    $Coupons = $this->repository->deleteTripCoupon($data);
    return $Coupons;
  }
  public function updateTripCouponStatus($data) {
    $Coupons = $this->repository->updateTripCouponStatus($data);
    return $Coupons;
  }
  /*
  * Expedition Coupons
  */
  public function getExpeditionCoupons(): array
  {        
    $Coupons = $this->repository->getExpeditionCoupons();
    return $Coupons;
  }
  public function addExpeditionCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
      'status' => "206",
      'message' => "Failure couponname is required"
      );
    }elseif(empty($couponCode)){
      $status = array(
      'status' => "206",
      'message' => "Failure couponcode is required"
      );
    }else{
      $couponnameExist = $this->repository->checkExpeditionCouponName($couponName);
      $couponcodeExist = $this->repository->checkExpeditionCouponCode($couponCode);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->addExpeditionCoupon($data);   
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
         }     
      }else{
        $status = array(
                'status' => "208",
                'message' => "Coupon name already exist"
                );
      }
    }
    return $status;
  }
  public function getExpeditionCoupon($data) {
    $Coupons = $this->repository->getExpeditionCoupon($data);
    return $Coupons;
  }
  public function updateExpeditionCoupon($data) {
    extract($data);
    if(empty($couponName))
    {
       $status = array(
                'status' => "206",
                'message' => "Failure couponname is required"
                );
    }elseif(empty($couponCode)){
      $status = array(
                'status' => "206",
                'message' => "Failure couponcode is required"
                );
    }else{
      $couponnameExist = $this->repository->checkExpeditionNameCoupon($couponName,$couponId);
      $couponcodeExist = $this->repository->checkExpeditionCodeCoupon($couponCode,$couponId);
      if ($couponnameExist == '0')
      {
        if ($couponcodeExist=='0') {
          if(isset($couponImage)&&!empty($couponImage)){
            $filedir = UPLOADPATH."coupons/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "coupon_". $randName;
            $ext = substr($couponImage['name'], strrpos($couponImage['name'], '.') + 1);
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $couponImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = '100';
            $ImageUpload->NewHeight = '100';
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $couponImage = $newName.".".strtolower($ext);
          }
          $data['couponImage'] = $couponImage;
          $status = $this->repository->updateExpeditionCoupon($data);
        }else {
          $status = array(
                    'status' => "208",
                    'message' => "Failure coupon code exist"
                );
        }  
      }else{
       $status = array(
                    'status' => "208",
                    'message' => "Failure coupon name exist"
                );
      }
    }
    return $status;
  }
  public function deleteExpeditionCoupon($data) {
    $Coupons = $this->repository->deleteExpeditionCoupon($data);
    return $Coupons;
  }
  public function updateExpeditionCouponStatus($data) {
    $Coupons = $this->repository->updateExpeditionCouponStatus($data);
    return $Coupons;
  }
}