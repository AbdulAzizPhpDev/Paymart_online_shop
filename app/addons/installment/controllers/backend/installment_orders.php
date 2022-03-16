<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($mode == "index") {


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dev.paymart.uz/api/v1/orders/list',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "params": [
        {
            "status": [
                0,
                5,
                9
            ],
            "partner_id": [
                215199
            ]
        }
    ],
    "limit": 50,
    "offset": 0,
    "orderByDesc": "created_at",
    "api_token": "5319972a3a412569fa05339851b4c7b8"
}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = json_decode(curl_exec($curl));

    curl_close($curl);

    Tygh::$app['view']->assign('paymart_orders', $response->data);


}