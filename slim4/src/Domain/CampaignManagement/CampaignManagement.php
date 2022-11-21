<?php
namespace App\Domain\CampaignManagement;

use App\Domain\CampaignManagement\CampaignManagementRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class CampaignManagement
{
  /**
   * @var CampaignManagementRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param CampaignManagementRepository $repository The repository
   */
  public function __construct(CampaignManagementRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getParticipants(): array
  {        
    $CampaignManagement = $this->repository->getParticipants();
    return $CampaignManagement;
  }
  public function getCampaignDetails(): array 
  {
    $CampaignManagement = (array) $this->repository->getCampaignDetails();
    return $CampaignManagement;
  }
  public function getTemplates() :array 
  {
    $templates = $this->repository->getTemplates();
    return $templates;
  }
  public function getContacts() {
    $templates = $this->repository->getContacts();
    return $templates;
  }
  public function getEnqUser() {
    $templates = $this->repository->getEnqUser();
    return $templates;
  }
  public function getParticipantDetails() {
    $templates = $this->repository->getParticipantDetails();
    return $templates;
  }
  public function addTemplate($data) {
    extract($data);
    if(isset($templateAttachment)&&!empty($templateAttachment)){
      $filedir = UPLOADPATH."campaignmanagement/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "banner_". $randName;
      $ext = substr($templateAttachment['name'], strrpos($templateAttachment['name'], '.') + 1);
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $templateAttachment;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = '100';
      $ImageUpload->NewHeight = '100';
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $template_attachment = $newName.".".strtolower($ext);
    }else{
      $template_attachment= $templateAttachment;
    }
    $data['template_attachment'] = $template_attachment;
    $templates = $this->repository->addTemplate($data);
    return $templates;
  }
  public function updateTemplate($data) {
    extract($data);
    if(isset($templateAttachment)&&!empty($templateAttachment)){
      $filedir = UPLOADPATH."campaignmanagement/"; 
      $randName = rand(10101010, 9090909090);
      $newName = "banner_". $randName;
      $ext = substr($templateAttachment['name'], strrpos($templateAttachment['name'], '.') + 1);
      $ImageUpload = new ImageUpload;
      $ImageUpload->File = $templateAttachment;
      $ImageUpload->method = 1;
      $ImageUpload->SavePath = $filedir;
      $ImageUpload->NewWidth = '100';
      $ImageUpload->NewHeight = '100';
      $ImageUpload->NewName = $newName;
      $ImageUpload->OverWrite = true;
      $err = $ImageUpload->UploadFile();
      $template_attachment = $newName.".".strtolower($ext);
    }else{
      $template_attachment= $templateAttachment;
    }
    $data['template_attachment'] = $template_attachment;
    $templates = $this->repository->updateTemplate($data);
    return $templates;
  }
  public function addEmailCampaign($data) {
    extract($data);
    if(isset($scheduleTime) && ($scheduleTime!='')){
      $scheduleTime = date("Y-m-d H:i:s", strtotime($scheduleTime));
    }
    else {
      $scheduleTime = date("Y-m-d H:i:s");
    }
    $data['scheduleTime'] = $scheduleTime;
    $data['createdDate'] = date("Y-m-d H:i:s");
    $data['owner'] = 1;
    //$data['createdBy'] = 1;
    if($groupType == 'Email'){      
      $templates = $this->repository->addEmailCampaign($data);
    }else if($groupType == 'SMS'){
      $templates = $this->repository->addSmsCampaign($data);
    }
    return $templates;    
  }
  public function getTemplateDetails($data) {
    $templates = $this->repository->getTemplateDetails($data);
    return $templates;    
  }
}