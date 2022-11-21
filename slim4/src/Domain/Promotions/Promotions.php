<?php
namespace App\Domain\Promotions;

use App\Domain\Promotions\PromotionsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Promotions
{
  /**
   * @var PromotionsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param PromotionsRepository $repository The repository
   */
  public function __construct(PromotionsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getPromotions(): array
  {        
    $Promotions = $this->repository->getPromotions();
    return $Promotions;
  }
  public function getPromotion($data): array
  {        
    $Promotions = $this->repository->getPromotion($data);
    return $Promotions;
  }
  public function addPromotion($data) {
    extract($data);
    if(isset($_FILES['promotionImage'])&&!empty($_FILES['promotionImage'])){
      $filedir = UPLOADPATH."promotion/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "promotion_". $randName;
      $ext = substr($_FILES['promotionImage']['name'], strrpos($_FILES['promotionImage']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['promotionImage']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['promotionImage'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $promotionImage = $newName.".".strtolower($ext);
    }
    else {
      $promotionImage = $promotionImage;
    }
    $data['promotionImage'] = $promotionImage;
    $Promotions = $this->repository->addPromotion($data);
    return $Promotions;
  }
  public function updatePromotion($data) {
    extract($data);
    if(isset($_FILES['promotionImage'])&&!empty($_FILES['promotionImage'])){
      $filedir = UPLOADPATH."promotion/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "promotion_". $randName;
      $ext = substr($_FILES['promotionImage']['name'], strrpos($_FILES['promotionImage']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['promotionImage']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['promotionImage'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $promotionImage = $newName.".".strtolower($ext);
    }
    else {
      $promotionImage = $promotionImage;
    }
    $data['promotionImage'] = $promotionImage;
    $Promotions = $this->repository->updatePromotion($data);
    return $Promotions;
  }
  public function updatePromotionStatus($data) {
    $Promotions = $this->repository->updatePromotionStatus($data);
    return $Promotions;
  }
}