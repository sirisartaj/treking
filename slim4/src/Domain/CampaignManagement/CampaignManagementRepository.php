<?php
namespace App\Domain\CampaignManagement;
use PDO;
/**
* Repository.
*/
class CampaignManagementRepository
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
  public function getParticipants(): array
  {      
    try {
      $sql = "SELECT concat(`first_name`,' ',`last_name`) as name,`mobile`,`email` FROM sg_regestration UNION  SELECT `name`,`mobile`,`email` FROM sg_getincontacts UNION  SELECT `name`,`mobile`,`email` FROM sg_participantdetails";
      $stmt = $this->connection->prepare($sql);  
      $stmt->execute();
      $participants = $stmt->fetchAll(PDO::FETCH_OBJ);
      if(!empty($participants)){
       $status = array(
         'status' => ERR_OK,
         'message' =>"Success",
         'participants' => $participants);
         return $status;
      }else{
        $status = array('status' => ERR_NO_DATA,
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
  public function getCampaignDetails() {
    try {
      extract($data);
      $query = "SELECT  COALESCE(sum(CASE WHEN se.`sent_status`='0' THEN 1 END ),'0') as queued,count(se.`campaign_id`) send,sum(CASE WHEN se.response IS NOT NULL THEN 1 END ) as delivered FROM sg_campaigns se ";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
      $results['emailcounts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $query2 = "SELECT e.`campaign_name`,e.`to_email`,e.`to_phone_number`,count(e.`campaign_id`) as send,sum(CASE WHEN response NOT IN('bounced','failed') THEN 1 END) as delivered,e.`uniq_number`,DATE_FORMAT(e.`sent_date`,'%a %d, %M %Y') as sent_date FROM sg_campaigns e  group by e.`uniq_number`,e.`sent_date`,e.`campaign_name`,e.`to_email`,e.`to_phone_number`,e.`campaign_id` order by e.`campaign_id` desc";
      $stmt2 = $this->connection->prepare($query2);
      $stmt2->execute();
      $results['emaildetails'] = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($results)){
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success",
                  'emailcount' => $results['emailcounts'],
                  'emaildetails'=>$results['emaildetails']);
        return $status;
      }else{
        $status = array('status' => ERR_NO_DATA,
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
  public function getTemplates() {    
    try {
      $query = "SELECT `template_id` AS templateId, `template_name` AS templateName, `template_subject` AS templateSubject, `group_type` AS groupType, `template_content` AS templateContent, CONCAT('".UPLOADURL."campaignmanagement/', `template_attachment`)  AS templateAttachment, `created_date` AS createdDate, `updated_date` AS updatedDate, `created_by` AS createdBy  FROM sg_template";
      $stmt = $this->connection->prepare($query);  
      $res = $stmt->execute();
      $results= $stmt->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($results)){
        $status = array(
          'status' => '200',
          'message' => 'Success',
          'templates' => $results
        );
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
  public function getContacts() {
    try {
      $query = "SELECT concat(`first_name`,' ',`last_name`) as name,`mobile`,`email` FROM sg_regestration UNION  SELECT `name`,`mobile`,`email` FROM sg_getincontacts UNION  SELECT `name`,`mobile`,`email` FROM sg_participantdetails";
      $stmt = $this->connection->prepare($query);  
      $res = $stmt->execute();
      $results= $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($results){
         $status = array(
          'status' => '200',
          'message' => 'Success',
         'contacts'=>$results
        );
        return $status;
      }else{
        $status = array('status'=>ERR_NO_DATA,
     'message'=>"Failure");
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
  public function getEnqUser() 
  {
    try {
      $query = "SELECT DISTINCT(`person_email`) AS email, `person_name` AS name, `person_contact` AS contact FROM sg_searchformdetails group by `form_id`,`person_email`,`person_contact`,`person_name`";
      $stmt = $this->connection->prepare($query);
      $res = $stmt->execute();
      $results= $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($results){
        $status = array(
          'status' => '200',
          'message' => 'Success',
         'contacts'=>$results
        );        
      }else{
        $status = array('status'=>ERR_NO_DATA,
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
  public function getParticipantDetails() 
  {
    try {
      $query = "SELECT `name`,`mobile`,`email` FROM sg_participantdetails group by `name`,`mobile`,`email`";
      $stmt = $this->connection->prepare($query);
      $res = $stmt->execute();
      $results= $stmt->fetchAll(PDO::FETCH_ASSOC);
      if($results){
        $status = array(
          'status' => '200',
          'message' => 'Success',
         'participants'=>$results
        );        
      }else{
        $status = array('status'=>ERR_NO_DATA,
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
  public function addTemplate($data) {
    try {
      extract($data);
      $query = "INSERT INTO sg_template SET template_name=:template_name, group_type=:group_type , template_subject = :template_subject, template_content = :template_content, template_attachment = :template_attachment,created_date = :created_date,created_by = :created_by";
      $created_date = date("Y-m-d H:i:s");  
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':template_name', $templateName);
      $stmt->bindParam(':group_type', $groupType);
      $stmt->bindParam(':template_subject', $templateSubject);
      $stmt->bindParam(':template_content', $templateContent);
      $stmt->bindParam(':template_attachment', $template_attachment);
      $stmt->bindParam(':created_date', $created_date);
      $stmt->bindParam(':created_by', $createdBy);
      $res = $stmt->execute();
      $template_id = $this->connection->lastInsertId();
      if($template_id!='' && $template_id!='0'){
        $status = array(
          'status' => '200',
          'message' => ' Template Added Successfully',
          'template_id' => $template_id);
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
  public function updateTemplate($data) {
    try {
      extract($data);
      $query = "UPDATE sg_template SET template_name=:template_name, group_type=:group_type , template_subject = :template_subject, template_content = :template_content, template_attachment = :template_attachment, updated_date = :updated_date WHERE template_id = :template_id"; 
      $modified_date = date("Y-m-d H:i:s");
      $stmt = $this->connection->prepare($query);
      $stmt->bindParam(':template_name', $templateName);
      $stmt->bindParam(':group_type', $groupType);
      $stmt->bindParam(':template_subject', $templateSubject);
      $stmt->bindParam(':template_content', $templateContent);
      $stmt->bindParam(':template_attachment', $template_attachment);
      $stmt->bindParam(':updated_date', $modified_date);
      $stmt->bindParam(':template_id', $templateId);
      $res = $stmt->execute();
      if($res=='true')
      {
        $status = array(
        'status' => ERR_OK,
        'message' => "Successfully Updated");
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure"
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
  public function addEmailCampaign($data) {
    try {
      extract($data);
      $uniq_number = mt_rand(1000, 10000000);
      foreach($toEmail as $key => $email){
        $query = "CALL `add_sendEmailIndividual`(:email, :to_name, :campaign_name, :template_id, :schedule_time, :created_date, :uniq_number, :created_by, :created_date, :service_provider, @result)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':to_name', $toName[$key]);
        $stmt->bindParam(':campaign_name', $campaignName);
        $stmt->bindParam(':template_id', $templateId);
        $stmt->bindParam(':schedule_time' , $scheduleTime);
        $stmt->bindParam(':created_date' , $createdDate);
        $stmt->bindParam(':created_by' , $createdBby);
        $stmt->bindParam(':service_provider' , $serviceProvider);
        $stmt->bindParam(':uniq_number' , $uniq_number);
        $res = $stmt->execute();
      }
      if($res){           
        $status = array(
                  'status' => ERR_OK,
                  'message' => "Success");
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure"
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
  public function addSmsCampaign($data) {
    try {
      extract($data);
      $uniq_number = mt_rand(1000, 10000000);
      foreach($toNumber as $key => $mobile){
        $query = "CALL `add_sendSmsIndividual`(:mobile, :to_name, :campaign_name, :template_id, :created_date, :schedule_time, :uniq_number, :created_by, :created_date, @result)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':mobile', $mobile);
        $stmt->bindParam(':to_name', $toName[$key]);
        $stmt->bindParam(':campaign_name', $campaignName);
        $stmt->bindParam(':template_id', $templateId);
        $stmt->bindParam(':schedule_time' , $scheduleTime);
        $stmt->bindParam(':created_date' , $createdDate);
        $stmt->bindParam(':created_by' , $createdBy);
        $stmt->bindParam(':uniq_number' , $uniq_number);
        $res = $stmt->execute();
      }
      if($res){           
        $status = array(
        'status' => ERR_OK,
        'message' => "Success");
      }else{
        $status = array(
                  'status' => ERR_NOT_MODIFIED,
                  'message' => "Failure"
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
  public function getTemplateDetails($data) {
    try {
      extract($data);
      $query = "SELECT `template_id` AS templateId, `template_name` AS templateName, `template_subject` AS templateSubject, `group_type` AS groupType, `template_content` AS templateContent, CONCAT('".UPLOADURL."campaignmanagement/', `template_attachment`) AS templateAttachment, `created_date` AS createdDate, `updated_date` AS updatedDate, `created_by` AS createdBy FROM sg_template WHERE `template_id`=:template_id LIMIT 0,1";
      $stmt = $this->connection->prepare($query);  
      $stmt->bindParam(':template_id',$template_id);  
      $stmt->execute();
      $res = $stmt->fetch(PDO::FETCH_OBJ);
      if($res){           
        $status = array(
        'status' => ERR_OK,
        'message' => "Success",
        "template" => $res);
      }else{
        $status = array(
                  'status' => ERR_NO_DATA,
                  'message' => "Failure"
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