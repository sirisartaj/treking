<?php
namespace App\Domain\Coupons;
use PDO;
/**
* Repository.
*/
class CouponsRepository
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
  public function getCoupons(): array
  {      
    try{
      $query = "SELECT coupon_id as id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_treks,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage  FROM sg_trekcoupons WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $coupondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($coupondetails!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'couponsdetails' => $coupondetails);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
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
  public function addCoupon($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_trekcoupons (coupon_name,coupon_code,valid_from,valid_till,discount_perc, discount_amount,status,created_date, created_by,all_treks,coupon_type,coupon_partners, commision_status, commision_date, commision_remarks,coupon_limit,coupon_value_limit, coupon_value_decrease, coupon_image)VALUES(:coupon_name,:coupon_code,:valid_from,:valid_till,:discount_perc,:discount_amount,:status,:created_date,:created_by,:all_treks,:coupon_type,:coupon_partners,:commision_status,:commision_date,:commision_remarks,:coupon_limit,:coupon_value_limit,:coupon_value_decrease, :coupon_image)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $userBy);
      $stmt->bindParam(':all_treks', $alltreks);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->execute();
      $coupon_id = $this->connection->lastInsertId();
      if(!empty($coupon_id) && $coupon_id!='0'){
        $status = array(
          'status' => ERR_OK,
          'message' => ' Coupon Added Successfully',
          'coupon_id' => $coupon_id);
        
      }else{
         $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Coupon Not Added Successfully"
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
  public function checkCouponName($couponname)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_trekcoupons where `coupon_name`='$couponname'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function checkCouponCode($couponcode)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_trekcoupons where `coupon_code`='$couponcode'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    }catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getCoupon($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_treks,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage FROM sg_trekcoupons WHERE coupon_id = :coupon_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':coupon_id',$coupon_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
           $status = array(
            "status" => "200",
             "message" =>  "Success",
              "coupondetails" => $res);
        }else{
           $status = array(
            "status" => ERR_NO_DATA,
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
  public function checkNameCoupon($couponname,$couponid)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_trekcoupons where `coupon_name`='$couponname'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }      
  }
  public function checkCodeCoupon($couponcode,$couponid)
  {
    try { 
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_trekcoupons where `coupon_code`='$couponcode'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }  
  }
  public function updateCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekcoupons SET coupon_name = :coupon_name, coupon_code = :coupon_code, valid_from=:valid_from , valid_till = :valid_till,discount_perc=:discount_perc, 
     discount_amount=:discount_amount, status = :status , modified_date = :modified_date,
      modified_by = :modified_by, all_treks =:all_treks, coupon_type=:coupon_type, coupon_partners=:coupon_partners, commision_status=:commision_status, commision_date=:commision_date, 
     commision_remarks = :commision_remarks, coupon_limit = :coupon_limit, 
     coupon_value_limit = :coupon_value_limit, coupon_value_decrease = :coupon_value_decrease, coupon_image = :coupon_image WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':all_treks', $alltreks);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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
  public function deleteCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_trekcoupons SET status='9' where coupon_id=:coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':coupon_id',$coupon_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Coupon Deleted Successfully");
      }else{
       $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Coupon Not Deleted Successfully");
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
  public function updateCouponStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_trekcoupons SET status = :status , modified_date = :modified_date,
      modified_by = :modified_by WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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
  /*
  * Bike trips Coupons
  */
  public function getTripCoupons(): array
  {      
    try{
      $query = "SELECT coupon_id as id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_trips,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage  FROM sg_tripcoupons WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $coupondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($coupondetails!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'couponsdetails' => $coupondetails);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
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
  public function addTripCoupon($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_tripcoupons (coupon_name,coupon_code,valid_from,valid_till,discount_perc, discount_amount,status,created_date, created_by,all_trips,coupon_type,coupon_partners, commision_status, commision_date, commision_remarks,coupon_limit,coupon_value_limit, coupon_value_decrease, coupon_image)VALUES(:coupon_name,:coupon_code,:valid_from,:valid_till,:discount_perc,:discount_amount,:status,:created_date,:created_by,:all_trips,:coupon_type,:coupon_partners,:commision_status,:commision_date,:commision_remarks,:coupon_limit,:coupon_value_limit,:coupon_value_decrease, :coupon_image)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $userBy);
      $stmt->bindParam(':all_trips', $alltrips);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->execute();
      $coupon_id = $this->connection->lastInsertId();
      if(!empty($coupon_id) && $coupon_id != '0'){
        $status = array(
          'status' => ERR_OK,
          'message' => ' Coupon Added Successfully',
          'coupon_id' => $coupon_id);
        
      }else{
         $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Coupon Not Added Successfully"
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
  public function checkTripCouponName($couponname)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_tripcoupons where `coupon_name`='$couponname'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function checkTripCouponCode($couponcode)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_tripcoupons where `coupon_code`='$couponcode'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    }catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getTripCoupon($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_trips,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage FROM sg_tripcoupons WHERE coupon_id = :coupon_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':coupon_id',$coupon_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
           $status = array(
            "status" => "200",
             "message" =>  "Success",
              "coupondetails" => $res);
        }else{
           $status = array(
            "status" => ERR_NO_DATA,
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
  public function checkNameTripCoupon($couponname,$couponid)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_tripcoupons where `coupon_name`='$couponname'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }      
  }
  public function checkCodeTripCoupon($couponcode,$couponid)
  {
    try { 
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_tripcoupons where `coupon_code`='$couponcode'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }  
  }
  public function updateTripCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE sg_tripcoupons SET coupon_name = :coupon_name, coupon_code = :coupon_code, valid_from=:valid_from , valid_till = :valid_till,discount_perc=:discount_perc,      discount_amount=:discount_amount, status = :status , modified_date = :modified_date,      modified_by = :modified_by, all_trips =:all_trips, coupon_type=:coupon_type, coupon_partners=:coupon_partners, commision_status=:commision_status, commision_date=:commision_date,      commision_remarks = :commision_remarks, coupon_limit = :coupon_limit,     coupon_value_limit = :coupon_value_limit, coupon_value_decrease = :coupon_value_decrease, coupon_image=:coupon_image WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':all_trips', $alltrips);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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
  public function deleteTripCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_tripcoupons SET status='9' where coupon_id=:coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':coupon_id',$coupon_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Coupon Deleted Successfully");
      }else{
       $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Coupon Not Deleted Successfully");
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
  public function updateTripCouponStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_tripcoupons SET status = :status , modified_date = :modified_date,
      modified_by = :modified_by WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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
  /*
  * Expedition Coupons
  */
  public function getExpeditionCoupons(): array
  {      
    try{
      $query = "SELECT coupon_id as id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_expeditions,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage  FROM sg_expeditioncoupons WHERE status!='9'";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $coupondetails  = $stmt->fetchAll(PDO::FETCH_OBJ);
      if($coupondetails!=''){
        $status = array(
          'status' => ERR_OK,
          'message' => 'Success',
          'couponsdetails' => $coupondetails);
      }
      else{
       $status = array('status'=>ERR_NO_DATA,
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
  public function addExpeditionCoupon($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_expeditioncoupons (coupon_name,coupon_code,valid_from,valid_till,discount_perc, discount_amount,status,created_date, created_by,all_expeditions,coupon_type,coupon_partners, commision_status, commision_date, commision_remarks,coupon_limit,coupon_value_limit, coupon_value_decrease, coupon_image)VALUES(:coupon_name,:coupon_code,:valid_from,:valid_till,:discount_perc,:discount_amount,:status,:created_date,:created_by,:all_expeditions,:coupon_type,:coupon_partners,:commision_status,:commision_date,:commision_remarks,:coupon_limit,:coupon_value_limit,:coupon_value_decrease, :coupon_image)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->bindParam(':created_by' , $userBy);
      $stmt->bindParam(':all_expeditions', $allExpeditions);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->execute();
      $coupon_id = $this->connection->lastInsertId();
      if(!empty($coupon_id) && $coupon_id != '0'){
        $status = array(
          'status' => ERR_OK,
          'message' => ' Coupon Added Successfully',
          'coupon_id' => $coupon_id);
        
      }else{
         $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Coupon Not Added Successfully"
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
  public function checkExpeditionCouponName($couponname)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_expeditioncoupons where `coupon_name`='$couponname'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function checkExpeditionCouponCode($couponcode)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_expeditioncoupons where `coupon_code`='$couponcode'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    }catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }
  }
  public function getExpeditionCoupon($data) {
    try {
      extract($data);
      $query = "SELECT coupon_id,coupon_code as couponCode,coupon_name as couponName,valid_from as validFrom,valid_till as validTill,discount_amount as discount,discount_amount as discountAmount,status,all_expeditions,coupon_type,coupon_type,commision_status as commissionStatus,commision_date as commissionDate,commision_remarks as commissionRemarks,coupon_limit,coupon_value_limit,coupon_value_decrease,created_date,created_by,modified_date,modified_by, coupon_image AS couponImage FROM sg_expeditioncoupons WHERE coupon_id = :coupon_id";
       $stmt = $this->connection->prepare($query);
       $stmt->bindParam(':coupon_id',$coupon_id);
       $stmt->execute();
       $res = $stmt->fetchAll(PDO::FETCH_OBJ);
       if(!empty($res)){
           $status = array(
            "status" => "200",
             "message" =>  "Success",
              "coupondetails" => $res);
        }else{
           $status = array(
            "status" => ERR_NO_DATA,
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
  public function checkNameExpeditionCoupon($couponname,$couponid)
  {
    try {
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_expeditioncoupons where `coupon_name`='$couponname'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }      
  }
  public function checkCodeExpeditionCoupon($couponcode,$couponid)
  {
    try { 
      $sql = "SELECT count(`coupon_id`) as cnt FROM " . DBPREFIX . "_expeditioncoupons where `coupon_code`='$couponcode'and coupon_id!='$couponid'";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      $cnt = $count->cnt;
      return $cnt;
    } catch(PDOException $e) {
      $status = array(
            'status' => "500",
            'message' => $e->getMessage()
        );
      return $status;
    }  
  }
  public function updateExpeditionCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditioncoupons SET coupon_name = :coupon_name, coupon_code = :coupon_code, valid_from=:valid_from , valid_till = :valid_till,discount_perc=:discount_perc,      discount_amount=:discount_amount, status = :status , modified_date = :modified_date,      modified_by = :modified_by, all_Expeditions =:all_expeditions, coupon_type=:coupon_type, coupon_partners=:coupon_partners, commision_status=:commision_status, commision_date=:commision_date,      commision_remarks = :commision_remarks, coupon_limit = :coupon_limit,     coupon_value_limit = :coupon_value_limit, coupon_value_decrease = :coupon_value_decrease, coupon_image = :coupon_image WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $valid_from = date("Y-m-d", strtotime($validFrom));
      $valid_till = date("Y-m-d", strtotime($validTill));
      $stmt->bindParam(':coupon_name', $couponName);
      $stmt->bindParam(':coupon_code', $couponCode);
      $stmt->bindParam(':valid_from', $valid_from);
      $stmt->bindParam(':valid_till', $valid_till);
      $stmt->bindParam(':discount_perc', $discountPerc);
      $stmt->bindParam(':discount_amount', $discountAmount);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':all_expeditions', $allexpeditions);
      $stmt->bindParam(':coupon_type', $couponType);
      $stmt->bindParam(':coupon_partners', $couponPartners);
      $stmt->bindParam(':commision_status', $commisionStatus);
      $stmt->bindParam(':commision_date' , $commissionDate);
      $stmt->bindParam(':commision_remarks', $commissionRemarks);
      $stmt->bindParam(':coupon_limit', $couponLimit);
      $stmt->bindParam(':coupon_value_limit', $couponValueLimit);
      $stmt->bindParam(':coupon_value_decrease', $couponValueDecrease);
      $stmt->bindParam(':coupon_image', $couponImage);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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
  public function deleteExpeditionCoupon($data) {
    try {
      extract($data);
      $query = "UPDATE ".DBPREFIX."_expeditioncoupons SET status='9' where coupon_id=:coupon_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':coupon_id',$coupon_id);
      $res=$stmt->execute();
      if($res=='true'){
        $status = array(
          "status" => "200",
          "message" => "Coupon Deleted Successfully");
      }else{
       $status = array(
          "status" => ERR_NOT_MODIFIED,
          "message" => "Coupon Not Deleted Successfully");
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
  public function updateExpeditionCouponStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_expeditioncoupons SET status = :status , modified_date = :modified_date,
      modified_by = :modified_by WHERE coupon_id = :coupon_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $stmt->bindParam(':modified_by' , $userBy);
      $stmt->bindParam(':coupon_id', $couponId);
      $res=$stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => "200",
        'message' => "Coupon Successfully Updated");
        
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure Coupon not updated Successfully"
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