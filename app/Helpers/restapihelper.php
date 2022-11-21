public function CallAPI($method, $url, $data = false){
       try{
      $curl = curl_init();
      switch ($method){
        case "POST":
          curl_setopt($curl, CURLOPT_POST, true);
          if ($data) {
            $data['user_id'] = "1"; 
            $data['apiKey'] = RESTAPYKEY;                    
            $data = json_encode($data);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          }                    
          break;
        case "PUT":
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
          $data['user_id'] = "1"; 
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
            $url = sprintf("%s?%s", $url, http_build_query($data));
          }                    
      }        
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($curl);
         
      curl_close($curl);
      //print_r($result);exit();
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