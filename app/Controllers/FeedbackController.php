<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\Feedback_form_questionsModel;
use App\Models\feedbackModel;
  
class FeedbackController extends Controller
{
    public function userfeedbackform($userid="")
    {
        $session = session();
        $data['session'] = $session;
        
        echo view('userfeedbackform',$data);
    }

    public function addquestionstofeedbackform($userid="")
    {
        helper(['form']);
        $session = session();
        $data['session'] = $session;
        
        echo view('addquestionfeedbackform',$data);
    }

    public function qstore(){
        helper(['form']);
        $rules = [
            'question'=> 'required|min_length[2]|max_length[550]|is_unique[feedback_form_questions.question]',
            'option1' => 'required|min_length[1]|max_length[100]',
            'option2' => 'required|min_length[1]|max_length[100]',
            'option3' => 'required|min_length[1]|max_length[100]'            
        ];

        if($this->validate($rules)){
            $Feedback_form_questionsModel = new Feedback_form_questionsModel();
            $data = [
                'question'     => $this->request->getVar('question'),
                'option1'    => $this->request->getVar('option1'),
                'option2' => $this->request->getVar('option2'),
                'option3' => $this->request->getVar('option3'),
            ];
            $Feedback_form_questionsModel->save($data);
            return redirect()->to('addqfeedback');
        }else{
            $data['validation'] = $this->validator;
            //print_r($this->validator->listErrors());exit;
            echo view('addquestionfeedbackform', $data);
        }
    } 
    public function saveuserfeedback(){
        helper(['form']);
       /* $rules = [
            'question'=> 'required|min_length[2]|max_length[550]|is_unique[feedback_form_questions.question]',
            'option1' => 'required|min_length[1]|max_length[100]',
            'option2' => 'required|min_length[1]|max_length[100]',
            'option3' => 'required|min_length[1]|max_length[100]'            
        ];

        if($this->validate($rules)){*/
            $feedbackModel = new feedbackModel();           
            foreach($this->request->getVar('fid') as $fid){
              // $fidans[$fid] = $this->request->getVar('ansoption_'.$fid)[0];
               $data = [
                    'user_id'     => $this->request->getVar('user_id'),
                    'fid'    => $fid,
                    'ansoption' => $this->request->getVar('ansoption_'.$fid)[0],
                    'status' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                ];
               
                $a = $feedbackModel->insert($data);
                //echo $feedbackModel->getLastQuery();
            }

            if($a){
                echo view('successfeedback');
            }
            
        /*}else{
            $data['validation'] = $this->validator;
            //print_r($this->validator->listErrors());exit;
            echo view('addquestionfeedbackform', $data);
        }*/
    }

    public function showquestionstofeedbackform($userid="")
    {
        helper(['form']);
        $session = session();
        $data['session'] = $session;
        $Feedback_form_questionsModel = new Feedback_form_questionsModel();
        $data['qu'] = $Feedback_form_questionsModel->fetchallquestions();
        $data['user_id'] = $user_id;
        echo view('showquestionfeedbackform',$data);
    }

    public function feedbackreport(){
        $feedbackModel = new feedbackModel();
        $data['feedbackdata'] = $feedbackModel->fetchalluserfeedback();

        echo view('feedback_report',$data);
    }
}