<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\TrekModel;
  
class AdminController extends Controller
{
    public function index()
    {        
        echo view('profile');
    }

    public function trekslist()
    {
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getTreks();
        //print_r($data['result']);exit;

        echo view('treking/trekslist',$data);
    }
    public function trekitinerary()
    {
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getTreks();
        //print_r($data['result']);exit;

        echo view('treking/trekitinerary',$data);
    }

    public function getfaq($trek_id)
    {
        $TrekModel = new TrekModel();
        $data['result'] = (array) $TrekModel->getfaq($trek_id);
        //print_r($data['result']);exit;

        echo view('treking/trekfaq',$data);
    }

    public function storetrek()
    {
       // print_r($this->request->getVar());exit;
        helper(['form']);
       $rules = [
            'trek_mobile'          => 'required|min_length[10]|max_length[15]',
            'trek_email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[sg_treks.trek_email]',
            'trek_password'      => 'required|min_length[4]|max_length[50]',
            'cpassword'  => 'matches[trek_password]'
        ];
          
        if($this->validate($rules)){ 
            $TrekModel = new TrekModel();
            $data = [
                'trek_mobile'     => $this->request->getVar('trek_mobile'),
                'trek_email'    => $this->request->getVar('trek_email'),
                'trek_password' => password_hash($this->request->getVar('trek_password'), PASSWORD_DEFAULT),
                'trek_fname' =>$this->request->getVar('trek_fname'),
                'trek_lname' =>$this->request->getVar('trek_lname'),
                'trek_gender' =>$this->request->getVar('trek_gender'),
                'trek_dob' =>$this->request->getVar('trek_dob'),
                'trek_level' =>$this->request->getVar('trek_level'),
                'trek_create' =>date('Y-m-d H:i:s'),
                'trek_status' =>0
            ];

            $a = $TrekModel->addtrek($data);
           // print_r($a);exit;
            $_SESSION['message'] = $a->message;
            return redirect()->to('addtrek');
        }else{
            $data['validation'] = $this->validator;
            echo view('addtrek_view', $data);
        }
    }

    public function edittrek()
    {
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [
            'trek_id'      => 'required'
        ];
        //print_r($this->request->getVar());
      //echo "nnnn";  echo($this->validate($rules));

        //echo "sdcsd";exit;
//echo strip_tags($this->request->getVar('trek_overview'));
       // exit;
       
          
        if($this->validate($rules)){ 
            
            $data = [
                'trek_id'    => $this->request->getVar('trek_id'),
                'trek_title'    => $this->request->getVar('trek_title'),
                'trek_overview'=> strip_tags($this->request->getVar('trek_overview')),
                'things_carry' => strip_tags($this->request->getVar('things_carry')),
                'terms' => strip_tags($this->request->getVar('terms')),
                'map_image' => strip_tags($this->request->getVar('map_image')) ,
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
//print_r($data);echo "jjg";exit;
           $a = $TrekModel->edittrekdata($data);
           print_r($a);exit;
            return redirect()->to('/gettreks');
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

    function gettrek($trek_id=''){
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [ ];
        $trek = (array) $TrekModel->getTrek($trek_id);
       // echo "<pre>";print_r($trek['trek_details']['treks']);exit;
        if($trek['status'] =200){
             $data['result']  = $trek['trek_details']->treks;
        }
        //print_r($data);exit;
        //echo $data['trek']['trek_fname'];exit;
        $data['Headding']="Edit Trek";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('treking/trekedit',$data);
    }

    function gettreks(){
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [ ];
        $trek = $TrekModel->gettreks();
        $data = json_decode(json_encode($trek),true);
        //print_r($data['treks']);exit;
        $data['Headding']="trek list";
        
        echo view('admintrek_view',$data);
    }

    function fileupload(){
      
        $file = $this->request->getFile('file');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.$foldername.'/', $filename);
          // $data['path'] = WRITEPATH.'uploads\treking';
          // echo $filename;
           //echo json_encode($data);
            echo SITEURL.$foldername.'/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function changepwd(){
        $TrekModel = new TrekModel();
        helper(['form']);
        $rules = [            
            'trek_password'      => 'required|min_length[4]|max_length[50]',
            'cpassword'  => 'matches[trek_password]'
        ];
          
        if($this->validate($rules)){ 
            $TrekModel = new TrekModel();
            $data = [                
                'trek_password' => password_hash($this->request->getVar('trek_password'), PASSWORD_DEFAULT),               
                'temp_password' => $this->request->getVar('trek_password'),               
            ];
           
            $a = $TrekModel->changepwd($data);
           // print_r($a);exit;
            $_SESSION['message'] = $a->message;
            return redirect()->to('gettreks');
        }else{
            $data['validation'] = $this->validator;
            $data['trek_id'] = $trek_id;
            echo view('changepassword', $data);
        }
        
        
        echo view('gettreks',$trek_id);
    }
}