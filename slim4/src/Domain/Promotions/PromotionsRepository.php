<?php
namespace App\Domain\Promotions;
use PDO;
/**
* Repository.
*/
class PromotionsRepository
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
  public function getPromotions() {
    try {
      $query = "SELECT `promotion_id` AS promotionId, `promotion_title` AS promotionTitle, `promotion_image` AS promotionImage, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM sg_promotions";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $promotionsdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($promotionsdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'promotionsdetails' => $promotionsdetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"Failure");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getPromotion($data) {
    try {
      extract($data);
      $query = "SELECT `promotion_id` AS promotionId, `promotion_title` AS promotionTitle, `promotion_image` AS promotionImage, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM sg_promotions WHERE promotion_id = :promotion_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':promotion_id', $promotion_id);
      $stmt->execute();
      $promotionsdetails  = $stmt->fetch(PDO::FETCH_OBJ);
      if($promotionsdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'promotionsdetails' => $promotionsdetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"Failure");
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addPromotion($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_promotions SET promotion_title=:promotion_title, promotion_image=:promotion_image,  status = :status , created_date = :created_date, created_by = :created_by";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':promotion_title', $promotionTitle);
      $stmt->bindParam(':promotion_image', $promotionImage);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $createdBy);
      $stmt->execute();
      $promotion_id = $this->connection->lastInsertId();
      if($promotion_id!=''){
        $status = array(
          'status' => '200',
          'message' => 'Added Successfully',
          'promotion_id' => $promotion_id);
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Not Added Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updatePromotion($data) {
    try {
      extract($data);
      $query = "UPDATE sg_promotions SET promotion_title=:promotion_title, promotion_image=:promotion_image,  status = :status , modified_date = :modified_date, modified_by = :modified_by where promotion_id=:promotion_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':promotion_title', $promotionTitle);
      $stmt->bindParam(':promotion_image', $promotionImage);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $createdBy);
      $stmt->bindParam(':promotion_id' , $promotionId);
      $res = $stmt->execute();
      if($res=='true') {
        $status = array(
          'status' => '200',
          'message' => 'Updated Successfully');
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Not Updated Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updatePromotionStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_promotions SET  status = :status , modified_date = :modified_date, modified_by = :modified_by where promotion_id=:promotion_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $createdBy);
      $stmt->bindParam(':promotion_id' , $promotionId);
      $res = $stmt->execute();
      if($res=='true') {
        $status = array(
          'status' => '200',
          'message' => 'Updated Successfully');
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Not Updated Successfully"
              );
      }
      return $status;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}