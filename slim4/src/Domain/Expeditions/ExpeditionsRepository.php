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
      $query = "SELECT t.expedition_id as id ,t.expedition_title as name, t.expedition_fee as fee, t.status, (SELECT COUNT(o.ex_org_id) FROM `sg_expeditionorganizersmap` o WHERE o.expedition_id=t.expedition_id AND o.status=0) AS organisers,(SELECT COUNT(c.expeditioncoupon_id) FROM `sg_expeditioncouponsmap` c WHERE c.expedition_id=t.expedition_id AND c.status=0) AS coupons, popular_expedition as popularexpedition FROM sg_expeditions t WHERE t.status!='9'";
      
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
  public function addExpeditionFoodMenu($data) {
    try {
      extract($data);
      $query3 = "INSERT INTO ".DBPREFIX."_expeditionfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc, bf_calories=:bf_calories, bf_image = :bf_image, bfmenu_desc = :bfmenu_desc, lunch_calories = :lunch_calories,  lunch_image=:lunch_image, lunchmenu_desc = :lunchmenu_desc, evng_calories = :evng_calories,expedition_id = :expedition_id, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc, dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,created_date = :created_date, created_by=:created_by, recordstatus=:recordstatus";
      $stmt3 = $this->connection->prepare($query3);
      $stmt3->bindParam(':pumpup_calories',$pumpupCalories);
      $stmt3->bindParam(':pumpup_image', $pumpupImage);
      $stmt3->bindParam(':pumpupmenu_desc',$pumpupMenuDesc);
      $stmt3->bindParam(':bf_calories',$bfCalories);
      $stmt3->bindParam(':bf_image', $bfImage);
      $stmt3->bindParam(':bfmenu_desc', $bfMenuDesc);
      $stmt3->bindParam(':lunch_calories',$lunchCalories);
      $stmt3->bindParam(':lunch_image', $lunchImage);
      $stmt3->bindParam(':lunchmenu_desc', $lunchMenuDesc);
      $stmt3->bindParam(':evng_calories',$evngCalories);
      $stmt3->bindParam(':evng_image', $evngImage);
      $stmt3->bindParam(':evngmenu_desc', $evngMenuDesc);
      $stmt3->bindParam(':dinner_calories',$dinnerCalories);
      $stmt3->bindParam(':dinner_image', $dinnerImage);
      $stmt3->bindParam(':dinnermenu_desc',$dinnerMenuDesc);
      $stmt3->bindParam(':expedition_id', $expeditionId);
      $stmt3->bindParam(':created_date',$createdDate);
      $stmt3->bindParam(':created_by',$createdBy);
      $stmt3->bindParam(':recordstatus',$status);
      $stmt3->execute();
      $expeditionfoodmenuid = $this->connection->lastInsertId();
      return $expeditionfoodmenuid;
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
      $query = "UPDATE `sg_expeditions`  SET expedition_title=:expedition_title ,expedition_fee=:expedition_fee , visit_time = :difficult, time_visit = :time_visit, expedition_overview = :expedition_overview,       expedition_days  = :expedition_days,expedition_nights = :expedition_nights,region = :region,expeditionvideo_title = :expeditionvideo_title,expeditionvideo_url = :expeditionvideo_url,season = :season,things_carry = :things_carry,       overview_image = :overview_image, expedition_image = :expedition_image,gst = :gst,map_image = :map_image,temperature = :temperature, terms = :terms, faq = :faq,popular_expedition = :popular_expedition,meta_title = :meta_title,      meta_desc = :meta_desc,status = :status,modified_date = :modified_date,modified_by=:modified_by WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);      
      $season_details = implode(",",$season);
      $stmt->bindParam(':expedition_title', $expeditionTitle);
      $stmt->bindParam(':expedition_fee', $expeditionFee);
      $stmt->bindParam(':difficult', $difficult);
      $stmt->bindParam(':time_visit', $timeVisit);
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
      $stmt->bindParam(':faq',$faq);
      $stmt->bindParam(':popular_expedition', $popularExpedition);
      $stmt->bindParam(':temperature',$temperature);
      $stmt->bindParam(':meta_title',$metaTitle);
      $stmt->bindParam(':meta_desc',$metaDesc);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':expedition_id' , $expeditionId);
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
          $query2 = "UPDATE sg_expeditioniterinarydetails set iterinary_details=:iterinary_details,iterinary_title=:iterinary_title,modified_date=:modified_date,modified_by=:modified_by,recordstatus=:status where iterinary_id =:iterinary_id";
          $stmt2 = $this->connection->prepare($query2);
          $stmt2->bindParam(':iterinary_details', $description);
          $stmt2->bindParam(':iterinary_title',$title);
          $stmt2->bindParam(':iterinary_id', $id);
          $stmt2->bindParam(':modified_date', $modified_date);
          $stmt2->bindParam(':modified_by', $userBy);
          $stmt2->bindParam(':status', $status);
          $res = $stmt2->execute();
      } 
      else {
        $query3 = "INSERT INTO sg_expeditioniterinarydetails SET iterinary_title=:iterinary_title, iterinary_details=:iterinary_details ,expedition_id = :expedition_id,created_date = :created_date,created_by=:created_by,recordstatus=:status";
        $stmt3 = $this->connection->prepare($query3);
        $stmt3->bindParam(':iterinary_title',$title);
        $stmt3->bindParam(':iterinary_details', $description);
        $stmt3->bindParam(':expedition_id', $expeditionId);
        $stmt3->bindParam(':created_date', $modified_date);
        $stmt3->bindParam(':created_by', $userBy);
        $stmt3->bindParam(':status', $status);
        $res = $stmt3->execute();
      }
      return $res;
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateExpeditionFoodMenu($data) {
    try{
      extract($data);
      if($foodmenuId != ''){
        $query4 = "UPDATE sg_expeditionfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc, bf_calories=:bf_calories,bf_image = :bf_image,bfmenu_desc = :bfmenu_desc,lunch_calories = :lunch_calories, lunch_image=:lunch_image,lunchmenu_desc = :lunchmenu_desc,evng_calories = :evng_calories, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc,dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,modified_date=:modified_date,modified_by=:modified_by,recordstatus=:status where foodmenu_id =:foodmenu_id";
        $stmt4 = $this->connection->prepare($query4);
        $stmt4->bindParam(':pumpup_calories',$pumpupCalories);
        $stmt4->bindParam(':pumpup_image', $pumpupImage);
        $stmt4->bindParam(':pumpupmenu_desc', $pumpupMenuDesc);
        $stmt4->bindParam(':bf_calories',$bfCalories);
        $stmt4->bindParam(':bf_image', $bfImage);
        $stmt4->bindParam(':bfmenu_desc',$bfMenuDesc);
        $stmt4->bindParam(':lunch_calories',$lunchCalories);
        $stmt4->bindParam(':lunch_image', $lunchImage);
        $stmt4->bindParam(':lunchmenu_desc', $lunchMenuDesc);
        $stmt4->bindParam(':evng_calories',$evngCalories);
        $stmt4->bindParam(':evng_image', $evngImage);
        $stmt4->bindParam(':evngmenu_desc', $evngMenuDesc);
        $stmt4->bindParam(':dinner_calories',$dinnerCalories);
        $stmt4->bindParam(':dinner_image', $dinnerImage);
        $stmt4->bindParam(':dinnermenu_desc', $dinnerMenuDesc);
        $stmt4->bindParam(':foodmenu_id', $foodmenuId);
        $stmt4->bindParam(':modified_date', $modified_date);
        $stmt4->bindParam(':modified_by', $userBy);
        $stmt4->bindParam(':status', $status);
        $res = $stmt4->execute();
      } else {
        $query5 = "INSERT INTO sg_expeditionfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc, bf_calories=:bf_calories,bf_image = :bf_image,bfmenu_desc = :bfmenu_desc,lunch_calories = :lunch_calories, lunch_image=:lunch_image,lunchmenu_desc = :lunchmenu_desc,evng_calories = :evng_calories,expedition_id = :expedition_id, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc,dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,created_date = :created_date,created_by = :created_by,recordstatus=:status";
        $stmt5 = $this->connection->prepare($query5);
        $created_date = date("Y-m-d H:i:s");
        $stmt5->bindParam(':pumpup_calories',$pumpupCalories);
        $stmt5->bindParam(':pumpup_image', $pumpupImage);
        $stmt5->bindParam(':pumpupmenu_desc', $pumpupMenuDesc);
        $stmt5->bindParam(':bf_calories',$bfCalories);
        $stmt5->bindParam(':bf_image', $bfImage);
        $stmt5->bindParam(':bfmenu_desc', $bfMenuDesc);
        $stmt5->bindParam(':lunch_calories',$lunchCalories);
        $stmt5->bindParam(':lunch_image',$lunchImage);
        $stmt5->bindParam(':lunchmenu_desc',$lunchMenuDesc);
        $stmt5->bindParam(':evng_calories',$evngCalories);
        $stmt5->bindParam(':evng_image', $evngImage);
        $stmt5->bindParam(':evngmenu_desc', $evngMenuDesc);
        $stmt5->bindParam(':dinner_calories',$dinnerCalories);
        $stmt5->bindParam(':dinner_image', $dinnerImage);
        $stmt5->bindParam(':dinnermenu_desc', $dinnerMenuDesc);
        $stmt5->bindParam(':expedition_id', $expeditionId);
        $stmt5->bindParam(':created_date',$modified_date);
        $stmt5->bindParam(':created_by',$userBy);
        $stmt5->bindParam(':status',$status);
        $res = $stmt5->execute();
      }
      return $res;
    } catch(PDOException $e) {
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
      $query = "SELECT expedition_id AS expeditionId,expedition_title AS expeditionTitle,expedition_fee AS expeditionFee, visit_time AS visitTime, time_visit AS timeVisit, CONCAT('".UPLOADURL."expeditions/',`expedition_image`) AS expeditionImage, expedition_overview AS expeditionOverview, expedition_days AS expeditionDays, expedition_nights AS expeditionNights, region, expeditionvideo_title AS expeditionVideoTitle, expeditionvideo_url AS expeditionVideoUrl, status, region, things_carry AS thingsCarry, CONCAT('".UPLOADURL."expeditions/',`overview_image`) AS overviewImage, CONCAT('".UPLOADURL."expeditions/',`map_image`) AS mapImage, terms, altitude, gst, numberOfDays, temperature, popular_expedition AS popularexpedition, meta_title AS metaTitle, meta_desc AS metaDesc, faq, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy  FROM sg_expeditions WHERE expedition_id = :expedition_id and status!='9'";
      $stmt = $this->connection->prepare( $query );
      $stmt->bindParam(':expedition_id', $expeditionId);
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
      $query = "UPDATE ".DBPREFIX."_expeditioningdetails SET status='9' where expedition_id=:expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id',$expeditionId);
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
  public function getBatches($data) {
    try {
      extract($data);
      $query="SELECT getExpeditionname(expedition_id) as expeditionTitle, getbatchcount(batch_id) as bookedSeats,`batch_id` as id, concat(`expeditionstart_date`,' To ',`expeditionend_date`) as travelDate,`expeditionbatch_size` as totalSeats,`expeditionbatch_status` AS status, `expedition_id` AS expeditionId FROM sg_expeditionbatches where `expedition_id`=:expedition_id and `expeditionstart_date`>=now() and expeditionbatch_status!='9'  order by expeditionstart_date";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id',$expedition_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
       $status = array(
        'status' => "200",
        'message' => "Success",
        'expedition_batches' => $results);
      }else{
         $status = array(
        'status' => "204",
        'message' => "Failure");
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addBatch($data) {
    try {
      extract($data);
      $created_date = date("Y-m-d H:i:s");
      $count = 0;
      if(empty($expeditionId))
      {
        $status = array(
                'status' => "206",
                'message' => "Failure Expeditionid is required"
        );
      }
      else{      
        $query = "INSERT INTO sg_expeditionbatches SET expeditionstart_date=:expeditionstart_date, expeditionend_date=:expeditionend_date , expeditionbatch_size = :expeditionbatch_size, expeditionbatch_status = :expeditionbatch_status , expedition_id = :expedition_id, created_date = :created_date,created_by=:created_by";
        $startdate = date("Y-m-d", strtotime($startDate));
        $enddate =  date("Y-m-d", strtotime($endDate));
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':expeditionstart_date',$startdate);
        $stmt->bindParam(':expeditionend_date',$enddate);
        $stmt->bindParam(':expeditionbatch_size', $batchSize);
        $stmt->bindParam(':expeditionbatch_status', $batchStatus);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $userBy);
        $stmt->bindParam(":expedition_id", $expeditionId);
        $res = $stmt->execute();
        $batch_id = $this->connection->lastInsertId();      
        if(!empty($batch_id) && $batch_id != '0'){
          $status = array(
          'status' => "200",
          'message' => "Success!!Batch Added Successfully");         
        }else{
          $status = array(
          'status' => "304",
          'message' => "Failure! Batch not added Successfully");          
        }
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getBatch($data) {
    try {
      extract($data);
      $query = "SELECT getexpeditionname(expedition_id) as title, batch_id as id, expeditionstart_date as startDate, expeditionend_date as endDate, expeditionbatch_size as size ,expeditionbatch_status as status, expedition_id AS expeditionId FROM sg_expeditionbatches WHERE batch_id=:batch_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':batch_id', $batch_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
       $status = array(
        'status' => "200",
        'message' => "Success",
        'expedition_batches' => $res);
      }else{
         $status = array(
        'status' => "204",
        'message' => "Failure");
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateBatch($data) {
    try {
      extract($data);
      if(empty($batchId))
      {
        $status = array(
        'status' => "206",
        'message' => "Failure batch  is required"
        );
     }else{
        $query  = "UPDATE  sg_expeditionbatches SET expeditionstart_date=:expeditionstart_date,expeditionend_date=:expeditionend_date ,expeditionbatch_size=:expeditionbatch_size,expeditionbatch_status=:expeditionbatch_status,modified_date=:modified_date,modified_by=:modified_by WHERE batch_id = :batch_id";
        $stmt = $this->connection->prepare($query);
        $modified_date=date("Y-m-d H:i:s");
        $startdate = date("Y-m-d", strtotime($startDate));
        $enddate =  date("Y-m-d", strtotime($endDate));
        $stmt->bindParam(':expeditionstart_date', $startdate);
        $stmt->bindParam(':expeditionend_date', $enddate);
        $stmt->bindParam(':expeditionbatch_size', $batchSize);
        $stmt->bindParam(':expeditionbatch_status', $batchStatus);
        $stmt->bindParam(':modified_date',$modified_date);
        $stmt->bindParam(':modified_by', $userBy);
        $stmt->bindParam(':batch_id', $batchId);
        $res=$stmt->execute();
        if($res=='true')
        {
          $status = array(
          'status' => "200",
          'message' => "Batch Details Successfully Updated");
           
         }else{
          $status = array(
                    'status' => "304",
                    'message' => "Failure Not Updated Successfully"
                );
          
        }
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getExpeditionFee($data) {
    try {
      extract($data);
      $query = "SELECT t.expedition_id as id ,t.expedition_title as name,t.expedition_fee as fee,t.expedition_discount as discount, status, (SELECT COUNT(o.ex_org_id) FROM `sg_expeditionorganizersmap` o WHERE o.expedition_id=t.expedition_id AND o.status=0) AS organisers,(SELECT COUNT(c.expeditioncoupon_id) FROM `sg_expeditioncouponsmap` c WHERE c.expedition_id=t.expedition_id AND c.status=0) AS coupons FROM sg_expeditions t WHERE t.expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id', $expedition_id);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);      
      if(!empty($results)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'expeditionfee' => $results);
      }else{
        $status = array('status'=>"204",
         'message'=>"No Data Found");
      }
      return $status;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function updateExpeditionFee($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditions SET expedition_fee = :expedition_fee, expedition_discount = :expedition_discount WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_fee',$expeditionFees);
      $stmt->bindParam(':expedition_discount',$discount);
      $stmt->bindParam(':expedition_id',$id);
      $res=$stmt->execute();
      if($res='true'){
        $status = array(
          'status' => "200",
          'message' => "Success");
      }else{
        $status = array(
          'status' => "304",
          'message' => "Failure");
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
  public function updatePopular($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditions SET popular_expedition = :popular_expedition  WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':popular_expedition',$popularExpedition);
      $stmt->bindParam(':expedition_id',$id);
      $res=$stmt->execute();
      if($res='true'){
        $status = array(
          'status' => "200",
          'message' => "Success");
      }else{
        $status = array(
          'status' => "304",
          'message' => "Failure");
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
  public function getBatchBookings($data) {
    try {
      extract($data);
      $query = "SELECT p.`name` as customerName, p.`mobile`, p.`email`, b.`expedition_id` AS expeditionId, b.`booking_id` AS bookingId, b.`address`, b.`state`, b.`city`, b.`created_date` AS bookingDate, getexpeditionname(b.`expedition_id`) as expeditionTitle, getexpeditionparticipantscount(b.`booking_id`) AS personCnt, i.`expeditionstart_date` AS expeditionStartDate, i.`expeditionend_date` AS expeditionEndDate, pm.`payment_id` AS paymentId, pm.`original_amount` AS originalAmount, pm.`txn_id` AS txnId, getexpeditionpayment_type(b.`booking_id`) AS paymentType, pm.`amount` FROM sg_expeditionpayments pm RIGHT JOIN sg_expeditionbookings b ON pm.`booking_id`=b.`booking_id`, sg_expeditionbatches i, sg_expeditionparticipants p  WHERE b.`batch` = i.`batch_id` AND b.`booking_id` = p.booking_id AND i.batch_id = :batch_id AND pm.payment_id = (SELECT max(ep.payment_id) FROM sg_expeditionpayments ep WHERE ep.booking_id =b.booking_id) ORDER BY b.booking_id DESC";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':batch_id',$id);
      $stmt->execute();
      $bookingdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($bookingdetails)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'batch_bookingdeatils' => $bookingdetails
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function getBookings() {
    try {
      $query = "SELECT p.`name` as customerName, p.`mobile` as mobile, b.`booking_id` AS bookingId, b.`address`, b.`state`, b.`city`, DATE_FORMAT(b.`created_date`,'%d %M %Y') AS bookingDate, getexpeditionname(b.`expedition_id`) as expeditionName, getexpeditionparticipantscount(b.`booking_id`) AS personCnt, Concat(DATE_FORMAT(i.`expeditionstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`expeditionend_date`,'%d %M %Y')) AS batchDate, pm.`payment_id` AS paymentId, pm.`txn_id` AS txnId, IFNULL(getexpaymenttypename(b.`booking_id`),'pending Payment') AS paymentType, pm.`amount` FROM sg_expeditionpayments pm RIGHT JOIN sg_expeditionbookings b ON pm.`booking_id`=b.`booking_id`, sg_expeditionbatches i, sg_expeditionparticipants p  WHERE  b.`batch` = i.`batch_id` AND b.`booking_id` = p.booking_id ORDER BY b.booking_id DESC";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $bookingdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($bookingdetails)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'bookingdeatils' => $bookingdetails
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function getParticipants($data) {
    try {
      extract($data);
      $query = "SELECT `participant_id` AS participantId, `name`, `email`, `mobile`, `age`, `gender`, `height`, `weight`, `booking_id` AS bookingId, `created_date` AS createdDate  FROM sg_expeditionparticipants WHERE booking_id=:booking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':booking_id',$booking_id);
      $stmt->execute();
      $participantdetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($participantdetails)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'participantdetails' => $participantdetails
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function getBookingDetails($data) {
    try {
      extract($data);
      $query = "SELECT p.`name` as customerName,p.`email` as email,p.`age` as age,p.`gender` as gender,p.`height` as `height`,p.`weight`,p.`mobile` as mobile,b.`address` as billing, b.`state`,b.`city`,DATE_FORMAT(b.`created_date`,'%d %M %Y') as bookingDate, getexpeditionname(b.`expedition_id`) as expeditionName, Concat(DATE_FORMAT(i.`expeditionstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`expeditionend_date`,'%d %M %Y')) as batchDate, pm.`txn_id` as transaction, IFNULL(getexpaymenttypename(b.`booking_id`),'pending Payment') as paymentType, pm.`amount` as amount from sg_expeditionpayments pm RIGHT  JOIN sg_expeditionbookings b on pm.`booking_id`=b.`booking_id`, sg_expeditionbatches i, sg_expeditionparticipants p where b.`batch` = i.`batch_id` and b.`booking_id` = p.booking_id and b.booking_id = :booking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':booking_id',$id);
      $stmt->execute();
      $transactiondetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($transactiondetails)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'bookingdetails' => $transactiondetails
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function addOrganizer($data) {
    try {
      extract($data);
      if(empty($id)||empty($selectOrg)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
      else{
        $query = "INSERT INTO sg_expeditionorganizersmap(organizer_id, expedition_id, status, created_date, created_by) VALUES(:organizer_id, :expedition_id, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':organizer_id', $selectOrg);
        $stmt->bindParam(':expedition_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $expeditionorganizer_id = $this->connection->lastInsertId();
        if($expeditionorganizer_id!='' && $expeditionorganizer_id!='0'){
          $status = array(
            'status' => '200',
            'message' => 'ExpeditionOrganizer Added Successfully',
            'expeditionorganizer_id' => $expeditionorganizer_id);
          
        }else{
           $status = array(
                    'status' => "304",
                    'message' => "Not Added Successfully"
                );
        }
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
  public function getOrganizerDetails($data) {
    try {
      extract($data);
      $query = "SELECT organizer_id AS organizerId, org_name AS orgName, org_job AS orgJob, org_mobile AS orgMobile, where_reach AS whereReach, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_expeditionorganizers WHERE organizer_id IN (SELECT organizer_id FROM sg_expeditionorganizersmap WHERE expedition_id = $expedition_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditionorganizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($expeditionorganizers!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditionorganizers' => $expeditionorganizers);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function getOrganizerExpeditions($data) {
    try {
      extract($data);
      $query = "SELECT expedition_id AS expeditionId, getexpeditionname(expedition_id) as expeditionName FROM sg_expeditionorganizersmap WHERE organizer_id='$organizer_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditiondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($expeditiondetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditiondetails' => $expeditiondetails);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function deleteOrganizer($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditionorganizersmap SET status='9' where ex_org_id=:ex_org_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':ex_org_id',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
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
  public function addExpeditionCoupon($data) {
    try {
      extract($data);
      if(empty($id)||empty($selectCoupon)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
     else{
        $query = "INSERT INTO sg_expeditioncouponsmap(coupon_id, expedition_id, status, created_date, created_by) VALUES(:coupon_id, :expedition_id, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':coupon_id', $selectCoupon);
        $stmt->bindParam(':expedition_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $expeditioncoupon_id = $this->connection->lastInsertId();
        if(!empty($expeditioncoupon_id) && $expeditioncoupon_id != '0'){
          $status = array(
            'status' => '200',
            'message' => 'Expeditioncoupon Added Successfully',
            'expeditioncoupon_id' => $expeditioncoupon_id);          
        }else{
           $status = array(
                    'status' => "304",
                    'message' => "Not Added Successfully"
                );
        }
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
  public function getExpeditionCoupons($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id AS couponId, coupon_code as couponCode, coupon_name as couponName, valid_from as validFrom, valid_till as validTill, discount_amount AS discount, status, all_expeditions AS allExpeditions, coupon_type AS couponType, commision_status AS commisionStatus, commision_date AS commisionDate, commision_remarks AS commisionRemarks, coupon_limit AS couponLimit, coupon_value_limit AS couponValueLimit, coupon_value_decrease AS couponValueDecrease, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_expeditioncoupons WHERE coupon_id IN (SELECT coupon_id FROM sg_expeditioncouponsmap WHERE expedition_id = '$expedition_id' and status!='9')";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditioncoupons  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($expeditioncoupons)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditioncoupons' => $expeditioncoupons);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function getCouponExpeditions($data) {
    try {
      extract($data);
      $query = "SELECT expedition_id AS expeditionId, getexpeditionname(expedition_id) AS expeditionName FROM sg_expeditioncouponsmap WHERE coupon_id='$coupon_id' AND status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditiondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($expeditiondetails != ''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditiondetails' => $expeditiondetails);
      }
      else{
        $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function deleteExpeditionCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditioncouponsmap SET status='9' where expeditioncoupon_id=:ex_coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':ex_coupon_id',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
       $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
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
  public function getExpeditionGallery($data) {
    try {
      extract($data);
      $query = "SELECT image_id AS imageId, CONCAT('".UPLOADURL."expeditions/gallery/',`image_name`) AS imageName, image_type AS imageType, expedition_id AS expeditionId, recordstatus AS status, created_date AS createdDate, created_by AS createdBy FROM sg_expedition_gallery WHERE `expedition_id`=:expedition_id AND recordstatus!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id', $expedition_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
       $status = array(
        'status' => "200",
        'message' => "Success",
        'gallery_image' => $res);
      }else{
         $status = array(
        'status' => "204",
        'message' => "No Data Found");
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
  public function addExpeditionGallery($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_expedition_gallery SET `image_name` = :image_name, expedition_id=:expedition_id,image_type=:image_type,created_date=:created_date,created_by=:created_by,recordstatus=:status";
      $stmt = $this->connection->prepare($query);
      $created_date=date("Y-m-d H:i:s");
      $stmt->bindParam(':image_name', $expeditiongalImage);
      $stmt->bindParam(':expedition_id', $expeditionId);
      $stmt->bindParam(':image_type', $ext);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->bindParam(':status',$status);
      $stmt->execute();
      $image_id = $this->connection->lastInsertId();
      if(!empty($image_id) && $image_id != '0'){
        $status = array(
        'status' => "200",
        'message' => "Image Inserted Successfully");
      }else{
        $status = array(
        'status' => "304",
        'message' => "Image Not Inserted Successfully");
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
  public function deleteExpeditionGallery($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expedition_gallery SET recordstatus='9' where image_id=:image_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':image_id',$image_id);
      $res=$stmt->execute();
      if($res=='true'){ 
        $status = array(
          'status' => "200",
          'message' => "Image Deleted Successfully");
       } else {
        $status = array(
          'status' => "304",
          'message' => "Error!!Image Not Deleted");
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
  public function getExpeditionReviews() {
    try {
      $query ="SELECT `review_id` AS reviewId, `name`, `mobile_no` AS mobile, `rating`, `review`, getexpeditionname(`expedition_id`) as expeditionTitle, recordstatus AS status FROM sg_expeditionreviews WHERE rating!='0'  order by review_id desc";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
          'status' => "200",
          'message' => "Success",
         'expedition_reviews' => $results
        );
      }else{
        $status = array(
          "status" => "204",
          "message" => "No Data Found");
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
  public function addExpeditionReview($data) {
    try {
      extract($data);
      $sql = "INSERT INTO sg_expeditionreviews (name, mobile_no, rating, review, expedition_id, recordstatus, created_date, created_by, status, user_id) VALUES(:name, :mobile_no, :rating, :review, :expedition_id, :recordstatus, :created_date, :created_by, :status, :user_id)";
      $stmt = $this->connection->prepare($sql);      
      $recordstatus = '9';
      $created_date=date("Y-m-d H:i:s");
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":mobile_no",$mobile_no);
      $stmt->bindParam(":rating", $rating);
      $stmt->bindParam(":review", $review);
      $stmt->bindParam(":expedition_id", $expeditionId);
      $stmt->bindParam(":recordstatus", $recordstatus);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by", $created_by);
      $stmt->bindParam(":user_id", $user_id);
      $res = $stmt->execute();
      if ($res=='true'){
        $status = array('status'=>"200",
        'message'=>"Success Review Added Successfully");
      }
      else{
        $status = array('status'=>"304",
        'message'=> "Sorry, Please try once again!");
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
  public function getExpeditionReview($data) {
    try {
      extract($data);
      echo $query ="SELECT review, name, rating+0.0 AS rating, mobile_no AS mobile, DATE_FORMAT(`created_date`,'%M %d,%Y') AS createdDate FROM sg_expeditionreviews WHERE `expedition_id`= '$expedition_id' AND `recordstatus`='1' ORDER BY review_id DESC";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
          'status' => "200",
          'message' => "Success",
         'expedition_reviews' => $results
        );
      }else{
        $status = array(
          "status" => "204",
          "message" => "No Data Found");
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
  public function updateExpeditionReview($data) {
    try {
      extract($data);
      if($status == '0') {
        $upd_status = '1';
      } else {
        $upd_status = '0';
      }
      $query = "UPDATE sg_expeditionreviews SET recordstatus = :status WHERE review_id = :review_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status',$status);
      $stmt->bindParam(':review_id', $reviewId);
      $res=$stmt->execute();
      if($res='true'){
        $status = array(
          'status' => "200",
          'message' => "Success");
      }else{
        $status = array(
          'status' => "304",
          'message' => "Failure");
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
  public function addExpeditionRentals($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_expeditionrentalitems(rentalitem, item_cost,
      expeditionbatch, expedition_id, status, created_date, created_by) VALUES(:rentalitem, :item_cost, :expeditionbatch, :expedition_id, :status, :created_date, :created_by)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':rentalitem', $rentalItem);
      $stmt->bindParam(':item_cost', $itemCost);
      $stmt->bindParam(':expeditionbatch', $expeditionBatch);
      $stmt->bindParam(':expedition_id', $expeditionId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $expeditionrental_id = $this->connection->lastInsertId();
      if(!empty($expeditionrental_id)){
        $status = array(
          'status' => '200',
          'message' => 'ExpeditionRental Added Successfully',
          'expeditionrental_id' => $expeditionrental_id);        
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
  public function getExpeditionRentals($data) {
    try {
      extract($data);
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, CONCAT('".UPLOADURL."rentals/',`image_1`) AS image_1, CONCAT('".UPLOADURL."rentals/',`image_2`) AS image_2, CONCAT('".UPLOADURL."rentals/',`image_3`) AS image_3, CONCAT('".UPLOADURL."rentals/',`image_4`) AS image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_expeditionrentalitems WHERE expedition_id = $expedition_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditionrentals  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($expeditionrentals)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditionrentals' => $expeditionrentals);
      }
      else{
       $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function getRentalExpeditions($data) {
    try {
      extract($data);
      $query = "SELECT expedition_id AS expeditionId, getexpeditionname(expedition_id) AS expeditionName FROM sg_expeditionrentalitems WHERE rentalitem='$rental_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditiondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($expeditiondetails != ''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditiondetails' => $expeditiondetails);
      }
      else{
        $status = array('status'=>"204",
          'message'=>"No Data Found");
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
  public function getBatchRentals($data) {
    try {
      extract($data);
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, CONCAT('".UPLOADURL."rentals/',`image_1`) AS image_1, CONCAT('".UPLOADURL."rentals/',`image_2`) AS image_2, CONCAT('".UPLOADURL."rentals/',`image_3`) AS image_3, CONCAT('".UPLOADURL."rentals/',`image_4`) AS image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_expeditionrentalitems WHERE expeditionbatch = $batch_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $rentaldetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($rentaldetails)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'rentaldetails' => $rentaldetails);
      }
      else{
        $status = array('status'=>"204",
       'message'=>"No Data Found");
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
  public function getExpeditionBatchRental($data) {
    try {
      extract($data);
      $query = "SELECT b.batch_id AS batchId, b.expeditionstart_date AS expeditionStartDate, b.expeditionend_date AS expeditionEndDate, b.expeditionbatch_size expeditionBatchSize, b.expeditionbatch_status AS expeditionBatchStatus
                FROM sg_expeditionbatches b  
                JOIN sg_expeditionrentalitems r
                ON b.batch_id = r.expeditionbatch";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $expeditionbatchdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($expeditionbatchdetails)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'expeditionbatchdetails' => $expeditionbatchdetails);
      }
      else{
        $status = array('status'=>"204",
          'message'=>"No Data Found");
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
  public function deleteExpeditionRental($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditionrentalitems SET status='9' WHERE rentalitem_id=:rentalid";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':rentalid',$id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Deleted Successfully");
      }else{
        $status = array(
          "status" => "304",
          "message" => "Not Deleted Successfully");
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
  public function getTransactions() {
    try {
      $query = "SELECT b.`expedition_id` AS expeditionId, b.`booking_id` AS bookingId, b.`address`, b.`city`, b.`state`, getexpeditionparticipantscount(b.`booking_id`) as personsCnt, `payment_id` AS paymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` as amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as createdDate, getexpeditionname(b.`expedition_id`) as expeditionTitle, ib.`expeditionstart_date` AS expeditionStartDate, ib.`expeditionend_date` AS expeditionEndDate, bb.`buyer_name` AS customerName, bb.`phone` AS mobile, bb.`email` FROM sg_exbeforebookingdetails bb, sg_expeditionbatches ib, sg_expeditionpayments pm inner join sg_expeditionbookings b on pm.`booking_id` = b.`booking_id` where ib.`batch_id`=b.`batch` and bb.`booking_id` = b.`booking_id` order by pm.`payment_id` desc";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $transactiondetails = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($transactiondetails)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'transactiondetails' => $transactiondetails
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function getTransactionDetails($data) {
    try {
      extract($data);
      echo $query = "SELECT  b.`expedition_id` AS expeditionId, b.`booking_id` AS bookingId, b.`address`, b.`city`, b.`state`,getexpeditionparticipantscount(b.`booking_id`) as personsCnt, `payment_id` AS paymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` as amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as createdDate, getexpeditionname(b.`expedition_id`) as expeditionTitle, ib.`expeditionstart_date` AS expeditionStartDate, ib.`expeditionend_date` AS expeditionEndDate, bb.`buyer_name` AS customerName, bb.`phone` AS mobile, bb.`email`, getexcustomergender(b.`booking_id`) as gender FROM sg_exbeforebookingdetails bb,sg_expeditionbatches ib,sg_expeditionpayments pm inner join sg_expeditionbookings b on pm.`booking_id` = b.`booking_id` where ib.`batch_id`=b.`batch` and bb.`booking_id` = b.`booking_id` and  b.`booking_id`=:booking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':booking_id',$id);
      $stmt->execute();
      $transactiondetail = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($transactiondetail)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'transactiondetail' => $transactiondetail
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function addExpeditionFaq($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_expedition_faq`(`expedition_id`, `cat_id`, `question`, `answer`, `status`, `created_by`, `created_date`) VALUES(:expedition_id, :cat_id, :question, :answer, :status, :created_by, :created_date)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id', $expeditionId);
      $stmt->bindParam(':cat_id', $catId);
      $stmt->bindParam(':question', $question);
      $stmt->bindParam(':answer', $answer);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $expeditionfaq_id = $this->connection->lastInsertId();
      if(!empty($expeditionfaq_id)){
        $status = array(
          'status' => '200',
          'message' => 'expedition Faq Added Successfully',
          'expeditionfaq_id' => $expeditionfaq_id);        
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
  public function updateExpeditionFaq($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_expedition_faq` SET `expedition_id` = :expedition_id, `cat_id` = :cat_id, `question` = :question, `answer` = :answer, `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id', $expeditionId);
      $stmt->bindParam(':cat_id', $catId);
      $stmt->bindParam(':question', $question);
      $stmt->bindParam(':answer', $answer);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by',$createdBy);
      $stmt->bindParam(':faq_id',$faqId);
      $res = $stmt->execute();
      if(!empty($res)){
        $status = array(
          'status' => '200',
          'message' => 'expedition Faq Updated Successfully');        
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
  public function getFaq($data) {
    try {
      extract($data);
      $query = "SELECT `faq_id` AS faqId, `expedition_id` AS expeditionId, `cat_id` AS catId, `question`, `answer`, `status`, `created_by` AS createdBy, `created_date` AS createdDate, `modified_by` AS modifiedBy, `modified_date` AS modifiedDate FROM `sg_expedition_faq` WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':expedition_id', $expedition_id);
      $stmt->execute();
      $faq = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($faq)){
         $status = array(
          'status' => "200",
          'message' => "Success",
         'faq' => $faq
       );
      }else{
         $status = array(
        "status" => "204",
         "message" => "No Data Found");
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
  public function updateExpeditionStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expeditions SET status = :status WHERE expedition_id = :expedition_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':expedition_id', $expeditionId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure Not updated Successfully");
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
  public function updateBatchStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expeditionbatches SET expeditionbatch_status = :status WHERE batch_id = :batch_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':batch_id', $batchId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success batch updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure batch Not updated Successfully");
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
  public function updateOrganizerStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expeditionorganizersmap SET status = :status WHERE organizer_id = :organizer_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':organizer_id', $organizerId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success organizer updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure organizer Not updated Successfully");
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
  public function updateCouponStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expeditioncouponsmap SET status = :status WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':coupon_id', $couponId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success coupon updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure coupon Not updated Successfully");
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
  public function updateExpeditionImageStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expedition_gallery SET recordstatus = :status WHERE image_id=:image_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':image_id', $imageId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success image updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure image Not updated Successfully");
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
  public function updateExpeditionRentalStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_expeditionrentalitems SET status = :status WHERE expeditionrental_id =:expeditionrental_id ";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':expeditionrental_id ', $itemId );
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success rental item updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure rental item Not updated Successfully");
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
  public function updateExpeditionFaqStatus($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_expedition_faq` SET `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' ,$modified_date);
      $stmt->bindParam(':modified_by',$userBy);
      $stmt->bindParam(':faq_id',$faqId);
      $res = $stmt->execute();
      if(!empty($res)){
        $status = array(
          'status' => '200',
          'message' => 'Faq Updated Successfully');        
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