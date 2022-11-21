<?php 
namespace App\Models;  
use CodeIgniter\Model;
  
class Feedback_form_questionsModel extends Model{
    protected $table = 'feedback_form_questions';
    
    protected $allowedFields = [
        'question',
        'option1',
        'option2',
        'option3',
        'created_at',
        'created_by'
    ];


    public function fetchallquestions()
    {     
        return $this->orderBy('fid','DESC')->findAll();
    } 

}