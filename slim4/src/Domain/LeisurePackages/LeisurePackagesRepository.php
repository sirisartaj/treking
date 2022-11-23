<?php
namespace App\Domain\LeisurePackages;
use PDO;
/**
* Repository.
*/
class LeisurePackagesRepository
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
  public function getLeisurePackages(): array
  {      
    try {
      $query = "SELECT `leisure_id` AS leisureId, `pkg_name` AS pkgName, `pkg_days` AS pkgDays, `pkg_nights` AS pkgNights, `suitable_for` AS suitableFor, `single_price` AS singlePrice, `couple_price` AS couplePrice, `family_price` AS familyPrice, `pkg_overview` AS pkgOverview, `pkg_activities` AS pkgActivities, `hotel_name` AS hotelName, CONCAT('".UPLOADURL."packages/hotel/',`hotel_image`) AS hotelImage, `hotel_location` AS hotelLocation, `inclusion_exclusion` AS inclusionExclusion, `where_report` AS whereReport, `terms_conditions` AS termsConditions, `faq`, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, CONCAT('".UPLOADURL."packages/',`pkg_image`) AS pkgImage, CONCAT('".UPLOADURL."packages/',`pkg_pagebanner`) AS pkgPageBanner, `popular_pkg` AS popularPkg, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM `sg_leisurepackages` WHERE status != '9'";      
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results =$stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($results)){
        $status = array(
         'status' =>"200",
         'message' =>"Success",
         'allLeisurePackages' => $results);        
      }else{
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
  public function addLeisurePackage($data) {
    try {
		//print_r($data);exit;
      extract($data);
      $query = "INSERT INTO sg_leisurepackages(pkg_name, pkg_days,pkg_overview,inclusion_exclusion,where_report,terms_conditions, status, created_date, created_by) VALUES (:pkg_name, :pkg_days, :pkg_overview,:inclusion_exclusion, :where_report, :terms_conditions, :status, :created_date, :created_by)";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':pkg_name', $pkg_name);
      $stmt->bindParam(':pkg_days', $pkg_days);
      $stmt->bindParam(':pkg_overview', $pkg_overview);
      $stmt->bindParam(':inclusion_exclusion', $inclusion_exclusion);
      $stmt->bindParam(':where_report', $where_report);
      $stmt->bindParam(':terms_conditions', $terms_conditions);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date',$created_date);
      $stmt->bindParam(':created_by',$created_by);
      if($stmt->execute()){
        $lpkg_id= $this->connection->lastInsertId();
        
        
        $status = array(
          'status' => "200",
          'message' => "Packages Added Successfully");
      } else{
        $status = array(
          'status' => "304",
          'message' => "Packages Not Added Successfully");
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
  public function updateLeisurePackage($data) {
    try {
      extract($data);
	  $pkg_overview1 = addslashes($pkg_overview);
	  $terms_conditions1 = addslashes($terms_conditions);
     $query = "UPDATE sg_leisurepackages SET pkg_name='".$pkg_name."',pkg_overview = '".$pkg_overview1."', inclusion_exclusion = '".$inclusion_exclusion."',    where_report ='".$where_report."', terms_conditions = '".$terms_conditions1."', modified_date = '".$modified_date."', modified_by='".$modified_by."' where leisure_id = '".$leisure_id."'";
	
      $stmt = $this->connection->prepare($query);
      
      //$stmt->bindParam(':leisure_id',$leisureId);
      if($stmt->execute()){
        
        
        $status = array(
          'status' => "200",
          'message' => "Packages Updated Successfully");
      } else{
        $status = array(
          'status' => "304",
          'message' => "Packages Not Updated Successfully");
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
  public function addLeisureIterinary($data){
	  try {
		  extract($data);
		  $query3 = "INSERT INTO sg_leisurepkgitinerary SET title=:title, description=:description , leisurepkg_id = :lpkg_id,created_date = :created_date, created_by=:created_by, status=:status";
            $stmt3 = $this->connection->prepare($query3);
            $stmt3->bindParam(':title', $title);
            $stmt3->bindParam(':description', $description);
            $stmt3->bindParam(':lpkg_id', $leisure_id);
            $stmt3->bindParam(':created_by',$user);
            $stmt3->bindParam(':created_date' ,$ndate);
            $stmt3->bindParam(':status', $status);
            $r = $stmt3->execute();
			if($r){
				$status = array(
				  'status' => "200",
				  'message' => 'Added'
			  );
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
  public function updateLeisureitinerary($data){
	 // print_r($data);exit;
	 try {
	  extract($data);
          if(@$lpitinerary_id){
            $query2 = "UPDATE sg_leisurepkgitinerary SET title=:title, description=:description, modified_date = :modified_date, modified_by =:modified_by where lpitinerary_id = :lpitinerary_id";
            $stmt2 = $this->connection->prepare($query2);
            $stmt2->bindParam(':title', $title);
            $stmt2->bindParam(':description', $description);
            $stmt2->bindParam(':modified_date' ,$ndate);
            //$stmt2->bindParam(':status', $status);
            $stmt2->bindParam(':modified_by',$user);
            $stmt2->bindParam(':lpitinerary_id', $lpitinerary_id);
            $r = $stmt2->execute();
			
          }
          else {
            $query3 = "INSERT INTO sg_leisurepkgitinerary SET title=:title, description=:description , leisurepkg_id = :lpkg_id,created_date = :created_date, created_by=:created_by, status=:status";
            $stmt3 = $this->connection->prepare($query3);
            $stmt3->bindParam(':title', $title);
            $stmt3->bindParam(':description', $description);
            $stmt3->bindParam(':lpkg_id', $leisure_id);
            $stmt3->bindParam(':created_by',$user);
            $stmt3->bindParam(':created_date' ,$ndate);
            $stmt3->bindParam(':status', $status);
            $r = $stmt3->execute();
          }
		  
			  if($r){
					$status = array(
					  'status' => "200",
					  'message' => 'updated'
				  );
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
  public function getItineraryLeisure($data){
	   try {
		   
      extract($data);
      
      $query2 = "SELECT  * FROM sg_leisurepkgitinerary WHERE leisurepkg_id = :leisurepkg_id and status !='9'";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->bindParam(':leisurepkg_id',$lepkg, PDO::PARAM_STR);
     $r = $stmt2->execute();
	
      $res= $stmt2->fetchAll(PDO::FETCH_OBJ);
	 
      if(!empty($res)){
        $status = array(
          "status" => "200",
          "message" =>  "Success",
          "leisure" => $res);
      }else{
         $status = array(
          "status" => "204",
           "message" => "Failure");
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
  public function getLeisurePackage($data) {
    try {
      extract($data);
      $query = "SELECT `leisure_id` AS leisureId, `pkg_name` AS pkgName, `pkg_days` AS pkgDays, `pkg_nights` AS pkgNights, `suitable_for` AS suitableFor, `single_price` AS singlePrice, `couple_price` AS couplePrice, `family_price` AS familyPrice, `pkg_overview` AS pkgOverview, `pkg_activities` AS pkgActivities, `hotel_name` AS hotelName, CONCAT('".UPLOADURL."packages/hotel/',`hotel_image`) AS hotelImage, `hotel_location` AS hotelLocation, `inclusion_exclusion` AS inclusionExclusion, `where_report` AS whereReport, `terms_conditions` AS termsConditions, `faq`, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate, CONCAT('".UPLOADURL."packages/',`pkg_image`)  AS pkgImage, CONCAT('".UPLOADURL."packages/',`pkg_pagebanner`) AS pkgPageBanner, `popular_pkg` AS popularPkg, `created_by` AS createdBy, `modified_by` AS modifiedBy FROM sg_leisurepackages WHERE leisure_id = :leisure_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':leisure_id',$lepkg_id);
      $stmt->execute();
      $res['Packages'] = $stmt->fetch(PDO::FETCH_OBJ);
      $query2 = "SELECT  `lpitinerary_id` AS lpitineraryId, `title`, `description`, `leisurepkg_id` AS leisurepkgId, `created_date` AS createdDate, `modified_date` AS modifiedDate, `created_by` AS createdBy, `modified_by` AS modifiedBy, `status` FROM sg_leisurepkgitinerary WHERE leisurepkg_id = :leisurepkg_id LIMIT 0,1";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->bindParam(':leisurepkg_id',$lepkg_id);
      $stmt2->execute();
      $res['lpitinerary'] = $stmt2->fetchAll(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
          "status" => "200",
          "message" =>  "Success",
          "leisure" => $res);
      }else{
         $status = array(
          "status" => "204",
           "message" => "Failure");
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
  public function updateLeisurePackageStatus($data) {
    try {
		
      extract($data);
      $query = "UPDATE sg_leisurepackages SET status = :status, modified_date = :modified_date, modified_by=:modified_by where leisure_id = :leisure_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date',$modified_date);
      $stmt->bindParam(':modified_by',$modified_by);
      $stmt->bindParam(':leisure_id',$leisure_id);
      if($stmt->execute()){
        $status = array(
          'status' => "200",
          'message' => "Row deleted Successfully");
      } else{
        $status = array(
          'status' => "304",
          'message' => "Packages Not Updated Successfully");
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
  public function UpdateLeisurePackageitiStatus($data) {
    try {
		
      extract($data);
      $query = "UPDATE sg_leisurepkgitinerary SET status = :status, modified_date = :modified_date, modified_by=:modified_by where lpitinerary_id  = :lpitinerary_id";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':modified_date',$modified_date, PDO::PARAM_STR);
      $stmt->bindParam(':modified_by',$modified_by, PDO::PARAM_STR);
      $stmt->bindParam(':lpitinerary_id',$lpitinerary_id, PDO::PARAM_STR);
      if($stmt->execute()){
        $status = array(
          'status' => "200",
          'message' => "Row deleted Successfully");
      } else{
        $status = array(
          'status' => "304",
          'message' => "Packages Not Updated Successfully");
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
  public function addAddOnActivity($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_lpaddonactivities SET activity_name=:activity_name, activity_desc=:activity_desc, activity_price = :activity_price, lepkg_id = :lepkg_id, status = :status, created_date = :created_date";
      $stmt = $this->connection->prepare($query);
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':activity_name', $activityName);
      $stmt->bindParam(':activity_desc', $activityDesc);
      $stmt->bindParam(':activity_price', $activityPrice);
      $stmt->bindParam(':lepkg_id', $lepkgId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':created_date' , $created_date);
      $stmt->execute();
      $insert_id = $this->connection->lastInsertId();
      if($insert_id!=''){
        $status = array(
          'status' => '200',
          'message' => 'Added Successfully',
          'activity_id' => $insert_id);
      }else{
        $status = array(
                  'status' => "304",
                  'message' => "Not Added Successfully"
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
  public function updateAddOnActivity($data) {
    try {
      extract($data);
      $query = "UPDATE sg_lpaddonactivities SET activity_name=:activity_name, activity_desc=:activity_desc, activity_price = :activity_price, status = :status, modified_date = :modified_date where lpactivity_id =:lpactivity_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':activity_name', $activityName);
      $stmt->bindParam(':activity_desc', $activityDesc);
      $stmt->bindParam(':activity_price', $activityPrice);
      $stmt->bindParam(':lpactivity_id', $lpactivityId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $res=$stmt->execute();
     if($res == 'true')
      {
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
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
  public function getAddOnActivity($data) {
    try {
      extract($data);
      $query = "SELECT `lpactivity_id` AS lpactivityId, `activity_name` AS activityName, `activity_desc` AS activityDesc, `activity_price` AS activityPrice, `lepkg_id` AS lepkgId, `status`, `created_date` AS createdDate, `modified_date` AS modifiedDate FROM  sg_lpaddonactivities WHERE  lpactivity_id = :lpactivity_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':lpactivity_id',$activity_id);
      $stmt->execute();
      $res= $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($res)){
        $status = array(
          "status" => "200",
          "message" =>  "Success",
          "pactivity" => $res);
      }else{
        $status = array(
          "status" => "204",
          "message" => "Failure");
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
  public function updateAddOnActivityStatus($data) {
    try {
      extract($data);
      $query = "UPDATE sg_lpaddonactivities SET status = :status, modified_date = :modified_date where lpactivity_id =:lpactivity_id";
      $stmt = $this->connection->prepare($query);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(':lpactivity_id', $lpactivityId);
      $stmt->bindParam(':status', $status);
      $stmt->bindParam(':modified_date' , $modified_date);
      $res=$stmt->execute();
     if($res == 'true')
      {
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
    }catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    }
  }
}