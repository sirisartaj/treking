<?php 
namespace App\Models;  
use CodeIgniter\Model;
  
class feedbackModel extends Model{
    protected $table = 'feedback';
    protected $primaryKey = 'id ';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id',
        'fid',
        'ansoption',
        'status',
        'created_at'
    ];


    public function fetchalluserfeedback()
    {     
        return $this->orderBy('fid','DESC')->findAll();
    } 

}