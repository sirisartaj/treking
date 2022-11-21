<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{
    public function index()
    {
        helper('url');
        $userModel = new UserModel();
       $result =  $userModel->home();
        
        return view('welcome_message');
    }
}
