<?php
namespace App\Domain\Rentals;

use App\Domain\Rentals\RentalsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Rentals
{
  /**
   * @var RentalsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param RentalsRepository $repository The repository
   */
  public function __construct(RentalsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getRentalItems(): array
  {        
    $Rentals = $this->repository->getRentalItems();
    return $Rentals;
  }
  public function getPromotion($data): array
  {        
    $Rentals = $this->repository->getPromotion($data);
    return $Rentals;
  }
  public function addRentalItem($data) {
    extract($data);
    if(isset($_FILES['image_1'])&&!empty($_FILES['image_1'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_1']['name'], strrpos($_FILES['image_1']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_1']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_1'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_1 = $newName.".".strtolower($ext);
    }
    else {
      $image_1 = $image_1;
    }
    $data['image_1'] = $image_1;
    if(isset($_FILES['image_2'])&&!empty($_FILES['image_2'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_2']['name'], strrpos($_FILES['image_2']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_2']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_2'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_2 = $newName.".".strtolower($ext);
    }
    else {
      $image_2 = $image_2;
    }
    $data['image_2'] = $image_2;
    if(isset($_FILES['image_3'])&&!empty($_FILES['image_3'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_3']['name'], strrpos($_FILES['image_3']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_3']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_3'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_3 = $newName.".".strtolower($ext);
    }
    else {
      $image_3 = $image_3;
    }
    $data['image_3'] = $image_3;
    if(isset($_FILES['image_4'])&&!empty($_FILES['image_4'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_4']['name'], strrpos($_FILES['image_4']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_4']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_4'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_4 = $newName.".".strtolower($ext);
    }
    else {
      $image_4 = $image_4;
    }
    $data['image_4'] = $image_4;
    $Rentals = $this->repository->addRentalItem($data);
    return $Rentals;
  }
  public function updateRentalItem($data) {
    extract($data);
    if(isset($_FILES['image_1'])&&!empty($_FILES['image_1'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_1']['name'], strrpos($_FILES['image_1']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_1']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_1'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_1 = $newName.".".strtolower($ext);
    }
    else {
      $image_1 = $image_1;
    }
    $data['image_1'] = $image_1;
    if(isset($_FILES['image_2'])&&!empty($_FILES['image_2'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_2']['name'], strrpos($_FILES['image_2']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_2']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_2'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_2 = $newName.".".strtolower($ext);
    }
    else {
      $image_2 = $image_2;
    }
    $data['image_2'] = $image_2;
    if(isset($_FILES['image_3'])&&!empty($_FILES['image_3'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_3']['name'], strrpos($_FILES['image_3']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_3']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_3'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_3 = $newName.".".strtolower($ext);
    }
    else {
      $image_3 = $image_3;
    }
    $data['image_3'] = $image_3;
    if(isset($_FILES['image_4'])&&!empty($_FILES['image_4'])){
      $filedir = UPLOADPATH."rentals/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "rentals_". $randName;
      $ext = substr($_FILES['image_4']['name'], strrpos($_FILES['image_4']['name'], '.') + 1);
      list($width, $height) = getimagesize($_FILES['image_4']['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $_FILES['image_4'];
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $image_4 = $newName.".".strtolower($ext);
    }
    else {
      $image_4 = $image_4;
    }
    $data['image_4'] = $image_4;
    $Rentals = $this->repository->updateRentalItem($data);
    return $Rentals;
  }
  public function getRentalItemDetails($data) {
    $Rentals = $this->repository->getRentalItemDetails($data);
    return $Rentals;
  }
  public function deleteRentalItem($data) {
    $Rentals = $this->repository->deleteRentalItem($data);
    return $Rentals;
  }
  public function updateRentalItemStatus($data) {
    $Rentals = $this->repository->updateRentalItemStatus($data);
    return $Rentals;
  }
}