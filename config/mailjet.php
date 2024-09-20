<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | API Token
    |--------------------------------------------------------------------------
    |
    | Your API Key & Secret from https://mailjet.com
    |
    */

    'key' => env('MAILJET_APIKEY', ''),
    'secret' => env('MAILJET_APISECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Email Sender
    |--------------------------------------------------------------------------
    |
    | Email and Name used by Mailjet when sending email.
    | This configuration is used when sending mail.
    |
    */

    'emailFrom' => [
        'Email' => env('MAIL_FROM_ADDRESS'),
        'Name' => env('MAIL_FROM_NAME'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Sender
    |--------------------------------------------------------------------------
    |
    | Defines the name that will be used as the "from" for all outgoing text messages
    |
    */

    'smsFrom' => env('MAILJET_SMS_SENDER'),
    'smsToken' => env('MAILJET_SMSTOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Dry
    |--------------------------------------------------------------------------
    |
    */

    'dry' => (bool) env('MAILJET_DRY', false),

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    |
    */

    'options' => [
        'version' => 'v3.1',
    ],

];
