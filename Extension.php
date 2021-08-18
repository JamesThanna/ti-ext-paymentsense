<?php 

namespace Miorder\Paymentsense;

use System\Classes\BaseExtension;
use Admin\Models\Payments_model;

/**
 * paymentsense Extension Information File
 */
class Extension extends BaseExtension
{
    /**
     * Returns information about this extension.
     *
     * @return array
     */
  
   
  
      
      public function registerPaymentGateways()
    {
        return [
            'MiOrder\PaymentSense\PaymentSense' => [
                'code' => 'paymentsense',
                'name' => 'Payment Sense Gateway',
                'description' => 'Intergation Payment Gateway',
            ],

            
        ];
    }
  
  
  
    public function extensionMeta()
    {
        return [
            'name'        => 'paymentsense',
            'author'      => 'miorder',
            'description' => 'Intergation Payment Sense Gateway',
            'icon'        => 'fa-plug',
            'version'     => '1.0.0'
        ];
    }

    /**
     * Register method, called when the extension is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {
       $gateWay = Payments_model::select('data')->where('class_name', '=', 'MiOrder\PaymentSense\PaymentSense')->first();
      //($gateWay->transaction_mode);
    } 

    /**
     * Registers any front-end components implemented in this extension.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
// Remove this line and uncomment the line below to activate
//            'Miorder\Paymentsense\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any admin permissions used by this extension.
     *
     * @return array
     */
    public function registerPermissions()
    {
// Remove this line and uncomment block to activate
        return [
//            'Miorder.Paymentsense.SomePermission' => [
//                'description' => 'Some permission',
//                'group' => 'module',
//            ],
        ];
    }
}
