<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class UserModel extends Model{
    protected $table = 'sg_users';
    protected $primaryKey = 'user_id';
    
    protected $allowedFields = [
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
    ];

    public function home(){
       
        $home = new home();
        $data = array('banner_title'=>"first banner");
        $url = baseURL1.'/banners/addbanner';//exit;

       return $home->CallAPI('POST',$url,$data);
      
    }

    public function adduser($data){

         $home = new home();   
         //print_r($data);echo "in codeigniter usermodel";exit;    
        $url = baseURL1.'/users/adduser';
        return $home->CallAPI('POST',$url,$data);
       
    }
    public function changepwd($data){

         $home = new home();   
         //print_r($data);echo "in codeigniter usermodel";exit;    
        $url = baseURL1.'/users/updateuserpassword';
        return $home->CallAPI('POST',$url,$data);
       
    } 

    public function edituser($data){

        $home = new home();       
        $url = baseURL1.'/users/updateuser';
        return $home->CallAPI('POST',$url,$data);
       
    } 
    public function getuser($user_id){

        $home = new home();  
        $data = array();     
        $url = baseURL1.'/users/getuser/'.$user_id;
        return $home->CallAPI('GET',$url,$data);
       
    }

    public function signinuser($data){

         $home = new home();
       
        $url = baseURL1.'/users/checklogin';

       return $home->CallAPI('POST',$url,$data);
    }

    public function getusers(){
        $home = new home();  
        $data = array();     
        $url = baseURL1.'/users/getusers';
        return $home->CallAPI('GET',$url,$data);
    }
}