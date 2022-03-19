<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode == "get_orders") {

    }

}

if ($mode == "index") {

    $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : null;
    $status_data = [];
    $contract = 'contract|status';

    switch ($status) {
        case 'moderation':
            $status_data = MODERATION_CONFIRMATION_FROM_USER;
            Tygh::$app['view']->assign('moderation', 'active');
            break;
        case 1:
            $status_data = ACCEPTED_ORDER;
            Tygh::$app['view']->assign('active', 'active');
            break;
        case '3|4':
            $status_data = [3, 4];
            Tygh::$app['view']->assign('overdue', 'active');
            break;
        case 5:
            $status_data = CANCELED_ORDER;
            Tygh::$app['view']->assign('cancelled', 'active');
            break;
        case 9:
            $status_data = COMPLETED_INSTALLMENT;
            Tygh::$app['view']->assign('closed', 'active');
            break;
        default:
            $status_data = [
                MODERATION_CONFIRMATION_FROM_USER,
                CANCELED_ORDER,
                COMPLETED_INSTALLMENT
            ];
            $contract = 'status';

            Tygh::$app['view']->assign('all', 'active');
            break;
    }

    $data = [
        "params" => [
            [
                $contract => $status_data,
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

if ($mode == 'vendor') {

    $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : null;
    $status_data = [];
    $contract = 'contract|status';

    switch ($status) {
        case 'moderation':
            $status_data = MODERATION_CONFIRMATION_FROM_USER;
            Tygh::$app['view']->assign('moderation', 'active');
            break;
        case 1:
            $status_data = ACCEPTED_ORDER;
            Tygh::$app['view']->assign('active', 'active');
            break;
        case '3|4':
            $status_data = [3, 4];
            Tygh::$app['view']->assign('overdue', 'active');
            break;
        case 5:
            $status_data = CANCELED_ORDER;
            Tygh::$app['view']->assign('cancelled', 'active');
            break;
        case 9:
            $status_data = COMPLETED_INSTALLMENT;
            Tygh::$app['view']->assign('closed', 'active');
            break;
        default:
            $status_data = [
                MODERATION_CONFIRMATION_FROM_USER,
                CANCELED_ORDER,
                COMPLETED_INSTALLMENT
            ];
            $contract = 'status';

            Tygh::$app['view']->assign('all', 'active');
            break;
    }

    $data = [
        "params" => [
            [
                $contract => $status_data,
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