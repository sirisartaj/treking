<?php
namespace App\Domain\LeisurePackages;

use App\Domain\LeisurePackages\LeisurePackagesRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class LeisurePackages
{
  /**
   * @var LeisurePackagesRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param LeisurePackagesRepository $repository The repository
   */
  public function __construct(LeisurePackagesRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getLeisurePackages(): array
  {        
    $LeisurePackages = $this->repository->getLeisurePackages();
    return $LeisurePackages;
  }
  public function addLeisurePackage($data) {
    extract($data);
    if(isset($packageImage)&&!empty($packageImage)){
      $filedir = UPLOADPATH."packages/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "pkg_". $randName;
      $ext = substr($packageImage['name'], strrpos($packageImage['name'], '.') + 1);
      list($width, $height) = getimagesize($packageImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $packageImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $packageImage = $newName.".".strtolower($ext);
    }
    else {
      $packageImage = $packageImage;
    }
    if(isset($hotelImage)&&!empty($hotelImage)){
      $filedir = UPLOADPATH."packages/hotel/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "pkg_". $randName;
      $ext = substr($hotelImage['name'], strrpos($hotelImage['name'], '.') + 1);
      list($width, $height) = getimagesize($hotelImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $hotelImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $hotelImage = $newName.".".strtolower($ext);
    }
    else {
      $hotelImage = $hotelImage;
    }
    $data['packageImage'] = $packageImage;
    $data['hotelImage'] = $hotelImage;
    $LeisurePackages = $this->repository->addLeisurePackage($data);
    return $LeisurePackages;
  }
  public function updateLeisurePackage($data) {
    extract($data);
    if(isset($packageImage)&&!empty($packageImage)){
      $filedir = UPLOADPATH."packages/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "pkg_". $randName;
      $ext = substr($packageImage['name'], strrpos($packageImage['name'], '.') + 1);
      list($width, $height) = getimagesize($packageImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $packageImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $packageImage = $newName.".".strtolower($ext);
    }
    else {
      $packageImage = $packageImage;
    }
    if(isset($hotelImage)&&!empty($hotelImage)){
      $filedir = UPLOADPATH."packages/hotel/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "pkg_". $randName;
      $ext = substr($hotelImage['name'], strrpos($hotelImage['name'], '.') + 1);
      list($width, $height) = getimagesize($hotelImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $hotelImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $hotelImage = $newName.".".strtolower($ext);
    }
    else {
      $hotelImage = $hotelImage;
    }
    $data['packageImage'] = $packageImage;
    $data['hotelImage'] = $hotelImage;
    $LeisurePackages = $this->repository->updateLeisurePackage($data);
    return $LeisurePackages;
  }
  public function getLeisurePackage($data): array
  {        
    $LeisurePackages = $this->repository->getLeisurePackage($data);
    return $LeisurePackages;
  }
  public function updateLeisurePackageStatus($data) {
    $LeisurePackages = $this->repository->updateLeisurePackageStatus($data);
    return $LeisurePackages;
  }
  public function addAddOnActivity($data) {
    $LeisurePackages = $this->repository->addAddOnActivity($data);
    return $LeisurePackages;
  }
  public function updateAddOnActivity($data) {
    $LeisurePackages = $this->repository->updateAddOnActivity($data);
    return $LeisurePackages;
  }
  public function getAddOnActivity($data) {
    $LeisurePackages = $this->repository->getAddOnActivity($data);
    return $LeisurePackages;
  }
  public function updateAddOnActivityStatus($data) {
    $LeisurePackages = $this->repository->updateAddOnActivityStatus($data);
    return $LeisurePackages;
  }
}