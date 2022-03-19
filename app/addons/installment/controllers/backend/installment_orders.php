<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;
use Tygh\Enum\OrderStatuses;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode == "change_status") {
        $contract_id = $_REQUEST['contract_id'];
        $contract_status = $_REQUEST['status'];
        $data = null;
        if ($contract_status) {
            $data = [
                "status" => OrderStatuses::COMPLETE
            ];
        } else {
            $data = [
                "status" => OrderStatuses::CANCELED
            ];
        }
        db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $data, $contract_id);


        $errors = showErrors('success', [], "success");
        Registry::get('ajax')->assign('result', $errors);
        exit();

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
        "limit" => 10,
        "offset" => 0,
        "orderByDesc" => "created_at",
        "api_token" => "5319972a3a412569fa05339851b4c7b8"
    ];

    $order_res = php_curl('/orders/list', $data, 'POST', null);

    Tygh::$app['view']->assign('paymart_orders', $order_res);


}