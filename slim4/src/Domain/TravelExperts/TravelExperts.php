<?php
namespace App\Domain\TravelExperts;

use App\Domain\TravelExperts\TravelExpertsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class TravelExperts
{
  /**
   * @var TravelExpertsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param TravelExpertsRepository $repository The repository
   */
  public function __construct(TravelExpertsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getTravelExperts(): array
  {        
    $TravelExperts = $this->repository->getTravelExperts();
    return $TravelExperts;
  }
  public function addTravelExpert($data) {
    extract($data);
    if(isset($expertImage)&&!empty($expertImage)){
      $filedir = UPLOADPATH."travelexperts/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "trekexpert_". $randName;
      $ext = substr($expertImage['name'], strrpos($expertImage['name'], '.') + 1);
      list($width, $height) = getimagesize($expertImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $expertImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $expertImage = $newName.".".strtolower($ext);
    }
    $expert = $this->repository->addTravelExpert($data);
    return $expert; 
  }
  public function getTravelExpert($data) {
    $expert = $this->repository->getTravelExpert($data);
    return $expert; 
  }
  public function updateTravelExpert($data) {
    extract($data);
    if(isset($expertImage)&&!empty($expertImage)){
      $filedir = UPLOADPATH."travelexperts/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "trekexpert_". $randName;
      $ext = substr($expertImage['name'], strrpos($expertImage['name'], '.') + 1);
      list($width, $height) = getimagesize($expertImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $expertImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $expertImage = $newName.".".strtolower($ext);
    }
    $expert = $this->repository->updateTravelExpert($data);
    return $expert; 
  }
  public function deleteTravelExpert($data) {
    $expert = $this->repository->deleteTravelExpert($data);
    return $expert; 
  }
  public function updateTravelExpertStatus($data) {
    $expert = $this->repository->updateTravelExpertStatus($data);
    return $expert;
  }
}