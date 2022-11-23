<?php
namespace App\Domain\Expeditions;

use App\Domain\Expeditions\ExpeditionsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class Expeditions
{
  /**
   * @var ExpeditionsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param ExpeditionsRepository $repository The repository
   */
  public function __construct(ExpeditionsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getExpeditions(): array
  {        
    $Expeditions = $this->repository->getExpeditions();
    return $Expeditions;
  }
  public function addExpedition($data) {
    extract($data);
    if(empty($expeditionTitle))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure Expedition name is required"
      );
    }else{
      $expeditionExist = $this->repository->checkExpeditionName($expeditionTitle);
      if($expeditionExist == '0')
      {
        if(isset($expeditionImage['name'])&&!empty($expeditionImage['name']))
        {
          $filedir = UPLOADPATH."expeditions/"; 
          $randName = rand(10101010, 9090909090);
          $newName = "Expedition_". $randName;
          $ext = substr($expeditionImage['name'], strrpos($expeditionImage['name'], '.') + 1);
          list($width, $height) = getimagesize($expeditionImage['tmp_name']); 
          if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $expeditionImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = $width;
            $ImageUpload->NewHeight = $height;
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $expeditionImage = $newName.".".strtolower($ext);
          }
          else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
            return $status;
          }
        }
        if(isset($overviewImage['name'])&&!empty($overviewImage['name'])){
          $filedir = UPLOADPATH."expeditions/"; 
          $randName = rand(10101010, 9090909090);
          $newName = "Expeditionpagebanner_". $randName;
          $ext = substr($overviewImage['name'], strrpos($overviewImage['name'], '.') + 1);
          list($width, $height) = getimagesize($overviewImage['tmp_name']); 
          if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
            $ImageUpload = new ImageUpload;
            $ImageUpload->File = $overviewImage;
            $ImageUpload->method = 1;
            $ImageUpload->SavePath = $filedir;
            $ImageUpload->NewWidth = $width;
            $ImageUpload->NewHeight = $height;
            $ImageUpload->NewName = $newName;
            $ImageUpload->OverWrite = true;
            $err = $ImageUpload->UploadFile();
            $overviewImage = $newName.".".strtolower($ext);
          }
          else{
            $status = array(
              'status' => "304",
              'message' => "Failure Please upload jpg,png,gift,jpeg images only"
            );
            return $status;
          }
        }
        $created_date = date("Y-m-d H:i:s");
        $data['expeditionImage'] = $expeditionImage;
        $data['overviewImage'] = $overviewImage;
        $data['createdDate'] = $created_date;
        $expeditionId = $this->repository->insertExpedition($data);
        if(!empty($expeditionId) && $expeditionId != '0'){  
          $data1['description'] = $description;
          $data1['title'] = @$title;       
          $count = 0;
          foreach($data1 as $value){
            $count = sizeof($value); 
          } 
          for($x = 0;$x < $count;$x++){
            $data1['expeditionId'] = $expeditionId;
            $data1['description'] = $description[$x];
            $data1['title'] = @$title[$x];
            $data1['createdDate'] = $created_date;
            $data1['createdBy'] = $created_by;
            $data1['status'] = $status;
            $iterinary = $this->repository->addExpeditionIterinaryDetails($data1);
          }
          if(isset($pumpupImage['name'])&&!empty($pumpupImage['name'])){
            $filedir = UPLOADPATH."expeditions/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "Expeditionpumpup_". $randName;
            $ext = substr($pumpupImage['name'], strrpos($pumpupImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($pumpupImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $pumpupImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $pumpupImage = $newName.".".strtolower($ext);
            }else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($bfImage['name'])&&!empty($bfImage['name'])){
            $filedir = UPLOADPATH."expeditions/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "Expeditionbf_". $randName;
            $ext = substr($bfImage['name'], strrpos($bfImage['name'], '.') + 1);
            list($width, $height) = getimagesize($bfImage['tmp_name']);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){ 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $bfImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $bfImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($lunchImage['name'])&&!empty($lunchImage['name'])){
            $filedir = UPLOADPATH."expeditions/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "ExpeditionlunchImage_". $randName;
            $ext = substr($lunchImage['name'], strrpos($lunchImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($lunchImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $lunchImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $lunchImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          if(isset($evngImage['name'])&&!empty($evngImage['name'])){
            $filedir = UPLOADPATH."expeditions/food/"; 
            $randName = rand(10101010, 9090909090);
            $newName = "ExpeditionevngImage_". $randName;
            $ext = substr($evngImage['name'], strrpos($evngImage['name'], '.') + 1);
            if(($ext == 'jpg')||($ext=='jpeg')||($ext=='png')||($ext=='gif')){
              list($width, $height) = getimagesize($evngImage['tmp_name']); 
              $ImageUpload = new ImageUpload;
              $ImageUpload->File = $evngImage;
              $ImageUpload->method = 1;
              $ImageUpload->SavePath = $filedir;
              $ImageUpload->NewWidth = $width;
              $ImageUpload->NewHeight = $height;
              $ImageUpload->NewName = $newName;
              $ImageUpload->OverWrite = true;
              $err = $ImageUpload->UploadFile();
              $evngImage = $newName.".".strtolower($ext);
            }
            else{
              $status = array(
                  'status' => "304",
                  'message' => "Failure Please upload jpg,png,gift,jpeg images only"
               );
              return $status;
            }
          }
          $data['pumpupImage'] = $pumpupImage;
          $data['bfImage'] = $bfImage;
          $data['lunchImage'] = $lunchImage;
          $data['evngImage'] = $evngImage;
          $data['expeditionId'] = $expeditionId;
          $foodMenu = $this->repository->addExpeditionFoodMenu($data);
          $status = array(
                    'status' => "200",
                    'message' => "Expeditions Details Added Successfully",
                    'expedition_id' => $expeditionId
                    );
        } else {
          $status = array(
                    'status' => "304",
                    'message' => "Expeditions Details Not Added Successfully");
        }
      }
      else{
        $status = array(
          'status' => "208",
          'message' => "Failure Expedition name exist"
       );
      } 
    }
    return $status;
  }
  public function updateExpedition($data) {
    extract($data);
    if(empty($expedition_title))
    {
      $status = array(
                'status' => "208",
                'message' => "Failure expeditionname is required"
                );
    }else{
      $expeditionExist = $this->repository->checkExpedition($expedition_title,$expedition_id);
      if ($expeditionExist == '0')
      {
        
        $res = $this->repository->updateExpedition($data);    
        if($res == 'true'){
          
          $data['expeditionId'] = $expeditionId;
           
          $status = array(
            'status' => "200",
            'message' => "Successfully Updated");
        } else{
          $status = array(
          'status' => "304",
          'message' => "Expeditions Details Not Updated Successfully");
          
        }
      }else{
        $status = array(
                  'status' => "208",
                  'message' => "Failure Expedition name exist"
              );
      }
    }    
    return $status;
  }
  public function getExpedition($data) {
    $Expedition = $this->repository->getExpedition($data);
    return $Expedition;
  }
  public function UpdateIterinary($data) {
    
      $this->repository->updateExpeditionIterinaryDetails($data);
    
    return $Expedition;
  }

  public function getItineraryExpedition($data) {
    $Expedition = $this->repository->getItineraryExpedition($data);
    return $Expedition;
  }
  public function deleteExpedition($data) {
    $Expedition = $this->repository->deleteExpedition($data);
    return $Expedition;
  }
  
  public function DeleteIterinary($data) {
    $Expedition = $this->repository->DeleteIterinary($data);
    return $Expedition;
  }
  

}