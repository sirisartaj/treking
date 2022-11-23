<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\TrekModel;
  
class TrekController extends Controller
{
    public function index()
    {        
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getTreks();
        //print_r($data['result']);exit;

        echo view('treking/trekslist',$data);
    }

    public function trekslist()
    {
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getTreks();
        //print_r($data['result']);exit;

        echo view('treking/trekslist',$data);
    }
   /* public function trekitinerary1()
    {
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getTreks();
        //print_r($data['result']);exit;

        echo view('treking/trekitinerary',$data);
    }*/

    
    public function storetrek()
    {
      
        helper(['form']);
       $rules = [
            'trek_fee'      => 'required',
            'trek_days'      => 'required',
            'trek_title'      => 'required|is_unique[sg_trekingdetails.trek_title]'
        ];
        
        if($this->validate($rules)){ 
            $TrekModel = new TrekModel();
            $trek_overview = str_replace('"','\'', $this->request->getVar('trek_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'trek_title'     => $this->request->getVar('trek_title'),
                'trek_fee'    => $this->request->getVar('trek_fee'),                
                'trek_days' =>$this->request->getVar('trek_days'),
                'trek_overview'=> htmlspecialchars($trek_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'created_date' =>date('Y-m-d H:i:s'),
                'created_by' =>1,
                'status' =>0
            ];

            $a = $TrekModel->addtrek($data);
            //print_r($a);exit;
            if($a->status ==200){
                $_SESSION['message'] = $a->message;
                return redirect()->to('addTrek');
            }else{

                $data['validation'] = $this->validator;
                echo view('treking\addtrek', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('treking\addtrek', $data);
        }
    }

    public function addTrek(){
        helper(['form']);
        $rules = [ ];
        
        if($this->validate($rules)){ 

         }else{
            $data['validation'] = $this->validator;
        
            echo view('treking\addtrek',$data);
        }
    }

    public function edittrek()
    {
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [
            'trek_id'      => 'required'
        ];
          
        if($this->validate($rules)){ 
            

            $trek_overview = str_replace('"','\'', $this->request->getVar('trek_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'trek_id'    => $this->request->getVar('trek_id'),
                'trek_title'    => $this->request->getVar('trek_title'),
                'trek_overview'=> htmlspecialchars($trek_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $TrekModel->edittrekdata($data);
           
            return redirect()->to('/trekslist');
        }else{
            $rules = [];
            $trek = (array) $TrekModel->getTrek($trek_id);           
            if($trek['status'] =200){
                 $data['result']  = $trek['trek_details']->treks;
            }
            if($this->validate($rules)){}else{
                $data['Headding']="Edit Trek";
            $data['validation'] = $this->validator;
            echo view('treking/trekedit', $data);
            }
        }
    
    }

    public function deletetrekitinerary($id)
    {
        $TrekModel = new TrekModel();
       
            $data = [
                'iterinary_id'    => $id,
                'status' => 9,
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1
            ];
           
           $a = $TrekModel->deleteitinerarytrek($data);
           
            //return redirect()->to('/trekslist');
        
    
    }

    function gettrek($trek_id=''){
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [ ];
        $trek = (array) $TrekModel->getTrek($trek_id);
        if($trek['status'] =200){
             $data['result']  = $trek['trek_details']->treks;
        }
        
        $data['Headding']="Edit Trek";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('treking/trekedit',$data);
    }
    function gettrekitinerary($trek_id=''){
            $TrekModel = new TrekModel();
            $data['trek_id'] =$trek_id;
            helper(['form']);
            $rules = [ ];
            $trek = (array) $TrekModel->get_itinerary_Trek($trek_id);
            //print_r($trek);exit;
            if($trek['status'] =200){
                 $data['result']  = json_decode(json_encode($trek['trek_details']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary Trek";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('treking/trek_itinerary',$data);
    }


    function fileupload(){
      
        $file = $this->request->getFile('file');
        $foldername = $this->request->getvar('foldername');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.'Trek/'.$foldername.'/', $filename);
          
            echo SITEURL.$foldername.'/Trek/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function trekiterinarystore()
    {
        $entered = $this->request->getVar();
       
        helper(['form']);
       $c = count($this->request->getVar('iterinary_id'));
        if(1){ 
            $TrekModel = new TrekModel();
            for($i=0;$i<$c;$i++){
            if($entered['iterinary_id'][$i]){
                $udata = [
                    'iterinary_id'=>$entered['iterinary_id'][$i],
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                    'trek_id'=>$this->request->getVar('trek_id'),
                    'modified_date'=>date('Y-m-d H:i:s'),
                    'modified_by'=>"1"
                ];
                $a[] = $TrekModel->edittrekiterinarydata($udata);
            }else{                
                $idata = [                    
                    'trek_id'=>$this->request->getVar('trek_id'),
                    'created_date'=>date('Y-m-d H:i:s'),
                    'created_by'=>"1",
                    'status'=>"0",
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                ];
                $a[] = $TrekModel->addtrekiterinarydata($idata);                
            }           
            //print_r($udata);exit;
        }


            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/trekslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('treking\addtrek', $data);
        }
    }
   
}