<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\UserModel;
  
class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        $data['session'] = $session;
        $rules = [
            'user_mobile'          => 'required|min_length[10]|max_length[15]',
            'user_email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[sg_users.user_email]',
            'user_password'      => 'required|min_length[4]|max_length[50]',
            'cpassword'  => 'matches[user_password]'
        ];
        $data['validation'] = '';
        echo "Hello : ".$session->get('name');
        echo view('profile',$data);
    }

    public function adduser()
    {

        helper(['form']);
        $rules = [ ];
        //$data['validation'] = $this->validator;
        $session = session();
        $data['session'] = $session;
        //$data['validation'] = '';
        //echo "Hello : ".$session->get('name');
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('adduser_view',$data);
    }

    public function storeuser()
    {
       // print_r($this->request->getVar());exit;
        helper(['form']);
       $rules = [
            'user_mobile'          => 'required|min_length[10]|max_length[15]',
            'user_email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[sg_users.user_email]',
            'user_password'      => 'required|min_length[4]|max_length[50]',
            'cpassword'  => 'matches[user_password]'
        ];
          
        if($this->validate($rules)){ 
            $userModel = new UserModel();
            $data = [
                'user_mobile'     => $this->request->getVar('user_mobile'),
                'user_email'    => $this->request->getVar('user_email'),
                'user_password' => password_hash($this->request->getVar('user_password'), PASSWORD_DEFAULT),
                'user_fname' =>$this->request->getVar('user_fname'),
                'user_lname' =>$this->request->getVar('user_lname'),
                'user_gender' =>$this->request->getVar('user_gender'),
                'user_dob' =>$this->request->getVar('user_dob'),
                'user_level' =>$this->request->getVar('user_level'),
                'user_create' =>date('Y-m-d H:i:s'),
                'user_status' =>0
            ];

            $a = $userModel->adduser($data);
           // print_r($a);exit;
            $_SESSION['message'] = $a->message;
            return redirect()->to('adduser');
        }else{
            $data['validation'] = $this->validator;
            echo view('adduser_view', $data);
        }
    }

    public function edituserstore()
    {
        $userModel = new UserModel();
        helper(['form']);
        //print_r($this->request->getVar());exit;
       $rules = [
            'user_mobile'          => 'required|min_length[10]|max_length[15]',
           // 'user_email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[sg_users.user_email]',
            
        ];
          
        if($this->validate($rules)){ 
            
            $data = [
                'user_id'    => $this->request->getVar('user_id'),
                'user_mobile'=> $this->request->getVar('user_mobile'),
                'user_email' => $this->request->getVar('user_email'),
                'user_fname' => $this->request->getVar('user_fname'),
                'user_lname' => $this->request->getVar('user_lname'),
                'user_gender'=> $this->request->getVar('user_gender'),
                'user_dob'   => $this->request->getVar('user_dob'),
                'user_level' => $this->request->getVar('user_level'),
                'user_status'=> "0"
            ];

           $a = $userModel->edituser($data);
           //print_r($a);exit;
            return redirect()->to('/getuser/'.$data['user_id']);
        }else{
            $rules = [];
            if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
            echo view('edituser_view', $data);
            }
        }
    
    }

    function getuser($user_id=''){
        $userModel = new UserModel();
        helper(['form']);
        $rules = [ ];
        $user = $userModel->getuser($user_id);
        if($user->status =200){
            $data['user'] = json_decode(json_encode($user->user), true);;
        }
        //print_r($data);exit;
        //echo $data['user']['user_fname'];exit;
        $data['Headding']="Edit User";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('edituser_view',$data);
    }

    function getusers(){
        $userModel = new UserModel();
        helper(['form']);
        $rules = [ ];
        $user = $userModel->getusers();
        $data = json_decode(json_encode($user),true);
        //print_r($data['users']);exit;
        $data['Headding']="User list";
        
        echo view('adminuser_view',$data);
    }

    function changepassword($user_id){
        //$userModel = new UserModel();
        helper(['form']);
        $rules = [ ];
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        $data['user_id'] = $user_id;
        echo view('changepassword',$data);
    }

    function changepwd(){
        $userModel = new UserModel();
        helper(['form']);
        $rules = [            
            'user_password'      => 'required|min_length[4]|max_length[50]',
            'cpassword'  => 'matches[user_password]'
        ];
          
        if($this->validate($rules)){ 
            $userModel = new UserModel();
            $data = [                
                'user_password' => password_hash($this->request->getVar('user_password'), PASSWORD_DEFAULT),               
                'temp_password' => $this->request->getVar('user_password'),               
            ];
           
            $a = $userModel->changepwd($data);
           // print_r($a);exit;
            $_SESSION['message'] = $a->message;
            return redirect()->to('getusers');
        }else{
            $data['validation'] = $this->validator;
            $data['user_id'] = $user_id;
            echo view('changepassword', $data);
        }
        
        
        echo view('getusers',$user_id);
    }
}