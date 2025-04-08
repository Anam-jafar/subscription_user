<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'awfatech' => [
        'appcode' => env('AWFATECH_APPCODE'),
        'appcode_url' => env('AWFATECH_APPCODE_URL'),
        'send_otp_url' => env('AWFATECH_SEND_OTP_URL'),
        'check_otp_url' => env('AWFATECH_CHECK_OTP_URL'),
        'make_payment_url' => env('AWFATECH_MAKE_PAYMENT_URL'),
        'pdf_base_url' => env('AWFATECH_PDF_BASE_URL'),


    ],


];
