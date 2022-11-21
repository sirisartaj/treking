<?php
namespace App\Domain\Faq;
use PDO;
/**
* Repository.
*/
class FaqRepository
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
  public function getFaqCategories(): array
  {      
    try {
      $sql = "SELECT `faq_cat_id` AS faqCatId, `category_title` AS categoryTitle, `status`, `created_by` AS createdBy, `created_date` AS createdDate, `modified_by` AS modifiedBy, `modified_date` AS modifiedDate FROM `sg_faq_categories` WHERE status = '0' ";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $Faq = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($Faq)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'faq_categories' => $Faq);
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
}