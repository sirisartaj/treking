<?php
namespace App\Domain\Treks;
use PDO;
/**
* Repository.
*/
class TreksRepository
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
  public function getTreks(): array
  {      
     $query = "SELECT * from sg_trekingdetails";
    
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
    $results =$stmt->fetchAll(PDO::FETCH_OBJ);
    //echo "aaaa<pre>";print_r($results);exit;
    if(!empty($results)){
     $status = array(
       'status' =>"200",
       'message' =>"Success",
       'alltreks' => $results);
       return $status;
    }else{
      $status = array('status'=>"204",
       'message'=>"No Data Found");
       return $status;
      }
  }
  public function insertTrek($data) {
    try {
      extract($data);
      $sql = "INSERT INTO sg_trekingdetails (trek_title, trek_fee, visit_time, time_visit, trek_overview, trek_days, trek_nights, region, trekvideo_title, trekvideo_url, season, things_carry, overview_image, trek_image, gst, map_image, temperature, terms, faq, popular_trek, meta_title, meta_desc, altitude, status, created_date, created_by)VALUES(:trek_title, :trek_fee, :difficult, :time_visit, :trek_overview, :trek_days, :trek_nights, :region, :trekvideo_title, :trekvideo_url, :season, :things_carry, :overview_image, :trek_image, :gst, :map_image, :temperature, :terms, :faq, :popular_trek, :meta_title, :meta_desc, :altitude, :status, :created_date, :created_by)";
      $stmt = $this->connection->prepare($sql);         
      $season_details = implode(",",$season);
      $stmt->bindParam(':trek_title', $trekTitle);
      $stmt->bindParam(':trek_fee', $trekFee);
      $stmt->bindParam(':difficult', $difficult);
      $stmt->bindParam(':time_visit',$timeVisit);
      $stmt->bindParam(':trek_overview',$trekOverview);
      $stmt->bindParam(':trek_days', $trekDays);
      $stmt->bindParam(':trek_nights', $trekNights);
      $stmt->bindParam(':region', $region);
      $stmt->bindParam(':trekvideo_title', $trekVideoTitle);
      $stmt->bindParam(':trekvideo_url', $trekVideoUrl);
      $stmt->bindParam(':season',$seasonDetails);
      $stmt->bindParam(':things_carry', $thingsCarry);
      $stmt->bindParam(':trek_image', $trekImage);
      $stmt->bindParam(':overview_image', $overviewImage);
      $stmt->bindParam(':gst', $gst);
      $stmt->bindParam(':map_image', $mapImage);
      $stmt->bindParam(':terms', $terms);
      $stmt->bindParam('faq',$faq);
      $stmt->bindParam(':popular_trek', $popularTrek);
      $stmt->bindParam(':temperature',$temperature);
      $stmt->bindParam(':meta_title',$metaTitle);
      $stmt->bindParam(':meta_desc',$metaDesc);
      $stmt->bindParam(':altitude',$altitude);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' , $createdDate);
      $stmt->bindParam(':created_by' , $createdBy);
      $stmt->execute();
      $trek_id = $this->connection->lastInsertId();
      return $trek_id;     
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function addTrekIterinaryDetails($data) {
    try {
      extract($data);
      $query2 = "INSERT INTO ".DBPREFIX."_trekiterinarydetails SET iterinary_title=:iterinary_title, iterinary_details=:iterinary_details,trek_id = :trek_id,created_date = :created_date,created_by=:created_by,recordstatus=:status";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->bindParam(':iterinary_title',$title);
      $stmt2->bindParam(':iterinary_details',$description);
      $stmt2->bindParam(':trek_id',$trekId);
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
  public function addTrekFoodMenu($data) {
    try {
      extract($data);
      $query3 = "INSERT INTO ".DBPREFIX."_trekfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc,      bf_calories=:bf_calories, bf_image = :bf_image, bfmenu_desc = :bfmenu_desc, lunch_calories = :lunch_calories,  lunch_image=:lunch_image,lunchmenu_desc = :lunchmenu_desc,evng_calories = :evng_calories,trek_id = :trek_id, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc,dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,created_date = :created_date, created_by=:created_by, recordstatus=:status";
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
      $stmt3->bindParam(':trek_id', $trekId);
      $stmt3->bindParam(':created_date',$createdDate);
      $stmt3->bindParam(':created_by',$createdBy);
      $stmt3->bindParam(':status',$status);
      $stmt3->execute();
      $trekfoodmenuid = $this->connection->lastInsertId();
      return $trekfoodmenuid;
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function checkTrekName($trekName) {
    $sql = "SELECT count(`trek_id`) as cnt FROM " . DBPREFIX . "_trekingdetails where `trek_title`='$trekName'and status!='9'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_OBJ);
    $cnt = $count->cnt;
    return $cnt;
  }
  public function updateTrek($data) {
    try {
      //print_r($data);exit;
      extract($data);
      $query = "UPDATE `sg_trekingdetails`  SET trek_title='".$trek_title."' , trek_overview = '".$trek_overview."',things_carry = '".$things_carry."', terms = '".$terms."',modified_date = '".$modified_date."',modified_by='".$modified_by."', map_image ='".$map_image."' WHERE trek_id =:trek_id";
     //exit;
      $stmt = $this->connection->prepare($query);      
      $stmt->bindParam(':trek_id',$trek_id);
      $res = $stmt->execute();
      if($res){
        $status = array(
              'status' => "200",
              'message' => 'Update'
          );
      }else{
        $status = array(
              'status' => "201",
              'message' => 'no Update'
          );
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
  public function updateTrekIterinaryDetails($data) {
    try {
      extract($data);
      if(@$data['id']){
          $query2 = "UPDATE sg_trekiterinarydetails set iterinary_details=:iterinary_details,iterinary_title=:iterinary_title,modified_date=:modified_date,modified_by=:modified_by,recordstatus=:status where iterinary_id =:iterinary_id";
          $stmt2 = $db->prepare($query2);
          $stmt2->bindParam(':iterinary_details', $description);
          $stmt2->bindParam(':iterinary_title',$title);
          $stmt2->bindParam(':iterinary_id', $id);
          $stmt2->bindParam(':modified_date', $modified_date);
          $stmt2->bindParam(':modified_by', $modified_by);
          $stmt2->bindParam(':status', $status);
          $res = $stmt2->execute();
      } 
      else {
        $query3 = "INSERT INTO sg_trekiterinarydetails SET iterinary_title=:iterinary_title, iterinary_details=:iterinary_details ,trek_id = :trek_id,created_date = :created_date,created_by=:created_by,recordstatus=:status";
        $stmt3 = $db->prepare($query3);
        $stmt3->bindParam(':iterinary_title',$title);
        $stmt3->bindParam(':iterinary_details', $description);
        $stmt3->bindParam(':trek_id', $trek_id);
        $stmt3->bindParam(':created_date', $modified_date);
        $stmt3->bindParam(':created_by', $modified_by);
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
  public function updateTrekFoodMenu($data) {
    try{
      extract($data);
      if($foodmenuId != ''){
        $query4 = "UPDATE sg_trekfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc, bf_calories=:bf_calories,bf_image = :bf_image,bfmenu_desc = :bfmenu_desc,lunch_calories = :lunch_calories, lunch_image=:lunch_image,lunchmenu_desc = :lunchmenu_desc,evng_calories = :evng_calories, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc,dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,modified_date=:modified_date,modified_by=:modified_by,recordstatus=:status where foodmenu_id =:foodmenu_id";
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
        $stmt4->bindParam(':modified_by', $modified_by);
        $stmt4->bindParam(':status', $status);
        $res = $stmt4->execute();
      } else {
        $query5 = "INSERT INTO sg_trekfoodmenu SET pumpup_calories=:pumpup_calories, pumpup_image=:pumpup_image , pumpupmenu_desc = :pumpupmenu_desc, bf_calories=:bf_calories,bf_image = :bf_image,bfmenu_desc = :bfmenu_desc,lunch_calories = :lunch_calories, lunch_image=:lunch_image,lunchmenu_desc = :lunchmenu_desc,evng_calories = :evng_calories,trek_id = :trek_id, evng_image = :evng_image,evngmenu_desc = :evngmenu_desc,dinner_calories = :dinner_calories,dinner_image = :dinner_image, dinnermenu_desc = :dinnermenu_desc,created_date = :created_date,created_by = :created_by,recordstatus=:status";
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
        $stmt5->bindParam(':trek_id', $trekId);
        $stmt5->bindParam(':created_date',$modified_date);
        $stmt5->bindParam(':created_by',$modified_by);
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
  public function checktrek($trekname,$trekid)
  {
    $sql = "SELECT count(`trek_id`) as cnt FROM " . DBPREFIX . "_trekingdetails where `trek_title`='$trekname'and trek_id!='$trekid'";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_OBJ);
    $cnt = $count->cnt;
    return $cnt;
  }
  public function getTrek($data) {    
    try {
      extract($data);
      $query = "SELECT trek_id AS trekId,trek_title AS trekTitle,trek_fee AS trekFee, visit_time AS visitTime, time_visit AS timeVisit, CONCAT('".UPLOADURL."treks/',`trek_image`) AS trekImage, trek_overview AS trekOverview, trek_days AS trekDays, trek_nights AS trekNights, region, trekvideo_title AS trekVideoTitle, trekvideo_url AS trekVideoUrl, status, region, things_carry AS thingsCarry, CONCAT('".UPLOADURL."treks/',`overview_image`) AS overviewImage, CONCAT('".UPLOADURL."treks/',`map_image`) AS mapImage, terms, altitude, gst, numberOfDays, temperature, popular_trek AS popularTrek, meta_title AS metaTitle, meta_desc AS metaDesc, faq, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy  FROM sg_trekingdetails WHERE trek_id = :trek_id and status!='9'";
      $stmt = $this->connection->prepare( $query );
      $stmt->bindParam(':trek_id', $trekId);
      $stmt->execute();
      $res['treks'] = $stmt->fetch(PDO::FETCH_OBJ);
      $query2 = "SELECT iterinary_id AS iterinaryId, iterinary_title AS iterinaryTitle, iterinary_details AS iterinaryDetails, trek_id AS trekId, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy, recordstatus FROM sg_trekiterinarydetails where trek_id = :trek_id and recordstatus!='9'";
      $stmt2 = $this->connection->prepare( $query2 );
      $stmt2->bindParam(':trek_id', $trekId);
      $stmt2->execute();
      $res['trek_iternerary'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
      $query3 = "SELECT foodmenu_id AS foodmenuId, trek_id AS trekIid, pumpup_calories AS pumpupCalories, CONCAT('".UPLOADURL."treks/food/',`pumpup_image`) AS pumpupImage, pumpupmenu_desc AS pumpupMenuDesc,bf_calories AS bfCalories, CONCAT('".UPLOADURL."treks/food/',`bf_image`) AS bfImage, bfmenu_desc AS bfMenuDesc, lunch_calories AS lunchCalories, lunchmenu_desc AS lunchMenuDesc, CONCAT('".UPLOADURL."treks/food/',`lunch_image`) AS lunchImage, evng_calories AS evngCalories, CONCAT('".UPLOADURL."treks/food/',`evng_image`) AS evngImage, evngmenu_desc AS evngMenuDesc, dinner_calories AS dinnerCalories, CONCAT('".UPLOADURL."treks/food/',`dinner_image`) AS dinnerImage, dinnermenu_desc AS dinnerMenuDesc, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy, recordstatus AS status FROM sg_trekfoodmenu where trek_id = :trek_id and recordstatus!='9'";
      $stmt3 = $this->connection->prepare( $query3 );
      $stmt3->bindParam(':trek_id', $trekId);
      $stmt3->execute();
      $res['trek_food'] = $stmt3->fetch(PDO::FETCH_ASSOC);
      if(!empty($res)){
        $status = array(
                  'status' => "200",
                  'message' => "Success",
                  'trek_details' => $res);
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
  public function deleteTrek($data) {
    try{
      extract($data);
      $query = "UPDATE ".DBPREFIX."_trekingdetails SET status='9' where trek_id=:trek_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id',$trekId);
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
      $query="SELECT gettrekname(trek_id) as trekTitle, getbatchcount(batch_id) as bookedSeats,`batch_id` as id, concat(`trekstart_date`,' To ',`trekend_date`) as travelDate,`trekbatch_size` as totalSeats,`trekbatch_status` AS status, `trek_id` AS trekId FROM sg_inserttrekbatches where `trek_id`=:trek_id and `trekstart_date`>=now() and trekbatch_status!='9'  order by trekstart_date";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id',$trek_id);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
       $status = array(
        'status' => "200",
        'message' => "Success",
        'trek_batches' => $results);
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
      if(empty($trekId))
      {
        $status = array(
                'status' => "206",
                'message' => "Failure trekid is required"
        );
      }
      else{      
        $query = "INSERT INTO ".DBPREFIX."_inserttrekbatches SET trekstart_date=:trekstart_date, trekend_date=:trekend_date , trekbatch_size = :trekbatch_size, trekbatch_status = :trekbatch_status , trek_id = :trek_id, created_date = :created_date,created_by=:created_by";
        $startdate = date("Y-m-d", strtotime($startDate));
        $enddate =  date("Y-m-d", strtotime($endDate));
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':trekstart_date',$startdate);
        $stmt->bindParam(':trekend_date',$enddate);
        $stmt->bindParam(':trekbatch_size', $batchSize);
        $stmt->bindParam(':trekbatch_status', $batchStatus);
        $stmt->bindParam(':created_date', $created_date);
        $stmt->bindParam(':created_by', $userBy);
        $stmt->bindParam(":trek_id", $trekId);
        $res = $stmt->execute();
        $batch_id = $this->connection->lastInsertId();      
        if(!empty($batch_id)){
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
      $query = "SELECT gettrekname(trek_id) as title, batch_id as id, trekstart_date as startDate, trekend_date as endDate, trekbatch_size as size ,trekbatch_status as status, trek_id AS trekId FROM sg_inserttrekbatches WHERE batch_id=:batch_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':batch_id', $batch_id);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
       $status = array(
        'status' => "200",
        'message' => "Success",
        'trek_batches' => $res);
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
        $query  = "UPDATE  sg_inserttrekbatches SET trekstart_date=:trekstart_date,trekend_date=:trekend_date ,trekbatch_size=:trekbatch_size,trekbatch_status=:trekbatch_status,modified_date=:modified_date,modified_by=:modified_by WHERE batch_id = :batch_id";
        $stmt = $this->connection->prepare($query);
        $modified_date=date("Y-m-d H:i:s");
        $startdate = date("Y-m-d", strtotime($startDate));
        $enddate =  date("Y-m-d", strtotime($endDate));
        $stmt->bindParam(':trekstart_date', $startdate);
        $stmt->bindParam(':trekend_date', $enddate);
        $stmt->bindParam(':trekbatch_size', $batchSize);
        $stmt->bindParam(':trekbatch_status', $batchStatus);
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
  public function getTrekFee($data) {
    try {
      extract($data);
      $query = "SELECT t.trek_id as id ,t.trek_title as name,t.trek_fee as fee,t.trek_discount as discount, status, (SELECT COUNT(o.tr_org_id) FROM `sg_trekorganizersmap` o WHERE o.trek_id=t.trek_id AND o.status=0) AS organisers,(SELECT COUNT(c.trekcoupon_id) FROM `sg_trekcouponsmap` c WHERE c.trek_id=t.trek_id AND c.status=0) AS coupons FROM sg_trekingdetails t WHERE t.trek_id = :trek_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id', $trek_id);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);      
      if(!empty($results)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'trekfee' => $results);
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
  public function updateTrekFee($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekingdetails SET trek_fee = :trek_fee, trek_discount = :trek_discount WHERE trek_id = :trek_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_fee',$trekFees);
      $stmt->bindParam(':trek_discount',$discount);
      $stmt->bindParam(':trek_id',$id);
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
      $query = "UPDATE sg_trekingdetails SET popular_trek = :popular_trek  WHERE trek_id = :trek_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':popular_trek',$populartrek);
      $stmt->bindParam(':trek_id',$id);
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
      $query = "SELECT p.`name` as customerName, p.`mobile`, p.`email`, b.`trek_id` AS trekId, b.`booking_id` AS bookingId, b.`address`, b.`state`, b.`city`, b.`created_date` AS bookingDate, gettrekname(b.`trek_id`) as trekTitle, getparticipantscount(b.`booking_id`) AS personCnt, i.`trekstart_date` AS trekStartDate, i.`trekend_date` AS trekEndDate, pm.`payment_id` AS paymentId, pm.`original_amount` AS originalAmount, pm.`txn_id` AS txnId, getpayment_type(b.`booking_id`) AS paymentType, pm.`amount` from ".DBPREFIX."_paymentdetails pm RIGHT  JOIN ".DBPREFIX."_bookingdetails b ON pm.`booking_id`=b.`booking_id`, ".DBPREFIX."_inserttrekbatches i, ".DBPREFIX."_participantdetails p   WHERE b.`batch` = i.`batch_id` AND b.`booking_id` = p.booking_id AND i.batch_id = :batch_id AND pm.payment_id = (SELECT max(payment_id) FROM sg_paymentdetails WHERE booking_id =b.booking_id) ORDER BY b.booking_id DESC";
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
      $query = "SELECT p.`name` as customerName, p.`mobile` as mobile, b.`booking_id` AS bookingId, b.`address`, b.`state`, b.`city`, DATE_FORMAT(b.`created_date`,'%d %M %Y') AS bookingDate, gettrekname(b.`trek_id`) as trekName, getparticipantscount(b.`booking_id`) AS personCnt, Concat(DATE_FORMAT(i.`trekstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`trekend_date`,'%d %M %Y')) AS batchDate, pm.`payment_id` AS paymentId, pm.`txn_id` AS txnId, IFNULL(getpaymenttypename(b.`booking_id`),'pending Payment') AS paymentType, pm.`amount` FROM sg_paymentdetails pm RIGHT JOIN sg_bookingdetails b ON pm.`booking_id`=b.`booking_id`, sg_inserttrekbatches i, sg_participantdetails p  WHERE  b.`batch` = i.`batch_id` AND b.`booking_id` = p.booking_id ORDER BY b.booking_id DESC";
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
      $query = "SELECT `participant_id` AS participantId, `name`, `email`, `mobile`, `age`, `gender`, `height`, `weight`, `booking_id` AS bookingId, `created_date` AS createdDate  FROM sg_participantdetails WHERE booking_id=:booking_id";
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
      $query = "SELECT p.`name` as customerName,p.`email` as email,p.`age` as age,p.`gender` as gender,p.`height` as `height`,p.`weight`,p.`mobile` as mobile,b.`address` as billing,b.`state`,b.`city`,DATE_FORMAT(b.`created_date`,'%d %M %Y') as bookingDate,gettrekname(b.`trek_id`) as trekName,Concat(DATE_FORMAT(i.`trekstart_date`,'%d %M %Y'),' - ',DATE_FORMAT(i.`trekend_date`,'%d %M %Y')) as batchDate,pm.`txn_id` as transaction,IFNULL(getpaymenttypename(b.`booking_id`),'pending Payment') as paymentType,pm.`amount` as amount from sg_paymentdetails pm RIGHT  JOIN ".DBPREFIX."_bookingdetails b on pm.`booking_id`=b.`booking_id`, ".DBPREFIX."_inserttrekbatches i,".DBPREFIX."_participantdetails p   where b.`batch` = i.`batch_id` and b.`booking_id` = p.booking_id and b.booking_id = :booking_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':booking_id',$id);
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
  public function addOrganizer($data) {
    try {
      extract($data);
      $trekid = $id;
      $organizerid = $selectOrg;
      if(empty($trekid)||empty($organizerid)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
      else{
        $query = "INSERT INTO sg_trekorganizersmap(organizer_id,trek_id,           status,created_date,created_by) VALUES(:organizer_id,:trek_id,:status,:created_date,:created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':organizer_id', $selectOrg);
        $stmt->bindParam(':trek_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $trekorganizer_id = $this->connection->lastInsertId();
        if($trekorganizer_id!=''){
          $status = array(
            'status' => '200',
            'message' => 'TrekOrganizer Added Successfully',
            'trekorganizer_id' => $trekorganizer_id);
          
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
      $query = "SELECT organizer_id AS organizerId, org_name AS orgName, org_job AS orgJob, org_mobile AS orgMobile, where_reach AS whereReach, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_trekorganizers WHERE organizer_id IN (SELECT organizer_id FROM sg_trekorganizersmap WHERE trek_id = $trek_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekorganizers  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($trekorganizers!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekorganizers' => $trekorganizers);
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
  public function getOrganizerTreks($data) {
    try {
      extract($data);
      $query = "SELECT trek_id AS trekId, gettrekname(trek_id) as trekName, status, created_by AS createdBy, created_date AS createdDate FROM sg_trekorganizersmap WHERE organizer_id='$organizer_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($trekdetails!=''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekdetails' => $trekdetails);
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
      $query = "UPDATE ".DBPREFIX."_trekorganizersmap SET status='9' where tr_org_id=:tr_org_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tr_org_id',$id);
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
  public function addTrekCoupon($data) {
    try {
      extract($data);
      $trekid = $id;
      $couponid = $selectCoupon;
      if(empty($trekid)||empty($couponid)){
        $status = array(
        'status' => "206",
        'message' => "Failure Please enter proper data"
        );
      }
     else{
        $query = "INSERT INTO sg_trekcouponsmap(coupon_id,trek_id, status, created_date, created_by) VALUES(:coupon_id, :trek_id, :status, :created_date, :created_by)";
        $stmt = $this->connection->prepare($query);
        $created_date = date("Y-m-d H:i:s");
        $stmt->bindParam(':coupon_id', $selectCoupon);
        $stmt->bindParam(':trek_id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':created_date' ,$created_date);
        $stmt->bindParam(':created_by' ,$userBy);
        $stmt->execute();
        $trekcoupon_id = $this->connection->lastInsertId();
        if(!empty($trekcoupon_id)){
          $status = array(
            'status' => '200',
            'message' => 'Trekcoupon Added Successfully',
            'trekcoupon_id' => $trekcoupon_id);          
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
  public function getTrekCoupons($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id AS couponId, coupon_code as couponCode, coupon_name as couponName, valid_from as validFrom, valid_till as validTill, discount_amount AS discount, status, all_treks AS allTreks, coupon_type AS couponType, commision_status AS commisionStatus, commision_date AS commisionDate, commision_remarks AS commisionRemarks, coupon_limit AS couponLimit, coupon_value_limit AS couponValueLimit, coupon_value_decrease AS couponValueDecrease, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_trekcoupons WHERE coupon_id IN (SELECT coupon_id FROM sg_trekcouponsmap
               WHERE trek_id = '$trek_id' and status!='9')";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekcoupons  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($trekcoupons)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekcoupons' => $trekcoupons);
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
  public function getCouponTreks($data) {
    try {
      extract($data);
      $query = "SELECT trek_id AS trekId, gettrekname(trek_id) AS trekName, status, created_by AS createdBy, created_date AS createdDate FROM sg_trekcouponsmap WHERE coupon_id='$coupon_id' AND status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($trekdetails != ''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekdetails' => $trekdetails);
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
  public function deleteTrekCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_trekcouponsmap SET status='9' where trekcoupon_id=:tr_coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':tr_coupon_id',$id);
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
  public function getTrekGallery($data) {
    try {
      extract($data);
      $query = "SELECT image_id AS imageId, CONCAT('".UPLOADURL."treksgallery/',`image_name`) AS imageName, image_type AS imageType, trek_id AS trekId, recordstatus AS status, created_date AS createdDate, created_by AS createdBy FROM sg_trek_gallery WHERE `trek_id`=:trek_id AND recordstatus!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id', $trek_id);
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
  public function addTrekGallery($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_trek_gallery SET `image_name` = :image_name, trek_id=:trek_id,image_type=:image_type,created_date=:created_date,created_by=:created_by,recordstatus=:status";
      $stmt = $this->connection->prepare($query);
      $created_date=date("Y-m-d H:i:s");
      $stmt->bindParam(':image_name', $trekgalImage);
      $stmt->bindParam(':trek_id', $trekId);
      $stmt->bindParam(':image_type', $ext);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->bindParam(':status',$status);
      $stmt->execute();
      $image_id = $this->connection->lastInsertId();
      if(!empty($image_id)){
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
  public function deleteTrekGallery($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trek_gallery SET recordstatus='9' where image_id=:image_id";
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
  public function getTrekReviews() {
    try {
      $query ="SELECT `review_id` AS reviewId, `name`, `mobile_no` AS mobile, `rating`, `review`, gettrekname(`trek_id`) as trekTitle, recordstatus AS status, trek_id AS trekId FROM sg_trekreviews WHERE rating!='0'  order by review_id desc";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
          'status' => "200",
          'message' => "Success",
         'trek_reviews' => $results
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
  public function addTrekReview($data) {
    try {
      extract($data);
      $sql = "INSERT INTO sg_trekreviews (name, mobile_no, rating, review, trek_id, recordstatus, created_date, created_by, status) VALUES(:name, :mobile_no, :rating, :review, :trek_id, :recordstatus, :created_date, :created_by, :status)";
      $stmt = $this->connection->prepare($sql);      
      $recordstatus = '9';
      $status = '0';
      $created_date=date("Y-m-d H:i:s");
      $stmt->bindParam(":name", $name);
      $stmt->bindParam(":mobile_no",$mobile);
      $stmt->bindParam(":rating", $rating);
      $stmt->bindParam(":review", $review);
      $stmt->bindParam(":trek_id", $trekId);
      $stmt->bindParam(":recordstatus", $recordstatus);
      $stmt->bindParam(":created_date",$created_date);
      $stmt->bindParam(":created_by", $created_by);
      $stmt->bindParam(":status", $status);
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
  public function getTrekReview($data) {
    try {
      extract($data);
       $query ="SELECT review, name, rating+0.0 AS rating, mobile_no AS mobile, DATE_FORMAT(`created_date`,'%M %d,%Y') AS created_date FROM sg_trekreviews WHERE `trek_id`= '$trek_id' AND `recordstatus`='1' ORDER BY review_id DESC";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
          'status' => "200",
          'message' => "Success",
         'trek_reviews' => $results
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
  public function updateTrekReview($data) {
    try {
      extract($data);
      if($status == '0') {
        $upd_status = '1';
      } else {
        $upd_status = '0';
      }
      $query = "UPDATE sg_trekreviews SET recordstatus = :status WHERE review_id = :review_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status',$status);
      $stmt->bindParam(':review_id',$review_id);
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
  public function addTrekRentals($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_trekrentalitems(rentalitem, item_cost,
      trekbatch, trek_id, status, created_date, created_by) VALUES(:rentalitem, :item_cost, :trekbatch, :trek_id, :status, :created_date, :created_by)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':rentalitem', $rentalItem);
      $stmt->bindParam(':item_cost', $itemCost);
      $stmt->bindParam(':trekbatch', $trekBatch);
      $stmt->bindParam(':trek_id', $trekId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $trekrental_id = $this->connection->lastInsertId();
      if(!empty($trekrental_id)){
        $status = array(
          'status' => '200',
          'message' => 'TrekRental Added Successfully',
          'trekrental_id' => $trekrental_id);        
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
  public function getTrekRentals($data) {
    try {
      extract($data);
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, CONCAT('".UPLOADURL."rentals/',`image_1`) AS image_1, CONCAT('".UPLOADURL."rentals/',`image_2`) AS image_2, CONCAT('".UPLOADURL."rentals/',`image_3`) AS image_3, CONCAT('".UPLOADURL."rentals/',`image_4`) AS image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_trekrentalitems WHERE trek_id = $trek_id)";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekrentals  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($trekrentals)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekrentals' => $trekrentals);
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
  public function getRentalTreks($data) {
    try {
      extract($data);
      $query = "SELECT trek_id AS trekId, gettrekname(trek_id) AS trekName FROM sg_trekrentalitems WHERE rentalitem='$rental_id'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($trekdetails != ''){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekdetails' => $trekdetails);
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
      $query = "SELECT item_id AS itemId, item_name AS itemName, item_code AS itemCode, CONCAT('".UPLOADURL."rentals/',`image_1`) AS image_1, CONCAT('".UPLOADURL."rentals/',`image_2`) AS image_2, CONCAT('".UPLOADURL."rentals/',`image_3`) AS image_3, CONCAT('".UPLOADURL."rentals/',`image_4`) AS image_4, rental_category AS rentalCategory, non_returnable AS nonReturnable, status, created_date AS createdDate, created_by AS createdBy, modified_date AS modifiedDate, modified_by AS modifiedBy FROM sg_rental_items WHERE item_id IN (SELECT rentalitem FROM sg_trekrentalitems WHERE trekbatch = $batch_id)";
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
  public function getTrekBatchRental($data) {
    try {
      extract($data);
      $query = "SELECT b.batch_id AS batchId, b.trekstart_date AS trekStartDate, b.trekend_date AS trekEndDate, b.trekbatch_size trekBatchSize, b.trekbatch_status AS trekBatchStatus
                FROM sg_inserttrekbatches b  
                JOIN sg_trekrentalitems r
                ON b.batch_id = r.trekbatch";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $trekbatchdetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($trekbatchdetails)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'trekbatchdetails' => $trekbatchdetails);
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
  public function deleteTrekRental($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekrentalitems SET status='9' WHERE trekrentalitem_id=:trekrentalid";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trekrentalid',$id);
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
      $query = "SELECT b.`trek_id` AS trekId, b.`booking_id` AS bookingId, b.`address`, b.`city`, b.`state`, getparticipantscount(b.`booking_id`) as personsCnt, `payment_id` AS paymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` as amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as createdDate, gettrekname(b.`trek_id`) as trekTitle, ib.`trekstart_date` AS trekStartDate, ib.`trekend_date` AS trekEndDate, bb.`buyer_name` AS customerName, bb.`phone` AS mobile, bb.`email` FROM sg_beforebookingdetails bb, sg_inserttrekbatches ib, sg_paymentdetails pm inner join sg_bookingdetails b on pm.`booking_id` = b.`booking_id` where ib.`batch_id`=b.`batch` and bb.`booking_id` = b.`booking_id` order by pm.`payment_id` desc";
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
      $query = "SELECT  b.`trek_id` AS trekId, b.`booking_id` AS bookingId, b.`address`, b.`city`, b.`state`,getparticipantscount(b.`booking_id`) as personsCnt,`payment_id` AS paymentId, pm.`payment_type` AS paymentType, pm.`txn_id` AS txnId, pm.`amount` as amount, DATE_FORMAT(pm.`created_date`,'%d %M %Y') as createdDate, gettrekname(b.`trek_id`) as trekTitle, ib.`trekstart_date` AS trekStartDate, ib.`trekend_date` AS trekEndDate, bb.`buyer_name` AS customerName, bb.`phone` AS mobile, bb.`email`, getcutomergender(b.`booking_id`) as gender FROM sg_beforebookingdetails bb,sg_inserttrekbatches ib,sg_paymentdetails pm inner join sg_bookingdetails b on pm.`booking_id` = b.`booking_id` where ib.`batch_id`=b.`batch` and bb.`booking_id` = b.`booking_id` and  b.`booking_id`=:booking_id";
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
  public function addTrekFaq($data) {
    try {
      extract($data);
      $query = "INSERT INTO `sg_trek_faq`(`trek_id`, `cat_id`, `question`, `answer`, `status`, `created_by`, `created_date`) VALUES(:trek_id, :cat_id, :question, :answer, :status, :created_by, :created_date)";
      $created_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id', $trekId);
      $stmt->bindParam(':cat_id', $catId);
      $stmt->bindParam(':question', $question);
      $stmt->bindParam(':answer', $answer);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' ,$created_date);
      $stmt->bindParam(':created_by',$createdBy);
      $stmt->execute();
      $trekfaq_id = $this->connection->lastInsertId();
      if(!empty($trekfaq_id)){
        $status = array(
          'status' => '200',
          'message' => 'Trek Faq Added Successfully',
          'trekfaq_id' => $trekfaq_id);        
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
  public function updateTrekFaq($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_trek_faq` SET `trek_id` = :trek_id, `cat_id` = :cat_id, `question` = :question, `answer` = :answer, `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id', $trekId);
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
          'message' => 'Trek Faq Updated Successfully');        
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
      $query = "SELECT tf.*,(select category_title from sg_faq_categories where faq_cat_id=tf.cat_id) as cat_name FROM sg_trek_faq tf where tf.status='0' and tf.trek_id=".$trek_id;
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':trek_id', $trek_id);
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
  public function updateTrekStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_trekingdetails SET status = :status WHERE trek_id = :trek_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':trek_id', $trekId);
      if($stmt->execute()){
        $status = array(
        'status' => "200",
        'message' => "Success trek updated Successfully");
        return $status;
      }else{
        $status = array(
        'status' => "304",
        'message' => "Failure trek Not updated Successfully");
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
      $query = "UPDATE  sg_inserttrekbatches SET trekbatch_status = :status WHERE batch_id = :batch_id";
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
      $query = "UPDATE  sg_trekorganizersmap SET status = :status WHERE organizer_id = :organizer_id";
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
      $query = "UPDATE  sg_trekcouponsmap SET status = :status WHERE coupon_id = :coupon_id";
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
  public function updateTrekImageStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_trek_gallery SET recordstatus = :status WHERE image_id=:image_id";
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
  public function updateTrekRentalStatus($data) {
    try {
      extract($data);
      $query = "UPDATE  sg_trekrentalitems SET status = :status WHERE trekrentalitem_id =:trekrentalitem_id ";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':trekrentalitem_id ', $itemId );
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
  public function updateTrekFaqStatus($data) {
    try {
      extract($data);
      $query = "UPDATE `sg_trek_faq` SET `status` = :status, `modified_by` =:modified_by, `modified_date` = :modified_date WHERE faq_id=:faq_id";
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
          'message' => 'Trek Faq Updated Successfully');        
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
  public function generateCertificate($data) {
    try {
      extract($data);
      
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}