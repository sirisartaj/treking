<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use App\Models\BikeModel;
  
class BikeController extends Controller
{
    public function index()
    {        
        $BikeModel = new BikeModel();
        $data['result'] = (array) $BikeModel->gettrips();
        //print_r($data['result']);exit;

        echo view('bike/tripslist',$data);
    }

    public function tripslist()
    {
        $BikeModel = new BikeModel();
        $data['result'] = (array) $BikeModel->gettrips();
        //print_r($data['result']);exit;

        echo view('bike/tripslist',$data);
    }
   

    public function storeBiketrip()
    {
      
        helper(['form']);
       $rules = [
            'trip_fee'      => 'required',
            'trip_days'      => 'required',
            'trip_title'      => 'required|is_unique[sg_tripingdetails.trip_title]'
        ];
        
        if($this->validate($rules)){ 
            $BikeModel = new BikeModel();
            $trip_overview = str_replace('"','\'', $this->request->getVar('trip_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'trip_title'     => $this->request->getVar('trip_title'),
                'trip_fee'    => $this->request->getVar('trip_fee'),                
                'trip_days' =>$this->request->getVar('trip_days'),
                'trip_overview'=> htmlspecialchars($trip_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms' => htmlspecialchars($terms, ENT_QUOTES),
                'map_image' => htmlspecialchars($mapimage, ENT_QUOTES),
                'created_date' =>date('Y-m-d H:i:s'),
                'created_by' =>1,
                'status' =>0
            ];

            $a = $BikeModel->addtrip($data);
            //print_r($a);exit;
            if($a->status ==200){
                $_SESSION['message'] = $a->message;
                return redirect()->to('addtrip');
            }else{

                $data['validation'] = $this->validator;
                echo view('bike\addtrip', $data);
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('bike\addtrip', $data);
        }
    }

    public function addBikeTrip(){
        helper(['form']);
        $rules = [ ];
        
        if($this->validate($rules)){ 

         }else{
            $data['validation'] = $this->validator;
        
            echo view('bike\addtrip',$data);
        }
    }

    public function editBikeTrip()
    {
        $BikeModel = new BikeModel();
        helper(['form']);
        $rules = [
            'trip_id'      => 'required'
        ];
          
        if($this->validate($rules)){ 
        
            $trip_overview = str_replace('"','\'', $this->request->getVar('trip_overview'));
            $things_carry = str_replace('"','\'', $this->request->getVar('things_carry'));
            $terms = str_replace('"','\'', $this->request->getVar('terms'));
            $mapimage = str_replace('"','\'', $this->request->getVar('map_image'));
            $data = [
                'biketrips_id'    => $this->request->getVar('trip_id'),
                'trip_title'    => $this->request->getVar('trip_title'),
                'trip_overview'=> htmlspecialchars($trip_overview, ENT_QUOTES),
                'things_carry' => htmlspecialchars($things_carry, ENT_QUOTES),
                'terms_conditions' => htmlspecialchars($terms, ENT_QUOTES),
                'how_to_reach' => htmlspecialchars($mapimage, ENT_QUOTES),
                'modified_date' =>date('Y-m-d H:i:s'),
                'modified_by' =>1,

            ];
           
           $a = $BikeModel->edittripdata($data);
           
            return redirect()->to('/biketripslist');
        }else{
            $rules = [];
            $trip = (array) $BikeModel->gettrip($trip_id);           
            if($trip['status'] =200){
                 $data['result']  = $trip['trip_details']->trips;
            }
            if($this->validate($rules)){}else{
                $data['Headding']="Edit trip";
            $data['validation'] = $this->validator;
            echo view('bike/tripedit', $data);
            }
        }
    
    }

    function getBikeTrip($trip_id=''){
        $BikeModel = new BikeModel();
        helper(['form']);
        $rules = [ ];
        $trip = (array) $BikeModel->gettrip($trip_id);
        if($trip['status'] =200){
             $data['result']  = $trip['biketrip']->trips;
        }
        
        $data['Headding']="Edit trip";
        if($this->validate($rules)){}else{
            $data['validation'] = $this->validator;
        }
        echo view('bike/tripedit',$data);
    }
    function getBikeTripItinerary($trip_id=''){
            $BikeModel = new BikeModel();
            $data['trip_id'] =$trip_id;
            helper(['form']);
            $rules = [ ];
            $trip = (array) $BikeModel->get_itinerary_trip($trip_id);
            //print_r($trip);exit;
            if($trip['status'] =200){
                 $data['result']  = json_decode(json_encode($trip['biketrip']));
            }
           // echo "<pre>";
            //print_r($data['result']);
            $data['Headding']="Itinerary trip";
            if($this->validate($rules)){

            }else{
                $data['validation'] = $this->validator;
            }
            echo view('bike/trip_itinerary',$data);
    }

    function fileupload(){
      
        $file = $this->request->getFile('file');
        $foldername = $this->request->getvar('foldername');
       if ($file) {
          if (!$_FILES['file']['error']) {
            $name = md5(rand(100, 200));
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $filename = $name.'.'.$ext;

           $file->move(baseimgURL.'Bike/'.$foldername.'/', $filename);
          
            echo SITEURL.'Bike/'.$foldername.'/'.$filename; //change this URL
          } else {
            echo $message = 'Ooops!  Your upload triggered the following error:  '.$_FILES['file']['error'];
          }
        }
        
    }

    function biketripiterinarystore()
    {
        $entered = $this->request->getVar();
        //echo "<pre>".count($entered);print_r($entered);//exit;
        
        $c = count($this->request->getVar('iterinary_id'));
        //print_r($udata);
        //exit;
        helper(['form']);
       
        if(1){ 
            $BikeModel = new BikeModel();
            for($i=0;$i<$c;$i++){
            //if($entered['iterinary_id'][$i]){
            if(1){
                $udata = [
                    'iterinary_id'=>$entered['iterinary_id'][$i],
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i],
                    'biketrips_id'=>$this->request->getVar('biketrips_id'),
                    'modified_date'=>date('Y-m-d H:i:s'),
                    'modified_by'=>"1"
                ];
                $a[] = $BikeModel->edittripiterinarydata($udata);
            }else{
           // echo "here";//exit;                
                $idata = [                    
                    'biketrips_id'=>$this->request->getVar('biketrips_id'),
                    'created_date'=>date('Y-m-d H:i:s'),
                    'created_by'=>"1",
                    'status'=>"0",
                    'iterinary_title'=>$this->request->getVar('iterinary_title')[$i],
                    'iterinary_details' =>$this->request->getVar('iterinary_details')[$i]
                ];
                $a['insert'] = $BikeModel->addtripiterinarydata($idata);  
                //print_r($a['insert']);exit;              
            }           
            //print_r($udata);exit;
        }

//print_r($udata);
//print_r($idata);
            
           // print_r($a);exit;
            if($a){
                $_SESSION['message'] = $a->message;
                return redirect()->to('/biketripslist');
            }
            
        }else{
            $data['validation'] = $this->validator;
            echo view('bike\addtrip', $data);
        }
    }
   
}