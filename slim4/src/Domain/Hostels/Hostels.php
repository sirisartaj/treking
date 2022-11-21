<?php
namespace App\Domain\Hostels;

use App\Domain\Hostels\HostelsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Hostels
{
  /**
   * @var HostelsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param HostelsRepository $repository The repository
   */
  public function __construct(HostelsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getHostels(): array
  {        
    $Hostels = $this->repository->getHostels();
    return $Hostels;
  }
  public function getHostelDetails($data): array 
  {
    $Hostels = (array) $this->repository->getHostelDetails($data);
    return $Hostels;
  }
  public function addHostel($data) : array 
  {
    try {
      extract($data);
      if(isset($hostelImage)&&!empty($hostelImage)){
        $filedir = UPLOADPATH."hostels/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "hostel_". $randName;
        $ext = substr($hostelImage['name'], strrpos($hostelImage['name'], '.') + 1);
        list($width, $height) = getimagesize($hostelImage['tmp_name']); 
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $hostelImage;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = $width;
        $ImageUpload->NewHeight = $height;
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $hostelImage = $newName.".".strtolower($ext);
      }
      else {
        $hostelImage = $hostelImage;
      }
      $data['hostelImage'] = $hostelImage;
      $res = $this->repository->addHostel($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateHostel($data) : array 
  {
    try {
      extract($data);
      if(isset($hostelImage)&&!empty($hostelImage)){
        $filedir = UPLOADPATH."hostels/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "hostel_". $randName;
        $ext = substr($hostelImage['name'], strrpos($hostelImage['name'], '.') + 1);
        list($width, $height) = getimagesize($hostelImage['tmp_name']); 
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $hostelImage;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = $width;
        $ImageUpload->NewHeight = $height;
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $hostelImage = $newName.".".strtolower($ext);
      }
      else {
        $hostelImage = $hostelImage;
      }
      $data['hostelImage'] = $hostelImage;
      $res = $this->repository->updateHostel($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function addHostelEnquiry($data) {
    $res = $this->repository->addHostelEnquiry($data);
    return $res;     
  }
  public function addHostelGallery($data) {
    extract($data);
    if(isset($hostelImage)&&!empty($hostelImage)){
      $filedir = UPLOADPATH."hostels/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "hostel_". $randName;
      $ext = substr($hostelImage['name'], strrpos($hostelImage['name'], '.') + 1);
      list($width, $height) = getimagesize($hostelImage['tmp_name']); 
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $hostelImage;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = $width;
      $ImageUpload->NewHeight = $height;
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $hostelImage = $newName.".".strtolower($ext);
    }
    else {
      $hostelImage = $hostelImage;
    }
    $data['hostelImage'] = $hostelImage;
    $res = $this->repository->addHostelGallery($data);
    return $res;
  }
  public function getHostelEnquiries() {
    $res = $this->repository->getHostelEnquiries();
    return $res;
  }
  public function getHostelEnquiryId($data) {
    $res = $this->repository->getHostelEnquiryId($data);
    return $res;
  }
  public function getHostelGallery() {
    $res = $this->repository->getHostelGallery();
    return $res;
  }
  public function updateHostelStatus($data) {
    $res = $this->repository->updateHostelStatus($data);
    return $res;
  }
}