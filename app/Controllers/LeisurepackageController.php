<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\LeisurepackagesModel;
  
class LeisurepackageController extends Controller
{
    public function index()
    {        
        $LeisurepackagesModel = new LeisurepackagesModel();
        $data['result'] = (array) $LeisurepackagesModel->getLeisures();
        //print_r($data['result']);exit;

        echo view('leisurepackages/leisureslist',$data);
    }

    public function leisureslist()
    {
        $LeisurepackagesModel = new LeisurepackagesModel();
        $data['result'] = (array) $LeisurepackagesModel->getLeisures();
        //print_r($data['result']);exit;

        echo view('leisurepackages/leisureslist',$data);
    }
   
    public function storeleisure()
    {
     // print_r($this->request->getVar());exit;
        helper(['form']);
       $rules = [            
            'pkg_days'      => 'required',
            
        ];
        
        if($this->validate($rules)){ 
            $LeisurepackagesModel = new LeisurepackagesModel();
            $pkg_overview = str_replace('"','\'', $this->request->getVar('pkg_overview'));
            $inclusion_exclusion = str_replace('"','\'', $this->request->getVar('inclusion_exclusion'));
            $terms_conditions = str_replace('"','\'', $this->request->getVar('terms_conditions'));
            $where_report = str_replace('"','\'', $this->request->getVar('where_report'));
            $data = [
                'pkg_name'     => $this->request->getVar('pkg_name'),
                'pkg_days' =>$this->request->getVar('pkg_days'),
                'pkg_overview'=> htmlspecialchars($pkg_overview, ENT_QUOTES),
                'inclusion_exclusion' => htmlspecialchars($inclusion_exclusion, ENT_QUOTES),
                'terms_conditions' => htmlspecialchars($terms_conditions, ENT_QUOTES),
                'where_report' => htmlspecialchars($where_report, ENT_QUOTES),
                'created_date' =>date('Y-m-d H:i:s'),
                'created_by' =>1,
                'status' =>0
            ];

            $a = $LeisurepackagesModel->addleisure($data);
            //print_r($a);exit;
            if($a->status ==200){
                $_SESSION['message'] = $a->message;
                return redirect()->to('leisure');
            }else{

                $data['validation'] = $this->validator;
                echo view('leisurepackages\addleisure', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('leisurepackages\addleisure', $data);
        }
    }

    public function addleisure(){
        helper(['form']);
        $rules = [ ];
        
        if($this->validate($rules)){ 

         }else{
            $data['validation'] = $this->validator;
        
            echo view('leisurepackages\addleisure',$data);
        }
    }

    public function editleisure()
    {
        $LeisurepackagesModel = new LeisurepackagesModel();
        helper(['form']);
        $rules = [
            'leisure_id'      => 'required'
        ];
         // print_r($this->request->getVar());exit;
        if($this->validate($rules)){             

            $pkg_overview = str_replace('"','\'', $this->request->getVar('pkg_overview'));
            $inclusion_exclusion = str_replace('"','\'', $this->request->getVar('inclusion_exclusion'));
            $terms_conditions = str_replace('"','\'', $this->request->getVar('terms_conditions'));
            $where_report = str_replace('"','\'', $this->request->getVar('where_report'));
            $data = [
                'leisure_id'    => $this->request->getVar('leisure_id'),
                'pkg_name'    => $this->request->getVar('pkg_name'),
                'pkg_overview'=> htmlspecialchars($pkg_overview, ENT_QUOTES),
                'inclusion_exclusion' => htmlspecialchars($inclusion_exclusion, ENT_QUOTES),
                'terms_conditions' => htmlspecialchars($terms_conditions, ENT_QUOTES),
                'where_report' => htmlspecialchars($where_report, ENT_QUOTES),
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $LeisurepackagesModel->editleisuredata($data);
           
            return redirect()->to('/leisureslist');
        }else{
            $rules = [];
            $leisure = (array) $LeisurepackagesModel->getleisure($leisure_id);           
            if($leisure['status'] =200){
                 $data['result']  = $leisure['leisure_details']->leisures;
            }
            if($this->validate($rules)){}else{
                $data['Headding']="Edit leisure";
            $data['validation'] = $this->validator;
            echo view('leisurepackages/leisureedit', $data);
            }
        }
    
    } 

    public function deleteLeisure($lid)
    {
        $LeisurepackagesModel = new LeisurepackagesModel();
            
        $data = [
            'leisure_id'  => $lid,                
            'status'    => "9",                
            'modified_date' =>date('Y-m-d H:i:s'),
            'modified_by' =>1,

        ];
       
       $a = $LeisurepackagesModel->editleisurestatus($data);
       
        return redirect()->to('/leisureslist');
       
    }
    public function deleteitineraryLeisure($lid)
    {
        $LeisurepackagesModel = new LeisurepackagesModel();
            
        $data = [
            'lpitinerary_id'  => $lid,                
            'status'    => "9",                
            'modified_date' =>date('Y-m-d H:i:s'),
            'modified_by' =>1,

        ];
       
       $a = $LeisurepackagesModel->deleteitineraryLeisure($data);
       
        return redirect()->to('/leisureslist');
       
    }

    function getleisure($leisure_id=''){
        $LeisurepackagesModel = new LeisurepackagesModel();
        helper(['form']);
        $rules = [ ];
        $leisure = (array) $LeisurepackagesModel->getleisure($leisure_id);
        //print_r($leisure);
        if($leisure['status'] =200){
             $data['result']  = $leisure['leisure']->Packages;
        }
        
        $data['Headding']="Edit leisure";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('leisurepackages/leisureedit',$data);
    }
    function getleisureitinerary($leisure_id=''){
            $LeisurepackagesModel = new LeisurepackagesModel();
            $data['leisure_id'] =$leisure_id;
            helper(['form']);
            $rules = [ ];
            $leisure = (array) $LeisurepackagesModel->get_itinerary_leisure($leisure_id);
            //print_r($leisure);exit;
            if($leisure['status'] =200){
                 $data['result']  = json_decode(json_encode($leisure['leisure']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary leisure";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('leisurepackages/leisure_itinerary',$data);
    }

    function fileupload(){
      
        $file = $this->request->getFile('file');
        $foldername = $this->request->getvar('foldername');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.'Leisurepackages/'.$foldername.'/', $filename);
          
            echo SITEURL.'Leisurepackages/'.$foldername.'/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function leisureiterinarystore()
    {
        $entered = $this->request->getVar();
        //echo count($entered);//exit;
        //print_r(count($this->request->getVar('lpitinerary_id')));exit;
        $c = count($this->request->getVar('lpitinerary_id'));
        //print_r($udata);lpitinerary_id
        //exit;
        helper(['form']);
       
        if(1){ 
            $LeisurepackagesModel = new LeisurepackagesModel();
            for($i=0;$i<$c;$i++){
                echo $entered['lpitinerary_id'][$i];
            if($entered['lpitinerary_id'][$i]){
                $udata = [
                    'lpitinerary_id'=>$entered['lpitinerary_id'][$i],
                    'title'=>$this->request->getVar('title')[$i],
                    'description' =>$this->request->getVar('description')[$i],
                    'leisure_id'=>$this->request->getVar('leisure_id'),
                    'ndate'=>date('Y-m-d H:i:s'),
                    'user'=>"1",
                    'status'=>"0"
                ];
                $a[] = $LeisurepackagesModel->editleisureiterinarydata($udata);
            }else{                
                $idata = [                    
                    
                    'title'=>$this->request->getVar('title')[$i],
                    'description' =>$this->request->getVar('description')[$i],
                    'leisure_id'=>$this->request->getVar('leisure_id'),
                    'ndate'=>date('Y-m-d H:i:s'),
                    'user'=>"1",
                    'status'=>"0"
                ];
                //echo "here";
                $a[] = $LeisurepackagesModel->addleisureiterinarydata($idata);                
            }           
            //print_r($udata);exit;
        }


            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/leisureslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('leisurepackages/addleisure', $data);
        }
    }
   
}