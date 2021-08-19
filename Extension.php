<?php

namespace Miorder\Paymentsense;

use System\Classes\BaseExtension;

class Extension extends BaseExtension
{
    public function registerPaymentGateways()
    {
        return [
            'MiOrder\PaymentSense\Payments\PaymentSense' => [
                'code' => 'paymentsense',
                'name' => 'Payment Sense',
                'description' => 'Accept payments with Payment Sense',
            ],
        ];
    }

    public function extensionMeta()
    {
        return [
            'name' => 'paymentsense',
            'author' => 'miorder',
            'description' => 'Integration with Payment Sense Gateway',
            'icon' => 'fa-plug',
            'version' => '1.0.0'
        ];
    }
}
