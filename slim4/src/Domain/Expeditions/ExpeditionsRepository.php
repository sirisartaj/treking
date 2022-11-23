<?php
namespace App\Domain\Expeditions;
use PDO;
/**
* Repository.
*/
class ExpeditionsRepository
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
  public function getExpeditions(): array
  {      
    try {
      $query = "SELECT * FROM sg_expeditions t WHERE (t.status!='9' or t.status is NULL)";
      
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);

      if(!empty($results)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'allexpeditions' => $results);
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

  public function getItineraryExpedition($data): array
  {    
    try {
      extract($data);
       $query = "SELECT * FROM sg_expeditioniterinarydetails t WHERE (t.recordstatus !='9' or t.recordstatus IS NULL) and t.expedition_id ='".$expedition_id."'";
      
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);

      if(!empty($results)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'allexpeditions' => $results);
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
  public function insertExpedition($data) {
    try {
      extract($data);
      $sql = "INSERT INTO sg_expeditions (expedition_title, expedition_fee, visit_time, time_visit, expedition_overview, expedition_days, expedition_nights, region, expeditionvideo_title, expeditionvideo_url, season, things_carry, overview_image, expedition_image, gst, map_image, temperature, terms, faq, popular_expedition, meta_title, meta_desc, altitude, status, created_date, created_by)VALUES(:expedition_title, :expedition_fee, :difficult, :time_visit, :expedition_overview, :expedition_days, :expedition_nights, :region, :expeditionvideo_title, :expeditionvideo_url, :season, :things_carry, :overview_image, :expedition_image, :gst, :map_image, :temperature, :terms, :faq, :popular_expedition, :meta_title, :meta_desc, :altitude, :status, :created_date, :created_by)";
      $stmt = $this->connection->prepare($sql);         
      $season_details = implode(",",$season);
      $stmt->bindParam(':expedition_title', $expeditionTitle);
      $stmt->bindParam(':expedition_fee', $expeditionFee);
      $stmt->bindParam(':difficult', $difficult);
      $stmt->bindParam(':time_visit',$timeVisit);
      $stmt->bindParam(':expedition_overview',$expeditionOverview);
      $stmt->bindParam(':expedition_days', $expeditionDays);
      $stmt->bindParam(':expedition_nights', $expeditionNights);
      $stmt->bindParam(':region', $region);
      $stmt->bindParam(':expeditionvideo_title', $expeditionVideoTitle);
      $stmt->bindParam(':expeditionvideo_url', $expeditionVideoUrl);
      $stmt->bindParam(':season',$seasonDetails);
      $stmt->bindParam(':things_carry', $thingsCarry);
      $stmt->bindParam(':expedition_image', $expeditionImage);
      $stmt->bindParam(':overview_image', $overviewImage);
      $stmt->bindParam(':gst', $gst);
      $stmt->bindParam(':map_image', $mapImage);
      $stmt->bindParam(':terms', $terms);
      $stmt->bindParam('faq',$faq);
      $stmt->bindParam(':popular_expedition', $popularExpedition);
      $stmt->bindParam(':temperature',$temperature);
      $stmt->bindParam(':meta_title',$metaTitle);
      $stmt->bindParam(':meta_desc',$metaDesc);
      $stmt->bindParam(':altitude',$altitude);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' , $createdDate);
      $stmt->bindParam(':created_by' , $createdBy);
      $stmt->execute();
      $expedition_id = $this->connection->lastInsertId();
      return $expedition_id;     
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addExpeditionIterinaryDetails($data) {
    try {
      extract($data);
      $query2 = "INSERT INTO ".DBPREFIX."_expeditioniterinarydetails SET iterinary_title=:iterinary_title, iterinary_details=:iterinary_details,expedition_id = :expedition_id,created_date = :created_date,created_by=:created_by,recordstatus=:status";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->bindParam(':iterinary_title',$title);
      $stmt2->bindParam(':iterinary_details',$description);
      $stmt2->bindParam(':expedition_id',$expeditionId);
      $stmt2->bindParam(':created_date',$createdDate);
      $stmt2->bindParam(':created_by',$createdBy);
      $stmt2->bindParam(':status',$status);
      return $stmt2->execute();
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  
  public function checkExpeditionName($expeditionName) {
    $sql = "SELECT count(`expedition_id`) as cnt FROM sg_expeditions where `expedition_title`='$expeditionName'and status!='9'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_OBJ);
    $cnt = $count->cnt;
    return $cnt;
  }
  public function updateExpedition($data) {
    
    try {
      extract($data);
      $query = "UPDATE sg_expeditions  SET expedition_title=:expedition_title , expedition_overview = :expedition_overview, things_carry = :things_carry,map_image = :map_image, terms = :terms, status = '0',modified_date = :modified_date,modified_by=:modified_by WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);      
      
      $stmt->bindParam(':expedition_title', $expedition_title);      
      $stmt->bindParam(':expedition_overview',$expedition_overview);      
      $stmt->bindParam(':things_carry', $things_carry);      
      $stmt->bindParam(':map_image', $map_image);
      $stmt->bindParam(':terms', $terms);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $modified_by);
      $stmt->bindParam(':expedition_id' , $expedition_id);
      return $res = $stmt->execute();
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateExpeditionIterinaryDetails($data) {
    try {

      extract($data);
      if(@$data['id']){
          $query2 = "UPDATE sg_expeditioniterinarydetails set iterinary_details=:iterinary_details,iterinary_title=:iterinary_title,modified_date=:modified_date,modified_by=:modified_by where iterinary_id =:iterinary_id";
          $stmt2 = $this->connection->prepare($query2);
          $stmt2->bindParam(':iterinary_details', $iterinary_details);
          $stmt2->bindParam(':iterinary_title',$iterinary_title);
          $stmt2->bindParam(':iterinary_id', $iterinary_id);
          $stmt2->bindParam(':modified_date', $modified_date);
          $stmt2->bindParam(':modified_by', $modified_by);
          
          $res = $stmt2->execute();
          if($res){
          $status = array(
                'status' => "200",
                'message' => "updated"
            );
        }
      } 
      else {
        $query3 = "INSERT INTO sg_expeditioniterinarydetails SET iterinary_title=:iterinary_title, iterinary_details=:iterinary_details ,expedition_id = :expedition_id,created_date = :created_date,created_by=:created_by,recordstatus='0'";
        $stmt3 = $this->connection->prepare($query3);
        $stmt3->bindParam(':iterinary_title',$iterinary_title);
        $stmt3->bindParam(':iterinary_details', $iterinary_details);
        $stmt3->bindParam(':expedition_id', $expedition_id);
        $stmt3->bindParam(':created_date', $modified_date);
        $stmt3->bindParam(':created_by', $modified_by);
        $res = $stmt3->execute();
        if($res){
          $status = array(
                'status' => "200",
                'message' => "Added"
            );
        }
      }
     
      
      return $status;
      }
    catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  
  public function checkExpedition($expeditionname,$expeditionid)
  {
    $sql = "SELECT count(`expedition_id`) as cnt FROM sg_expeditions where `expedition_title`='$expeditionname'and expedition_id!='$expeditionid'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_OBJ);
    $cnt = $count->cnt;
    return $cnt;
  }
  public function getExpedition($data) {    
    try {

      extract($data);
      $query = "SELECT *  FROM sg_expeditions WHERE expedition_id = :expedition_id and (status!='9' or status is NULL)";
      $stmt = $this->connection->prepare( $query );
      $stmt->bindParam(':expedition_id', $expedition_id);
      $stmt->execute();
      $res['expeditions'] = $stmt->fetch(PDO::FETCH_OBJ);
      $query2 = "SELECT iterinary_id AS iterinaryId, iterinary_title AS iterinaryTitle, iterinary_details AS iterinaryDetails, expedition_id AS expeditionId, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy, recordstatus FROM sg_expeditioniterinarydetails where expedition_id = :expedition_id and recordstatus!='9'";
      $stmt2 = $this->connection->prepare( $query2 );
      $stmt2->bindParam(':expedition_id', $expeditionId);
      $stmt2->execute();
      $res['expedition_iternerary'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
      $query3 = "SELECT foodmenu_id AS foodmenuId, expedition_id AS expeditionIid, pumpup_calories AS pumpupCalories, CONCAT('".UPLOADURL."expeditions/food/',`pumpup_image`) AS pumpupImage, pumpupmenu_desc AS pumpupMenuDesc,bf_calories AS bfCalories, CONCAT('".UPLOADURL."expeditions/food/',`bf_image`) AS bfImage, bfmenu_desc AS bfMenuDesc, lunch_calories AS lunchCalories, lunchmenu_desc AS lunchMenuDesc, CONCAT('".UPLOADURL."expeditions/food/',`lunch_image`) AS lunchImage, evng_calories AS evngCalories, evng_image AS evngImage, evngmenu_desc AS evngMenuDesc, dinner_calories AS dinnerCalories,CONCAT('".UPLOADURL."expeditions/food/',`dinner_image`) AS dinnerImage, dinnermenu_desc AS dinnerMenuDesc, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy, recordstatus AS status FROM sg_expeditionfoodmenu where expedition_id = :expedition_id and recordstatus!='9'";
      $stmt3 = $this->connection->prepare( $query3 );
      $stmt3->bindParam(':expedition_id', $expeditionId);
      $stmt3->execute();
      $res['expedition_food'] = $stmt3->fetch(PDO::FETCH_ASSOC);
      if(!empty($res)){
        $status = array(
                  'status' => "200",
                  'message' => "Success",
                  'expedition_details' => $res);
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
  public function deleteExpedition($data) {
    try{

      extract($data);
      $query = "UPDATE sg_expeditions SET status='9' where expedition_id=:expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id',$expedition_id);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
        return $status;
      }
    }
    catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function DeleteIterinary($data) {
    try{

      extract($data);
      $query = "UPDATE sg_expeditioniterinarydetails  SET recordstatus='9' , modified_date=:modified_date,modified_by=:modified_by where iterinary_id=:iterinary_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':iterinary_id',$iterinary_id);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by',$modified_by);
      $res = $stmt->execute();
      if($res == 'true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
        return $status;
      }
    }
    catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  
  
}