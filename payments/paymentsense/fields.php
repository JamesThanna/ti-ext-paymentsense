<?php

return [
    'fields' => [
        'mode' => [
            'label' => 'lang:miorder.paymentsense::default.label_mode',
            'type' => 'radiotoggle',
            'default' => 'test',
            'span' => 'left',
            'options' => [
                'test' => 'lang:miorder.paymentsense::default.label_mode_test',
                'live' => 'lang:miorder.paymentsense::default.label_mode_live',
            ],
        ],
        'capture_method' => [
            'label' => 'lang:miorder.paymentsense::default.label_capture_method',
            'type' => 'radiotoggle',
            'default' => 'PREAUTH',
            'span' => 'right',
            'options' => [
                'PREAUTH' => 'lang:miorder.paymentsense::default.label_capture_method_preauth',
                'SALE' => 'lang:miorder.paymentsense::default.label_capture_method_sale',
            ],
        ],
        'username' => [
            'label' => 'lang:miorder.paymentsense::default.label_username',
            'type' => 'text',
            'span' => 'left',
            'default' => '',
        ],
        'password' => [
            'label' => 'lang:miorder.paymentsense::default.label_password',
            'type' => 'text',
            'span' => 'right',
            'default' => '',
        ],
        'bearer_token' => [
            'label' => 'lang:miorder.paymentsense::default.label_bearer_token',
            'type' => 'textarea',
            'default' => '',
        ],
        'currency_code' => [
            'label' => 'lang:miorder.paymentsense::default.label_currency_code',
            'type' => 'text',
            'span' => 'left',
            'default' => '826',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'span' => 'right',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
            'span' => 'left',
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['mode', 'lang:miorder.paymentsense::default.label_mode', 'string'],
        ['capture_method', 'lang:miorder.paymentsense::default.label_capture_method', 'string'],
        ['username', 'lang:miorder.paymentsense::default.label_username', 'string'],
        ['password', 'lang:miorder.paymentsense::default.label_password', 'string'],
        ['bearer_token', 'lang:miorder.paymentsense::default.label_bearer_token', 'string'],
        ['currency_code', 'lang:miorder.paymentsense:default.label_currency_code', 'string'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'integer'],
    ],
];
