<?php
namespace App\Domain\Pages;
use PDO;
/**
* Repository.
*/
class PagesRepository
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
  public function getPages() {
    try {
      $query = "SELECT `page_id` AS pageId, `page_title` AS pageTitle, `page_description` AS pageDescription, `page_status` AS status, `page_image` AS pageImage, `image_type` AS imageType, `created_date` AS createdDate, `modified_date` AS modifiedDate, `createdby` AS createdBy, `modifiedby` AS modifiedBy FROM sg_pages";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $pages = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($pages)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'pages' => $pages);
        return $status;
      }else{
        $status = array('status'=>"204",
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
  public function getPageDetails($data) {
    try {
      extract($data);
      $query = "SELECT page_id AS pageId, page_title AS pageTitle, page_description AS pageDescription FROM sg_pages WHERE page_id = :page_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);  
      $stmt->bindParam(':page_id',$id);  
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'pages' => $res);
        return $status;
      }else{
        $status = array('status'=>"204",
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
  public function updatePage($data) {
    try {
      extract($data);
      $modified_date = date("Y-m-d H:i:s");
  $sql  = "UPDATE sg_pages SET page_title=:page_title, page_description=:page_description,modified_date = :modified_date WHERE page_id = :page_id";
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}