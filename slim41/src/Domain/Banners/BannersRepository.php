<?php
namespace App\Domain\Banners;
use PDO;
/**
* Repository.
*/
class BannersRepository
{
  /**
   * @var PDO The database connection
   */
  private $connection;
  /**
   * Constructor.
   *
   * @param PDO $connection The database connection
   */
  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }
  /**
   * Get Admin Roles rows.
   *
   * @return array 
   */
  public function getBanners(): array
  {      
    try {
      $sql = "SELECT banner_id AS bannerId, banner_title AS bannerTitle, CONCAT('".UPLOADURL."banners/', `banner_image`) AS bannerImage, target_url AS targetUrl, status, created_date AS createdDate, updated_date AS updatedDate, created_by AS createdBy, modified_by AS modifiedBy FROM  sg_bannerdetails";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $banners = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($banners)){
       $status = array(
         'status' =>ERR_OK,
         'message' =>"Success",
         'banners' => $banners);
         return $status;
      }else{
        $status = array('status'=>ERR_NO_DATA,
         'message'=>"No Data Found");
         return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBanner($data) {
    try {
      extract($data);
      $sql = "SELECT banner_id AS bannerId, banner_title AS bannerTitle, CONCAT('".UPLOADURL."banners/', `banner_image`) AS bannerImage, target_url AS targetUrl, status, created_date AS createdDate, updated_date AS updatedDate, created_by AS createdBy, modified_by AS modifiedBy FROM ".DBPREFIX."_bannerdetails WHERE banner_id=:banner_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":banner_id", $bannerId); 
      $stmt->execute();
      $bannerdetails = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($bannerdetails)){
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success",
                  'banner' => $bannerdetails);
        return $status;
      }else{
        $status = array('status'=>ERR_NO_DATA,
         'message'=>"No Data Found");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function deleteBanner($data) {    
    try {
      $sql = "DELETE FROM ".DBPREFIX."_bannerdetails WHERE banner_id = :banner_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":banner_id",$bannerId);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => ERR_OK,
          "message" => "Deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Not Deleted Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function addBanner($data) {
    try {
      
      extract($data);
      $sql = "INSERT INTO ".DBPREFIX."_bannerdetails SET banner_title=:banner_title, banner_image=:banner_image , target_url = :target_url, status = :status , created_date = :created_date, created_by = :created_by";
      $stmt = $this->connection->prepare($sql);  
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(":banner_title", $bannerTitle); 
      $stmt->bindParam(":banner_image", $bannerImage);
      $stmt->bindParam(":target_url", $targetUrl);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$userBy);
      $res = $stmt->execute();
      $banner_id = $this->connection->lastInsertId();
      if($banner_id != ''  && $banner_id != '0'){
        $status = array(
          "status" => ERR_OK,
          "message" => "Added Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Not Added Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBanner($data) 
  {
    try {
      $sql  = "UPDATE ".DBPREFIX."_bannerdetails SET banner_title=:banner_title, banner_image=:banner_image, target_url=:target_url , status = :status ,updated_date = :updated_date, modified_by = :modified_by WHERE banner_id = :banner_id";   
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");  
      $stmt->bindParam(":banner_title", $bannerTitle); 
      $stmt->bindParam(":banner_image", $bannerImage);
      $stmt->bindParam(":target_url", $targetUrl);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":updated_date",$modified_date);
      $stmt->bindParam(":modified_by",$userBy);
      $stmt->bindParam(":banner_id", $bannerId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => ERR_OK,
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function updateBannerStatus($data) {    
    try {
      $sql = "UPDATE sg_bannerdetails SET status=:status, modified_by=:modified_by WHERE banner_id = :banner_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":banner_id",$bannerId);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":modified_by",$userBy);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => ERR_OK,
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Not Updated Successfully");
        return $status;
      }
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
}