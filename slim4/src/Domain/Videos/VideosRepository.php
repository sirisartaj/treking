<?php
namespace App\Domain\Videos;
use PDO;
/**
* Repository.
*/
class VideosRepository
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
  public function getVideos(): array
  {      
    try {
      $sql = "SELECT video_id As videoId, video_title AS videoTitle, video_url AS videoUrl, published_date AS publishedDate, status, created_date AS createdDate, modified_date AS updatedDate, created_by AS createdBy, modified_by AS modifiedBy FROM sg_videos ORDER BY video_id DESC";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $videos = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($videos)){
       $status = array(
         'status' =>"200",
         'message' =>"Success",
         'videos' => $videos);
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
  public function getVideo($data) {
    try {
      extract($data);
      $sql = "SELECT video_title AS videoTitle, video_url AS videoUrl, published_date AS publishedDate,status, created_by AS createdBy, modified_by AS modifiedBy FROM ".DBPREFIX."_videos WHERE video_id = :video_id LIMIT 0,1";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(':video_id', $videoId);
      $stmt->execute();
      $videodetails = $stmt->fetch(PDO::FETCH_OBJ);
      if(!empty($videodetails)){
        $status = array(
                  'status' => "200",
                  'message' => "Success",
                  'videos' => $videodetails);
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
  public function deleteVideo($data) {    
    try {
      $sql = "DELETE FROM sg_videos WHERE video_id = :video_id";
      $stmt = $this->connection->prepare($sql);  
      $stmt->bindParam(":video_id",$videoId);
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
    } catch(PDOException $e) {
      $status = array(
              'status' => "500",
              'message' => $e->getMessage()
          );
      return $status;
    } 
  }
  public function addVideo($data) {
    try {
      extract($data);
      $sql = "INSERT INTO ".DBPREFIX."_videos SET video_title=:video_title, video_url=:video_url, published_date = :published_date, status = :status , created_date = :created_date, created_by = :created_by";
      $stmt = $this->connection->prepare($sql);  
      $created_date = date("Y-m-d H:i:s");
      $stmt->bindParam(":video_title", $videoTitle);
      $stmt->bindParam(":video_url", $videoUrl);
      $stmt->bindParam(":published_date", $publishedDate);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":created_date", $created_date);
      $stmt->bindParam(":created_by", $userBy);
      $res = $stmt->execute();
      $video_id = $this->connection->lastInsertId();
      if($video_id){
        $status = array(
          "status" => "200",
          "message" => "Added Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
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
  public function updateVideo($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE sg_videos SET video_title=:video_title, video_url=:video_url , published_date = :published_date , status = :status ,modified_date = :modified_date, modified_by = :modified_by WHERE video_id = :video_id";  
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(":video_title", $videoTitle);
      $stmt->bindParam(":video_url", $videoUrl);
      $stmt->bindParam(":published_date", $publishedDate);
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":modified_date", $modified_date);
      $stmt->bindParam(":modified_by", $userBy);
      $stmt->bindParam(":video_id", $videoId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => "200",
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
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
  public function updateVideoStatus($data) 
  {
    try {
      extract($data);
      $sql  = "UPDATE sg_videos SET status = :status, modified_date = :modified_date, modified_by = :modified_by WHERE video_id = :video_id";  
      $stmt = $this->connection->prepare($sql);
      $modified_date = date("Y-m-d H:i:s");
      $stmt->bindParam(":status", $status);
      $stmt->bindParam(":modified_date", $modified_date);
      $stmt->bindParam(":modified_by", $userBy);
      $stmt->bindParam(":video_id", $videoId);
      $res = $stmt->execute();
      if($res){
        $status = array(
          "status" => "200",
          "message" => "Updated Successfully");
        return $status;
      }else{
        $status = array(
          "status" => "304",
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