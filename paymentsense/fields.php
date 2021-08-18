<?php

return [
    'fields' => [
            'mode' => [
            'label' => 'Payment Sense Mode',
            'type' => 'radiotoggle',
            'default' => 'test',
            'span' => 'left',
            'options' => [
                'https://e.test.connect.paymentsense.cloud/v1/' => 'Test API',
                'https://e.connect.paymentsense.cloud/v1/' => 'Live API',
            ],
        ],
            'capture_method' => [
            'label' => 'Capture Method',
            'type' => 'radiotoggle',
            'default' => 'Pre-Capture',
            'span' => 'right',
            'options' => [
                'PREAUTH' => 'Pre-auth Payments',
                'SALE' => 'Sale Payments',
            ],
        ],
            'bearer_token' => [
            'label' => 'Bearer Token',
            'type' => 'textarea',
            'span' => 'right',
            'default' => '',
            'comment' => 'JWT Token',
        ],
            'username' => [
            'label' => 'Username',
            'type' => 'text',
            'span' => 'right',
            'default' => '',
            'comment' => 'username',
        ],
              'password' => [
            'label' => 'Password',
            'type' => 'text',
            'span' => 'right',
            'default' => '',
            'comment' => 'password',
        ],
        'order_fee' => [
            'label' => 'lang:igniter.payregister::default.label_order_fee',
            'type' => 'number',
            'span' => 'right',
            'default' => 0,
            'comment' => 'lang:igniter.payregister::default.help_order_fee',
        ],
        'order_total' => [
            'label' => 'lang:igniter.payregister::default.label_order_total',
            'type' => 'currency',
            'span' => 'left',
            'comment' => 'lang:igniter.payregister::default.help_order_total',
        ],
        'order_status' => [
            'label' => 'lang:igniter.payregister::default.label_order_status',
            'type' => 'select',
            'options' => ['Admin\Models\Statuses_model', 'getDropdownOptionsForOrder'],
            'span' => 'right',
            'comment' => 'lang:igniter.payregister::default.help_order_status',
        ],
    ],
    'rules' => [
        ['transaction_mode', 'lang:igniter.payregister::default.stripe.label_transaction_mode', 'string'],
        ['live_secret_key', 'lang:igniter.payregister::default.stripe.label_live_secret_key', 'string'],
        ['live_publishable_key', 'lang:igniter.payregister::default.stripe.label_live_publishable_key', 'string'],
        ['test_secret_key', 'lang:igniter.payregister::default.stripe.label_test_secret_key', 'string'],
        ['test_publishable_key', 'lang:igniter.payregister::default.stripe.label_test_publishable_key', 'string'],
        ['order_fee_type', 'lang:igniter.payregister::default.label_order_fee_type', 'integer'],
        ['order_fee', 'lang:igniter.payregister::default.label_order_fee', 'numeric'],
        ['order_total', 'lang:igniter.payregister::default.label_order_total', 'numeric'],
        ['order_status', 'lang:igniter.payregister::default.label_order_status', 'integer'],
    ],
];
