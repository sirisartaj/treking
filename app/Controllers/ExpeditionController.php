<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\ExpeditionsModel;
  
class ExpeditionController extends Controller
{
    public function index()
    {        
        $ExpeditionsModel = new ExpeditionsModel();
        $data['result'] = (array) $ExpeditionsModel->getExpeditions();
        //print_r($data['result']);exit;

        echo view('Expeditions/expeditionslist',$data);
    }

    public function expeditionslist()
    {
        $ExpeditionsModel = new ExpeditionsModel();
        $data['result'] = (array) $ExpeditionsModel->getExpeditions();
        //print_r($data['result']);exit;

        echo view('Expeditions/expeditionslist',$data);
    }
       
    public function storeExpedition()
    {
      
        helper(['form']);
       $rules = [
            'Expedition_fee'      => 'required',
            'Expedition_days'      => 'required',
            'Expedition_title'      => 'required|is_unique[sg_Expeditionsdetails.Expedition_title]'
        ];
        
        if($this->validate($rules)){ 
            $ExpeditionsModel = new ExpeditionsModel();
            $Expedition_overview = str_replace('"','\'', $this->request->getVar('Expedition_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'Expedition_title'     => $this->request->getVar('Expedition_title'),
                'Expedition_fee'    => $this->request->getVar('Expedition_fee'),                
                'Expedition_days' =>$this->request->getVar('Expedition_days'),
                'Expedition_overview'=> htmlspecialchars($Expedition_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'created_date' =>date('Y-m-d H:i:s'),
                'created_by' =>1,
                'status' =>0
            ];

            $a = $ExpeditionsModel->addExpedition($data);
            //print_r($a);exit;
            if($a->status ==200){
                $_SESSION['message'] = $a->message;
                return redirect()->to('addExpedition');
            }else{

                $data['validation'] = $this->validator;
                echo view('Expeditions\addExpedition', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('Expeditions\addExpedition', $data);
        }
    }

    public function addExpedition(){
        helper(['form']);
        $rules = [ ];
        
        if($this->validate($rules)){ 

         }else{
            $data['validation'] = $this->validator;
        
            echo view('Expeditions\addExpedition',$data);
        }
    }

    public function editExpedition()
    {

        $ExpeditionsModel = new ExpeditionsModel();
        helper(['form']);
        $rules = [
            'expedition_id'      => 'required'
        ];
          
        if($this->validate($rules)){ 
            

            $Expedition_overview = str_replace('"','\'', $this->request->getVar('expedition_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'expedition_id'    => $this->request->getVar('expedition_id'),
                'expedition_title'    => $this->request->getVar('expedition_title'),
                'expedition_overview'=> htmlspecialchars($Expedition_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $ExpeditionsModel->editExpeditiondata($data);
           
            return redirect()->to('/expeditionslist');
        }else{
            $rules = [];
            $Expedition = (array) $ExpeditionsModel->getExpedition($expedition_id);           
            if($Expedition['status'] =200){
                 $data['result']  = $Expedition['Expedition_details']->Expeditions;
            }
            if($this->validate($rules)){}else{
                $data['Headding']="Edit Expedition";
            $data['validation'] = $this->validator;
            echo view('Expeditions/Expeditionedit', $data);
            }
        }
    
    }

    function getExpedition($expedition_id=''){
        $ExpeditionsModel = new ExpeditionsModel();
        helper(['form']);
        $rules = [ ];
        $Expedition = (array) $ExpeditionsModel->getExpedition($expedition_id);

        if($Expedition['status'] =200){
             $data['result']  = $Expedition['expedition_details']->expeditions;
        }
        //print_r($data['result']);exit;
        $data['Headding']="Edit Expedition";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('Expeditions/Expeditionedit',$data);
    }
    function getExpeditionitinerary($expedition_id=''){
            $ExpeditionsModel = new ExpeditionsModel();
            $data['expedition_id'] =$expedition_id;
            helper(['form']);
            $rules = [ ];
            $Expedition = (array) $ExpeditionsModel->get_itinerary_Expedition($expedition_id);
            //print_r($Expedition);exit;
            if($Expedition['status'] =200){
                 $data['result']  = json_decode(json_encode($Expedition['allexpeditions']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary Expedition";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('Expeditions/Expedition_itinerary',$data);
    }


    function fileupload(){
      
        $file = $this->request->getFile('file');
        $foldername = $this->request->getvar('foldername');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.'Expedition/'.$foldername.'/', $filename);
          
            echo SITEURL.$foldername.'/Expedition/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function Expeditioniterinarystore()
    {
        $entered = $this->request->getVar();
       $c = count($this->request->getVar('iterinary_id'));
      // print_r($c);exit;
     //  print_r($this->request->getVar());exit;
        helper(['form']);
       
        if(1){ 
            $ExpeditionsModel = new ExpeditionsModel();
            for($i=0;$i<$c;$i++){
            //if($entered['iterinary_id'][$i]){
            if(1){
                $udata = [
                    'iterinary_id'=>$this->request->getVar('iterinary_id')[$i],
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                    'expedition_id'=>$this->request->getVar('expedition_id'),
                    'modified_date'=>date('Y-m-d H:i:s'),
                    'modified_by'=>"1"
                ];
                //print_r($udata);//exit;
                $a[] = $ExpeditionsModel->editExpeditioniterinarydata($udata);
            }else{                
                $idata = [                    
                    'expedition_id'=>$this->request->getVar('expedition_id'),
                    'created_date'=>date('Y-m-d H:i:s'),
                    'created_by'=>"1",
                    'status'=>"0",
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                ];
                $a[] = $ExpeditionsModel->addExpeditioniterinarydata($idata);                
            }           
            //print_r($udata);exit;
        }


            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/expeditionslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('Expeditions\addExpedition', $data);
        }
    }

    public function deleteexpedition($lid)
    {
        $ExpeditionsModel = new ExpeditionsModel();
            
        $data = [
            'expedition_id'  => $lid,                
            'status'    => "9",                
            'modified_date' =>date('Y-m-d H:i:s'),
            'modified_by' =>1,

        ];
       
       $a = $ExpeditionsModel->editExpeditionstatus($data);
       
        return redirect()->to('/expeditionslist');
       
    }
    public function deleteitineraryExpedition($lid)
    {
        $ExpeditionsModel = new ExpeditionsModel();
            
        $data = [
            'iterinary_id'  => $lid,                
            'status'    => "9",                
            'modified_date' =>date('Y-m-d H:i:s'),
            'modified_by' =>1,

        ];
       
       $a = $ExpeditionsModel->deleteitineraryExpedition($data);
       
        
       
    }
   
}