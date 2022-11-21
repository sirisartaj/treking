<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function CallAPI($method, $url, $data = false){
       try{
       // echo $url;
        //print_r($data);
        //echo $method;//exit;
        define('RESTAPYKEY',urldecode('78e7fc94-0169-4b9a-994d-5e402cfbb01'));
      $curl = curl_init();
      switch ($method){
        case "POST":

          curl_setopt($curl, CURLOPT_POST, true);
          if ($data) {
           if(!$data['user_id']){ $data['user_id'] = "1"; }
            $data['apiKey'] = RESTAPYKEY;                    
            $data = json_encode($data);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          }                    
          break;
        case "PUT":
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
          if(!$data['user_id']){ $data['user_id'] = "1"; }
          $data['apiKey'] = RESTAPYKEY;                    
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          break;
        case "DELETE":
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
          $url =  $url ."/1/".RESTAPYKEY;
          break;
        default:
          if ($data) {
            $data = json_encode($data);
           // echo $data;
           //echo  $data = http_build_query($data,'');
           //exit;
            $url = sprintf("%s?%s", $url, $data);
          }  
          break;                  
      }        
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
     // print_r($url);//exit;
      //print_r($data);exit;
      $result = curl_exec($curl);
         
      curl_close($curl);
     // print_r($result);exit();
      $decoded = json_decode($result);
      // echo 'res--';print_r(trim($decoded));exit();
      if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('error occured: ' . $decoded->response->errormessage);
      }
      return $decoded;
    }catch(Exception $e) {
      die('error occured: ' . $e);
    }
  }
}
