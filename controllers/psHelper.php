<?php
namespace MiOrder\PaymentSense\Controllers;
use Admin\Models\Payments_model;
use GuzzleHttp\Client;
use DB;
class psHelper {
  
     public function PaySenseCall(){
      $gateWay = Payments_model::select('data')->where('class_name', '=', 'MiOrder\PaymentSense\PaymentSense')->first();
       $client = new Client([
        'headers' => [ 
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer {$gateWay->bearer_token}", 
            ]
              ]);
       return $client;
   }

  public function getToken($totalSend){
    $gateWay = Payments_model::select('data')->where('class_name', '=', 'MiOrder\PaymentSense\PaymentSense')->first();
    $mode = $gateWay->mode;
    $captureType = $gateWay->capture_method;
    $url = $mode .  "access-tokens";
    $length = 5;    
    $orderString = substr(str_shuffle('0123456789'),1,$length);
     $orderId = 'order-'. $orderString;
    $client = new Client([
        'headers' => [ 
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer {$gateWay->bearer_token}", 
            ]
              ]);
        $response = $client->post($url,
            [
              'json' => [

            'gatewayUsername' => $gateWay->username,
            'gatewayPassword' => $gateWay->password,
            'currencyCode' => '826',
            'amount' => $totalSend,
            'transactionType' => $captureType,
            'orderId' => $orderId,
            'userAgent' => 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
            'userCountryCode' => '826',
                ]
            ]
        );
            $contents = $response->getBody()->getContents();
            $Decoded = json_decode($contents);
            $token = $Decoded->id;
    

     DB::table('payment_sense')->insert([
           'order_number' =>   null,
           'token' => $token,
           'payment_sense_id' => $orderId, 
           'action' => 'CreateToken',
           'completed' => 1,
           'completed_responce' => $contents,
                    ]);       

       $ReturnedTokenArray = [
         'token' => $token,
         'orderId' => $orderId
         ];
    
    
    return $ReturnedTokenArray;
  }
  
  
  public function checkPayment($token, $gateWay){
    sleep(2);
    
        
        $mode = $gateWay->mode;
        $captureType = $gateWay->capture_method;


        $client = new Client([
        'headers' => [ 
        'Content-Type' => 'application/json',
        'Authorization' => "Bearer {$gateWay->bearer_token}", 
      ]
  ]);
      
      $url = $mode . 'payments/' . $token;
      $response = $client->get($url);
      $contents = $response->getBody()->getContents();


      $Decoded = json_decode($contents);
      return $Decoded;
  }
  
}


?>