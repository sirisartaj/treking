<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\RoleModel;
  
class RoleController extends Controller
{
    public function index()
    {
        $RoleModel = new RoleModel();
        helper(['form']);
        $rules = [ ];
        $role = $RoleModel->getroles();
        //print_r($role);//exit;
        if($role->status==200){
            $data = json_decode(json_encode($role),true);
        }else{
          $data['message'] = $role->message; 
        }
        
        //print_r($data['Roles']);exit;
        $data['Headding']="role list";
        
        echo view('roles/roles_list',$data);
    }

    public function addrole()
    {
        helper(['form']);
        $rules = [ ];
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('roles/addrole',$data);
    }

    public function storerole()
    {       
       helper(['form']);
       $rules = [
            'role_name' => 'required|min_length[2]|max_length[15]'
        ];
          
        if($this->validate($rules)){ 
            $RoleModel = new RoleModel();
            $data = [
                'role_name'=> $this->request->getVar('role_name'),
                'status'   => $this->request->getVar('status'),
                'created_by' =>"1",
                'created_date'=>date('Y-m-d H:i:s')
            ];

            $a = $RoleModel->addrole($data);
           // print_r($a);exit;
            $_SESSION['message'] = $a->message;
            return redirect()->to('getroles');
        }else{
            $data['validation'] = $this->validator;
            echo view('addrole_view', $data);
        }
    }

    public function editrolestore()
    {
        $RoleModel = new RoleModel();
        helper(['form']);
        //print_r($this->request->getVar());exit;
       $rules = [
            'role_name'          => 'required|min_length[2]|max_length[100]',
           // 'role_email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[sg_roles.role_email]',
            
        ];
          
        if($this->validate($rules)){ 
            $data = [
                'role_name'=> $this->request->getVar('role_name'),
                'status'   =>$this->request->getVar('status'),
                'modified_by' =>"1",
                'modified_date'=>date('Y-m-d H:i:s'),
                'role_id' =>$this->request->getVar('role_id'),
            ];            

           $a = $RoleModel->editrole($data);
           //print_r($a);exit;
            return redirect()->to('/getroles');
        }else{
            $rules = [];
            if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
            echo view('roles/editrole', $data);
            }
        }
    
    }

    function getrole($role_id=''){
        $RoleModel = new RoleModel();
        helper(['form']);
        $rules = [ ];
        $role = $RoleModel->getrole($role_id);
       // print_r($role);exit;
        if($role->status =200){
            $data = json_decode(json_encode($role), true);;
        }
       // print_r($data);exit;
        //echo $data['role']['role_fname'];exit;
        $data['Headding']="Edit role";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('roles/editrole',$data);
    }

     function roleprivilies($role_id=''){
        $RoleModel = new RoleModel();
        helper(['form']);
        $rules = [ ];
        
        $modules = $RoleModel->getmodules();
        //print_r($modules);exit;
        if($modules->status =200){
            $data['modules'] = json_decode(json_encode($modules), true)['Role'];
        }
        
        $data['previliges']['access_priviliges'] = array();
        $previliges = $RoleModel->getrolepriviliges($role_id);
        //print_r($previliges);exit;
        if($previliges->status =200){
            $data['previliges'] = json_decode(json_encode($previliges), true)['Role'];
        }
        //print_r($data['previliges']);exit;
        //echo $data['role']['role_fname'];exit;
        $data['role_id'] = $role_id;
        $data['Headding']="Edit role";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('roles/priviliges_list',$data);
    }

    function rolepriviliesstore(){
         $RoleModel = new RoleModel();
         $data['role_id'] = $this->request->getVar('role_id');
         $data['module_id'] = $this->request->getVar('module_id');
         $data['status'] = $this->request->getVar('status');
         $data['col_name'] = $this->request->getVar('previliges').'_priviliges';
         $modules = $RoleModel->updateprivilies($data);
        return json_encode($modules);exit;
        //return redirect()->to('/getroles');
    }

    

    
}