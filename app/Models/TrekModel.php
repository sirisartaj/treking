<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class TrekModel extends Model{
    protected $table = 'sg_trekingdetails';
    protected $primaryKey = 'trek_id ';
    
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

    public function getTreks(){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/treks/gettreks';//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function getTrek($trek_id =""){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/treks/gettrek/'.$trek_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function edittrekdata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/treks/updatetrek';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function getfaq($trek_id){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/treks/getfaq/'.$trek_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    
}