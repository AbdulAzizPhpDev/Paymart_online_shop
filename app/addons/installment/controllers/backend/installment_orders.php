<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($mode=="get_orders"){

    }

}

if ($mode == "index") {

    $data = [
        "params" => [
            [
                "status" => [
                    MODERATION_CONFIRMATION_FROM_USER,
                    CANCELED_ORDER,
                    COMPLETED_INSTALLMENT
                ],
                "partner_id" => [
                    215199
                ]
            ]
        ],
        "limit" => 50,
        "offset" => 0,
        "orderByDesc" => "created_at",
        "api_token" => "5319972a3a412569fa05339851b4c7b8"
    ];

    $order_res = php_curl('/orders/list', $data, 'POST', null);

    Tygh::$app['view']->assign('paymart_orders', $order_res);


}