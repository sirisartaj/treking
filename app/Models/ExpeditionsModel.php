<?php 
namespace App\Models;  
use CodeIgniter\Model;
use App\Controllers\Home;
  
class ExpeditionsModel extends Model{
    protected $table = 'sg_expeditions';
    protected $primaryKey = 'expedition_id ';
    
   

    public function getexpeditions(){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/expeditions/getexpeditions';//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function getexpedition($expedition_id =""){
       
        $home = new home();
        //$data = array();
        $url = baseURL1.'/expeditions/getexpedition/'.$expedition_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function get_itinerary_expedition($expedition_id =""){
       
        $home = new home();
        $data = array();
        $url = baseURL1.'/expeditions/get_itinerary_expedition/'.$expedition_id;//exit;

       return $home->CallAPI('GET',$url,$data);
      
    }

    public function editexpeditiondata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/updateexpedition';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addexpedition($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/addexpedition';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function editexpeditioniterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/editexpeditioniterinarydata';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function addexpeditioniterinarydata($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/addexpeditioniterinarydata';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    public function deleteitineraryexpedition($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/deleteiterinary';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

     public function editExpeditionstatus($data){           
        $home = new home();   
        //print_r(json_encode($data));exit;     
       $url = baseURL1.'/expeditions/updateexpeditionsstatus';//exit;
       return $home->CallAPI('POST',$url,$data);          
    }

    
}