<?php
namespace App\Domain\Banners;

use App\Domain\Banners\BannersRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Banners
{
  /**
   * @var BannersRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param BannersRepository $repository The repository
   */
  public function __construct(BannersRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getBanners(): array
  {        
    $Banners = $this->repository->getBanners();
    return $Banners;
  }
  public function getBanner($data): array 
  {
    $Banners = (array) $this->repository->getBanner($data);
    return $Banners;
  }
  public function deleteBanner($data) :array 
  {
    $banner = $this->repository->deleteBanner($data);
    return $banner;
  }
  public function addBanner($data) : array 
  {
    try {
      extract($data);
      if(isset($bannerImage)&&!empty($bannerImage)){
        $filedir = UPLOADPATH."banners/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "banner_". $randName;
        $ext = substr($bannerImage['name'], strrpos($bannerImage['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $bannerImage;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $bannerImage = $newName.".".strtolower($ext);
      }
      $data['bannerImage'] = $bannerImage;
      $res = $this->repository->addBanner($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBanner($data) : array 
  {
    try {
      extract($data);
      if(isset($bannerImage)&&!empty($bannerImage)){
        $filedir = UPLOADPATH."banners/"; 
        $randName = rand(10101010, 9090909090);
        $newName = "banner_". $randName;
        $ext = substr($bannerImage['name'], strrpos($bannerImage['name'], '.') + 1);
        $ImageUpload = new ImageUpload;
        $ImageUpload->File = $bannerImage;
        $ImageUpload->method = 1;
        $ImageUpload->SavePath = $filedir;
        $ImageUpload->NewWidth = '100';
        $ImageUpload->NewHeight = '100';
        $ImageUpload->NewName = $newName;
        $ImageUpload->OverWrite = true;
        $err = $ImageUpload->UploadFile();
        $bannerImage = $newName.".".strtolower($ext);
      }
      $data['bannerImage'] = $bannerImage;
      $res = $this->repository->updateBanner($data);
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBannerStatus($data) {
    $banner = $this->repository->updateBannerStatus($data);
    return $banner;
  }
}