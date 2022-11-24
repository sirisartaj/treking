<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class HostelModel extends Model{
    protected $table = 'sg_hosteldetails';
    protected $primaryKey = 'hostel_id ';
    
    

    public function getHostels(){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/hostels/gethostels';//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function getHostel($hostel_id =""){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/hostels/gethostel/'.$hostel_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function get_itinerary_Hostel($hostel_id =""){
       
        $home = new home();
        $data = array();
        $url = baseURL1.'/hostels/get_itinerary_Hostel/'.$hostel_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function edithosteldata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/hostels/updatehostel';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addhostel($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/hostels/addhostel';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function edithosteliterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/hostels/edithosteliterinarydata';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addhosteliterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/hostels/addhosteliterinarydata';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function getfaq($hostel_id){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/hostels/getfaq/'.$hostel_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    
}