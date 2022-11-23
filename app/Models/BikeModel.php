<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class BikeModel extends Model{
    protected $table = 'sg_biketrips';
    protected $primaryKey = 'biketrips_id ';
    
    /*protected $allowedFields = [
        'user_mobile',
        'user_email',
        'user_password',
        'temp_password',
        'user_fname',
        'user_lname',
        'user_gender',
        'user_dob',
        'user_level',
        'user_avatar',
        'user_create',
        'lastlogin',
        'user_status',
        'modified_date',
        'created_by',
        'modified_by'
    ];*/

    public function getTrips(){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/biketrips/getbiketrips';//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function getTrip($trip_id =""){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/biketrips/getbiketrip/'.$trip_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function get_itinerary_Trip($trip_id =""){
       
        $home = new home();
        $data = array();
        $url = baseURL1.'/biketrips/get_itinerary_Trip/'.$trip_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function edittripdata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/biketrips/updatebiketrip';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addtrip($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/biketrips/addtrip';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function edittripiterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/biketrips/editbiketripiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addtripiterinarydata($data){           
        $home = new home();   
       // print_r(json_encode($data));//exit;     
        $url = baseURL1.'/biketrips/addbiketripiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function getfaq($trip_id){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/biketrips/getfaq/'.$trip_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    
}