<?php
namespace MiOrder\PaymentSense;

use Admin\Classes\BasePaymentGateway;
use MiOrder\PaymentSense\Controllers\psHelper;
use Admin\Models\Payments_model;
use Session;
use Cart;
use DB;
use ApplicationException;
  use EventEmitter;
    use PaymentHelpers;

class PaymentSense extends BasePaymentGateway
{
  protected $requirePrecheckoutValidation = true;

  public function CheckTimeSlotSelected(){
    $error = "noTimeSlot";
             if (!Session::get('local_info.order-timeslot')){
                return $error;
            }
  }
  
  public function GetTotal(){
    $total =  Cart::total();
    $totalSend = intval(strval($total*100));
    return $totalSend;
  }
  public function PrepareCart(){
    $total =  Cart::total();
    $totalSend = intval(strval($total*100));
    $TokenCreation = new psHelper;
    $PsArray = $TokenCreation->getToken($totalSend);
    
     return $PsArray;
  }


   public function isApplicable($total, $host)
    {
    
      return $host->order_total <= $total;
     
    }

  public function processPaymentForm($data, $host, $order)
    {
          $gateWay = Payments_model::select('data')->where('class_name', '=', 'MiOrder\PaymentSense\PaymentSense')->first();
          $token = $data['pToken'];
          $helper = new psHelper;
          $checkPayment = $helper->checkPayment($token, $gateWay);
          $captureType = $gateWay->capture_method;
          //dd($checkPayment); 
   
         if ($checkPayment->statusCode === 0 ){
        
                    DB::table('payment_sense')->insert([
                     'order_num
                     ber' =>   $order->order_id,
                     'payment_sense_id' => $data['paymentId'],
                     'token' => $data['pToken'],
                     'action' => $captureType,
                     'completed' => $captureType . 'Success',
                     'completed_responce' => 'Completed',
                    ]);
           
               $order->updateOrderStatus($host->order_status, ['notify' => FALSE]);
               $order->markAsPaymentProcessed();
         }else{
           throw new ApplicationException('The payment has failed to capture from the bank. Please contact your bank or try again.');
         }
          if (!$paymentMethod = $order->payment)
                          throw new ApplicationException('Payment method not found');
     
            if (!$this->isApplicable($order->order_total, $host))
            throw new ApplicationException(sprintf(
                lang('igniter.payregister::default.alert_min_order_total'),
                currency_format($host->order_total),
                $host->name
            ));

  }
}