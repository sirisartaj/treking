<?php
namespace App\Domain\CelebrityTrips;

use App\Domain\CelebrityTrips\CelebrityTripsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class CelebrityTrips
{
  /**
   * @var CelebrityTripsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param CelebrityTripsRepository $repository The repository
   */
  public function __construct(CelebrityTripsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getCelebrityTrips(): array
  {        
    $CelebrityTrips = $this->repository->getCelebrityTrips();
    return $CelebrityTrips;
  }
  public function getTripEnquiries(): array
  {        
    $CelebrityTrips = $this->repository->getTripEnquiries();
    return $CelebrityTrips;
  }
  public function addTrip($data) {
    extract($data);
    if(isset($celebritytripImage)&&!empty($celebritytripImage)){
      $filedir = UPLOADPATH."celebritytrips/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "trek_". $randName;
      $ext = substr($celebritytripImage['name'], strrpos($celebritytripImage['name'], '.') + 1);
      list($width, $height) = getimagesize($celebritytripImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $celebritytripImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $celebritytripImage = $newName.".".strtolower($ext);
    }
    $expert = $this->repository->addTrip($data);
    return $expert; 
  }
  public function getCelebrityTrip($data) {
    $expert = $this->repository->getCelebrityTrip($data);
    return $expert; 
  }
  public function updateTrip($data) {
    extract($data);
    if(isset($celebritytripImage)&&!empty($celebritytripImage)){
      $filedir = UPLOADPATH."celebritytrips/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "trek_". $randName;
      $ext = substr($celebritytripImage['name'], strrpos($celebritytripImage['name'], '.') + 1);
      list($width, $height) = getimagesize($celebritytripImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $celebritytripImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $celebritytripImage = $newName.".".strtolower($ext);
    }
    $expert = $this->repository->updateTrip($data);
    return $expert; 
  }
  public function updateTripStatus($data) {
    $expert = $this->repository->updateTripStatus($data);
    return $expert; 
  }
}