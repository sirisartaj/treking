<?php
namespace App\Domain\Rentals;
use PDO;
/**
* Repository.
*/
class RentalsRepository
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
  public function getRentalItems() {
    try {
      $query = "SELECT `item_id` AS itemID, `item_name` AS itemName, `item_code` AS itemCode, concat('".SITEURL."uploads/rentals/', `image_1`) AS image_1, `image_2`, `image_3`, `image_4`, `rental_category` AS category, `non_returnable` AS nonReturnable, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` As createdBy, `modified_by` As modifiedBy, `item_description` FROM `sg_rental_items` WHERE 1";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $Rentalsdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($Rentalsdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'Rentals' => $Rentalsdetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data");
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
  public function addRentalItem($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_rental_items`(`item_name`, `item_code`, `image_1`, `image_2`, `image_3`, `image_4`, `rental_category`, `non_returnable`, `status`, `created_date`, `created_by`, `item_description`) VALUES (:item_name, :item_code, :image_1, :image_2, :image_3, :image_4, :rental_category, :non_returnable, :status, :created_date, :created_by, :item_description)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':item_name', $itemName);
      $stmt->bindParam(':item_code', $itemCode);
      $stmt->bindParam(':item_description', $itemDescription);
      $stmt->bindParam(':image_1', $image_1);
      $stmt->bindParam(':image_2', $image_2);
      $stmt->bindParam(':image_3', $image_3);
      $stmt->bindParam(':image_4', $image_4);
      $stmt->bindParam(':rental_category', $rentalCategory);
      $stmt->bindParam(':non_returnable', $nonReturnable);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $createdBy);
      $stmt->execute();
      $promotion_id = $this->connection->lastInsertId();
      if($promotion_id!='' && $promotion_id != '0'){
        $status = array(
          'status' => '200',
          'message' => 'Added Successfully',
          'rental_id' => $promotion_id);
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
  public function updateRentalItem($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_rental_items` SET `item_name`=:item_name, `item_code`=:item_code,`image_1`=:image_1,`image_2`=:image_2,`image_3`=:image_3,`image_4`=:image_4,`rental_category`= :rental_category,`non_returnable`= :non_returnable,`status`=:status, `modified_date`= :modified_date, `modified_by`=:modified_by,`item_description`=:item_description where item_id=:item_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':item_name', $itemName);
      $stmt->bindParam(':item_code', $itemCode);
      $stmt->bindParam(':item_description', $itemDescription);
      $stmt->bindParam(':image_1', $image_1);
      $stmt->bindParam(':image_2', $image_2);
      $stmt->bindParam(':image_3', $image_3);
      $stmt->bindParam(':image_4', $image_4);
      $stmt->bindParam(':rental_category', $rentalCategory);
      $stmt->bindParam(':non_returnable', $nonReturnable);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':item_id' , $itemId);
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
  public function getRentalItemDetails($data) {
    try {
      extract($data);
      $query = "SELECT `item_id` AS itemID, `item_name` AS itemName, `item_code` AS itemCode, `image_1`, `image_2`, `image_3`, `image_4`, `rental_category` AS category, `non_returnable` AS nonReturnable, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` As createdBy, `modified_by` As modifiedBy, `item_description` FROM `sg_rental_items` WHERE item_id = $rental_id";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $Rentalsdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($Rentalsdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'RentalDetails' => $Rentalsdetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data");
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
  public function deleteRentalItem($data) {
    try {
      extract($data);
      $modified_date = date("Y-m-d H:i:s");
      $query = "UPDATE `sg_rental_items` SET `status` = '9',`modified_date`=:modified_date, `modified_by`=:modified_by WHERE item_id = $id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $createdBy);
      $res = $stmt->execute();
      if($res=='true') {
        $status = array(
          'status' => '200',
          'message' => 'Deleted Successfully');
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Not Deleted Successfully"
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
  public function updateRentalItemStatus($data) {
    try {
      extract($data);
      $modified_date = date("Y-m-d H:i:s");
      $query = "UPDATE `sg_rental_items` SET `status` = :status, `modified_date`=:modified_date, `modified_by`=:modified_by WHERE item_id = :item_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status' , $status);
      $stmt->bindParam(':item_id' , $itemId);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
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