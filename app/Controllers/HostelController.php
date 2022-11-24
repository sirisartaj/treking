<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\HostelModel;
  
class HostelController extends Controller
{
    public function index()
    {        
        $HostelModel = new HostelModel();
        $data['result'] = (array) $HostelModel->getHostels();
        //print_r($data['result']);exit;

        echo view('hostel/hostelslist',$data);
    }

    public function hostelslist()
    {
        $HostelModel = new HostelModel();
        $data['result'] = (array) $HostelModel->getHostels();
        //print_r($data['result']);exit;

        echo view('hostel/hostelslist',$data);
    }
   /* public function hostelitinerary1()
    {
        $HostelModel = new HostelModel();
        $data['result'] = (array) $HostelModel->getHostels();
        //print_r($data['result']);exit;

        echo view('hostel/hostelitinerary',$data);
    }*/

    
    public function storehostel()
    {
      
        helper(['form']);
       $rules = [
            'hostel_fee'      => 'required',
            'hostel_days'      => 'required',
            'hostel_title'      => 'required|is_unique[sg_hosteldetails.hostel_title]'
        ];
        
        if($this->validate($rules)){ 
            $HostelModel = new HostelModel();
            $hostel_overview = str_replace('"','\'', $this->request->getVar('hostel_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'hostel_title'     => $this->request->getVar('hostel_title'),
                'hostel_fee'    => $this->request->getVar('hostel_fee'),                
                'hostel_days' =>$this->request->getVar('hostel_days'),
                'hostel_overview'=> htmlspecialchars($hostel_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'created_date' =>date('Y-m-d H:i:s'),
                'created_by' =>1,
                'status' =>0
            ];

            $a = $HostelModel->addhostel($data);
            //print_r($a);exit;
            if($a->status ==200){
                $_SESSION['message'] = $a->message;
                return redirect()->to('addHostel');
            }else{

                $data['validation'] = $this->validator;
                echo view('hostel\addhostel', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('hostel\addhostel', $data);
        }
    }

    public function addHostel(){
        helper(['form']);
        $rules = [ ];
        
        if($this->validate($rules)){ 

         }else{
            $data['validation'] = $this->validator;
        
            echo view('hostel\addhostel',$data);
        }
    }

    public function edithostel()
    {
        $HostelModel = new HostelModel();
        helper(['form']);
        $rules = [
            'hostel_id'      => 'required'
        ];
          
        if($this->validate($rules)){ 
            

            $hostel_overview = str_replace('"','\'', $this->request->getVar('hostel_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'hostel_id'    => $this->request->getVar('hostel_id'),
                'hostel_title'    => $this->request->getVar('hostel_title'),
                'hostel_overview'=> htmlspecialchars($hostel_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $HostelModel->edithosteldata($data);
           
            return redirect()->to('/hostelslist');
        }else{
            $rules = [];
            $hostel = (array) $HostelModel->getHostel($hostel_id);           
            if($hostel['status'] =200){
                 $data['result']  = $hostel['hostel_details']->hostels;
            }
            if($this->validate($rules)){}else{
                $data['Headding']="Edit Hostel";
            $data['validation'] = $this->validator;
            echo view('hostel/hosteledit', $data);
            }
        }
    
    }

    function gethostel($hostel_id=''){
        $HostelModel = new HostelModel();
        helper(['form']);
        $rules = [ ];
        $hostel = (array) $HostelModel->getHostel($hostel_id);
        if($hostel['status'] =200){
             $data['result']  = $hostel['hostel_details']->hostels;
        }
        
        $data['Headding']="Edit Hostel";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('hostel/hosteledit',$data);
    }
    function gethostelitinerary($hostel_id=''){
            $HostelModel = new HostelModel();
            $data['hostel_id'] =$hostel_id;
            helper(['form']);
            $rules = [ ];
            $hostel = (array) $HostelModel->get_itinerary_Hostel($hostel_id);
            //print_r($hostel);exit;
            if($hostel['status'] =200){
                 $data['result']  = json_decode(json_encode($hostel['hostel_details']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary Hostel";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('hostel/hostel_itinerary',$data);
    }


    function fileupload(){
      
        $file = $this->request->getFile('file');
        $foldername = $this->request->getvar('foldername');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.'Hostel/'.$foldername.'/', $filename);
          
            echo SITEURL.$foldername.'/Hostel/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function hosteliterinarystore()
    {
        $entered = $this->request->getVar();
       
        helper(['form']);
       
        if(1){ 
            $HostelModel = new HostelModel();
            for($i=0;$i<count($entered);$i++){
            if($entered['iterinary_id'][$i]){
                $udata = [
                    'iterinary_id'=>$entered['iterinary_id'][$i],
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                    'hostel_id'=>$this->request->getVar('hostel_id'),
                    'modified_date'=>date('Y-m-d H:i:s'),
                    'modified_by'=>"1"
                ];
                $a[] = $HostelModel->edithosteliterinarydata($udata);
            }else{                
                $idata = [                    
                    'hostel_id'=>$this->request->getVar('hostel_id'),
                    'created_date'=>date('Y-m-d H:i:s'),
                    'created_by'=>"1",
                    'status'=>"0",
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                ];
                $a[] = $HostelModel->addhosteliterinarydata($idata);                
            }           
            //print_r($udata);exit;
        }


            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/hostelslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('hostel\addhostel', $data);
        }
    }
   
}