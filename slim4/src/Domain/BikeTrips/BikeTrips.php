<?php
namespace App\Domain\BikeTrips;

use App\Domain\BikeTrips\BikeTripsRepository;
use App\Exception\ValidationException;
use App\Utilities\ImageUpload;

/**
 * Service.
 */
final class BikeTrips
{
  /**
   * @var BikeTripsRepository
   */
  private $repository;
  /**
   * The constructor.
   *
   * @param BikeTripsRepository $repository The repository
   */
  public function __construct(BikeTripsRepository $repository)
  {
    $this->repository = $repository;
  }
  public function getBikeTrips(): array
  {        
    $BikeTrips = $this->repository->getBikeTrips();
    return $BikeTrips;
  }
  public function addBikeTrip($data) {
    extract($data);
    if(empty($trip_title)){
       $status = array(
      'status' => "400",
      'message' => "Failure tripname is required"
      );
    }else{
      $tripExist = $this->repository->checkTripName($trip_title);
      if($tripExist == '0')
      {
        
        $trip_id = $this->repository->insertTrip($data);
        
          if($trip_id){         
            $status = array(
                        'status' => "200",
                        'message' => "BikeTrips Details Added Successfully",
                        'trip_id' => $trip_id
                        );
            } else {
              $status = array(
                        'status' => "304",
                        'message' => "BikeTrips Details Not Added Successfully");
            }
      
      }
      else{
        $status = array(
          'status' => "208",
          'message' => "Failure Trip name exist"
       );
      } 
    }
    return $status;
  }
  public function updateTrip($data) {
    //print_r($data);exit;
	extract($data);
    if(empty($trip_title))
    {
       $status = array(
      'status' => "400",
      'message' => "Failure tripname is required"
      );
    }
    else{
      $tripExist = $this->repository->checkTrip($trip_title,$biketrips_id);
	  //print_r($tripExist);exit;
      if ($tripExist == '0')
      {
        $data['modifiedDate'] = date("Y-m-d H:i:s");        
        
        $res = $this->repository->updateTrip($data);    
        if($res == 'true'){
          $status = array(
            'status' => "200",
            'message' => "Successfully Updated");
        } else{
          $status = array(
          'status' => "304",
          'message' => "BikeTrips Details Not Updated Successfully");
          
        }
      }else{
        $status = array(
                  'status' => "208",
                  'message' => "Failure Trip name exist"
              );
      }
    }    
    return $status;
  }
  public function getBikeTrip($data) {
    $trip = $this->repository->getBikeTrip($data);
    return $trip;
  }
  public function deleteBikeTrip($data) {
    $trip = $this->repository->deleteBikeTrip($data);
    return $trip;
  }

  public function addBikeTripIterinary($data) {
	  //print_r($data);exit;
    extract($data);
      
        
        $trip_id = $this->repository->addTripIterinaryDetails($data);
        
          if($trip_id){         
            $status = array(
                        'status' => "200",
                        'message' => "BikeTrips Iternary Details Added Successfully",
                        'trip_id' => $trip_id
                        );
            } else {
              $status = array(
                        'status' => "304",
                        'message' => "Details Not Added Successfully");
            }
      
      
    
    return $status;
  }
  public function editBikeTripIterinary($data) {
    extract($data);
    if(empty($iterinary_title))
    {
       $status = array(
      'status' => "400",
      'message' => "Failure title is required"
      );
    }
    else{
     // $tripExist = $this->repository->checkTrip($iterinary_title,$biketrips_id);
     // if ($tripExist == '0')
      if (1)
      {
        $data['modifiedDate'] = date("Y-m-d H:i:s");        
        
        $res = $this->repository->updateTripIterinaryDetails($data);    
        if($res == 'true'){
          $status = array(
            'status' => "200",
            'message' => "Successfully Updated");
        } else{
          $status = array(
          'status' => "304",
          'message' => "BikeTrips Details Not Updated Successfully");
          
        }
      }else{
        $status = array(
                  'status' => "208",
                  'message' => "Failure Trip name exist"
              );
      }
    }    
    return $status;
  }
  public function deleteIterinary($data) {
    $bookings = $this->repository->deleteIterinary($data);
    return $bookings; 
  }
  public function getItineraryBikeTrip($data) { 
  //print_r($data);exit;
    $trip = $this->repository->getItineraryBikeTrip($data);
    return $trip;
  }

  public function addTripIterinary($data) {
    extract($data);
    if(empty($iterinary_title))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure iterinary title is required"
      );
    }else{
            
        $tripId = $this->repository->addTripIterinaryDetails($data);
         if($tripId){
           $status = array(
              'status' => "200",
              'message' => "Inserted Successfully"
           );
         }
      
    }
    return $status;
  }

  public function editTripIterinary($data) {
    
    extract($data);
    if(empty($iterinary_title))
    {
      $status = array(
      'status' => "208",
      'message' => "Failure iterinary title is required"
      );
    }else{
            
        $tripId = $this->repository->updateTripIterinaryDetails($data);
         if($tripId){
           $status = array(
              'status' => "200",
              'message' => "Inserted Successfully"
           );
         }
      
    }
    return $status;
  }
  
}