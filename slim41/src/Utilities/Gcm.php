<?php
namespace App\Utilities;
class Gcm {

  public function __construct() {
    $this->API_ACCESS_KEY ='AAAA3tHWitA:APA91bF5A53Zyf7tohvLezPIVg0HfHvcblW50oblBTCX9-cgBRQ_y8jhtCaeykO6TlOo6IwdlALfUMtBzHQOvEl7TsIi8yiLQGb52h-r5pc8lexzGnnSv0u5n4pFy9kBDlPBlShaqwwB';
    $this->passphrase = 'Ridingsolo@123#';
    $this->registrationIds = array();
    $this->msg = array();
  }   

  public function sendNotification() {
    
    $fields = array('registration_ids'  => $this->registrationIds,'data'  => $this->msg,'priority'=>'high');
    $headers = array('Authorization: key=' . $this->API_ACCESS_KEY,'Content-Type: application/json');
    print_r($fields);
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch );
    print_r($result);
    curl_close( $ch );
    return $result;   
  }  

  public function sendiOSNotification() {
    $deviceToken = $this->registrationIds;
    $ctx = stream_context_create();
    // ck.pem is your certificate file
    stream_context_set_option($ctx, 'ssl', 'local_cert', '/home/jepy/public_html/ridingsoloendpoints/restful/Push_certificates/p12/aps.pem');
    stream_context_set_option($ctx, 'ssl', 'passphrase', $this->passphrase);
    // Open a connection to the APNS server
    $fp = stream_socket_client(
      'ssl://gateway.push.apple.com:2195', $err,
      $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
    if (!$fp)
      exit("Failed to connect: $err $errstr" . PHP_EOL);
    // Create the payload body
    $body['aps'] = array(
      'alert' => $this->msg,
      'sound' => 'default'
    );
    // Encode the payload as JSON
    $payload = json_encode($body);
    // Build the binary notification
    $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
    // Send it to the server
    $result = fwrite($fp, $msg, strlen($msg));
    
    // Close the connection to the server
    fclose($fp);
    if (!$result)
      return 'Message not delivered' . PHP_EOL;
    else
      return 'Message successfully delivered' . PHP_EOL;
  }



}

?>