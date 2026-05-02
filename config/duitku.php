<?php

return [
    'mode' => env('DUITKU_MODE', 'sandbox'),
    'merchant_key' => env('DUITKU_MERCHANT_KEY'),
    'merchant_code' => env('DUITKU_MERCHANT_CODE'),
    'callback_url' => env('DUITKU_CALLBACK_URL'),
    'return_url' => env('DUITKU_RETURN_URL'),
];