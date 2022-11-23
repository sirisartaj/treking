<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class LeisurepackagesModel extends Model{
    protected $table = 'sg_leisurepackages';
    protected $primaryKey = 'leisure_id ';
    
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

    public function getLeisures(){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/leisurepackages/getleisures';//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function getleisure($leisure_id =""){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/leisurepackages/editleisurepackages/'.$leisure_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function get_itinerary_leisure($leisure_id =""){
       
        $home = new home();
        $data = array();
        $url = baseURL1.'/leisurepackages/get_itinerary_leisure/'.$leisure_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function editleisuredata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/updateleisure';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }
    public function editleisurestatus($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/updateleisurepackagestatus';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }
    public function deleteitineraryLeisure($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/deleteiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addleisure($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/addleisure';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function editleisureiterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/editleisureiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addleisureiterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/leisurepackages/addleisureiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function getfaq($leisure_id){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/leisurepackages/getfaq/'.$leisure_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    
}