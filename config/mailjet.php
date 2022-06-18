<?php

return [
    'key' => env('MAILJET_APIKEY'),
    'secret' => env('MAILJET_APISECRET'),
    'smsToken' => env('MAILJET_SMSTOKEN'),
    'emailFrom' => [
        'Email' => env('MAIL_FROM_ADDRESS'),
        'Name' => env('MAIL_FROM_NAME'),
    ],
    'smsFrom' => env('MAILJET_SMS_SENDER'),
    'options' => [
        'version' => 'v3.1',
    ],
];
