<?php

namespace MiOrder\PaymentSense\Payments;

use Admin\Classes\BasePaymentGateway;
use ApplicationException;
use Cart;
use DB;
use EventEmitter;
use GuzzleHttp\Client;
use Session;

class PaymentSense extends BasePaymentGateway
{
    public function completesPaymentOnClient()
    {
        return TRUE;
    }

    public function beforeRenderPaymentForm($host, $controller)
    {
        $controller->addJs($this->model->mode == 'live' ? 'https://web.e.connect.paymentsense.cloud/assets/js/client.js' : 'https://web.e.test.connect.paymentsense.cloud/assets/js/client.js', 'paymentsense-lib-js');
        $controller->addJs('$/miorder/paymentsense/assets/js/paymentsense.js', 'paymentsense-js');
        $controller->addCss('$/miorder/paymentsense/assets/css/paymentsense.css', 'paymentsense-csss');
    }

    private function checkPayment($token)
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->model->bearer_token}",
            ]
        ]);

        $url = $this->gatewayUrl().'payments/'.$token;
        $response = $client->get($url);
        $contents = $response->getBody()->getContents();

        return json_decode($contents);
    }

    protected function gatewayUrl()
    {
        return $this->model->mode == 'live' ? 'https://e.connect.paymentsense.cloud/v1/' : 'https://e.test.connect.paymentsense.cloud/v1/';
    }

    public function getHiddenFields()
    {
        //if ($token = Session::get('ti_paymentsense_token')) {
        // not sure if we want to persist tokens across session as it may change / order amount may change?
            $token = $this->getToken();
            Session::put('ti_paymentsense_token', $token);
        //}

        return [
            'paymentsense_amount' => number_format(Cart::total(), 2, '', ''),
            'paymentsense_currency' => $this->model->currency_code, // make this a variable in fields.php?
            'paymentsense_token' => $token['token'],
            'paymentsense_order_id' => $token['order_id'],
        ];
    }

    private function getToken()
    {
        $order_id = 'order-'.substr(str_shuffle('0123456789'), 1, 5);

        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$this->model->bearer_token}",
            ]
        ]);

        $response = $client->post($this->gatewayUrl().'access-tokens', [
            'json' => [
                'gatewayUsername' => $this->model->username,
                'gatewayPassword' => $this->model->password,
                'currencyCode' => $this->model->currency_code,
                'amount' => number_format(Cart::total(), 2, '', ''),
                'transactionType' => $this->model->capture_method,
                'orderId' => $order_id,
                'userAgent' => 'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36',
                'userCountryCode' => $this->model->currency_code,
            ]
        ]);

        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);

        return [
            'token' => $contents->id,
            'order_id' => $order_id
        ];
    }

    public function isApplicable($total, $host)
    {
        return $host->order_total <= $total;
    }

    public function processPaymentForm($data, $host, $order)
    {
        $checkPayment = $this->checkPayment($data['paymentsense_token']);

        if ($checkPayment->statusCode === 0)
        {
            $order->logPaymentAttempt('Payment successful', 1, $data, $checkPayment, FALSE);
            $order->updateOrderStatus($host->order_status, ['notify' => FALSE]);
            $order->markAsPaymentProcessed();
        }
        else {
            $order->logPaymentAttempt('Payment error', 0, $data, $checkPayment);
            throw new ApplicationException($checkPayment->message);
        }

    }
}
