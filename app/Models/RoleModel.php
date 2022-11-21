<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class RoleModel extends Model{
    protected $table = 'sg_roles';
    protected $primaryKey = 'role_id';
    
    protected $allowedFields = [
        'role_name',
        'status',
        'created_date',
        'created_by',
        'modified_date',
        'modified_by'        
    ];

    
    public function addrole($data){

        $home = new home();
        $url = baseURL1.'/roles/addrole';
        return $home->CallAPI('POST',$url,$data);
       
    }
    public function changestatus($data){

        $home = new home();   
        $url = baseURL1.'/roles/updaterolestatus';
        return $home->CallAPI('POST',$url,$data);       
    } 

    public function editrole($data){

        $home = new home();       
        $url = baseURL1.'/roles/updaterole';
        return $home->CallAPI('POST',$url,$data);
       
    }

    public function updateprivilies($data){
        //print_r($data);
        $home = new home();       
       $url = baseURL1.'/roles/updateprivilies'; //exit;
        return $home->CallAPI('POST',$url,$data);
       
    } 
    public function getrole($role_id){

        $home = new home();  
        $data = array();     
        $url = baseURL1.'/roles/getrole/'.$role_id;
        return $home->CallAPI('GET',$url,$data);
       
    }

    public function getroles(){
        $home = new home();  
        $data = array();     
        $url = baseURL1.'/roles/getroles';//exit;
        return $home->CallAPI('GET',$url,$data);
    }

    public function getrolepriviliges($role_id){
        $home = new home();  
        $data = array();     
        $url = baseURL1.'/roles/getrolepriviliges/'.$role_id;//exit;
        return $home->CallAPI('GET',$url,$data);
    }

    public function getmodules(){
        $home = new home();  
        $data = array();     
        $url = baseURL1.'/roles/getmodules';//exit;
        return $home->CallAPI('GET',$url,$data);
    }
}