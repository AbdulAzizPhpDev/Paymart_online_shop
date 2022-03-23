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
        $order_id = $_REQUEST['order_id'];
        $contract_status = $_REQUEST['status'];
        $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", $_REQUEST['order_id']);
        $fargo_order_id = $fargo_data['fargo_contract_id'];
        $data = null;
        if ($contract_status) {
            $data = [
                "status" => OrderStatuses::COMPLETE
            ];
            createFargoOrder($fargo_order_id);

            db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $data, $order_id);
            $errors = showErrors('success', $_REQUEST, "success");
            Registry::get('ajax')->assign('result', $errors);
            exit();
        } else {
            $data = [
                "status" => OrderStatuses::CANCELED
            ];

            $url = FARGO_URL . "/v1/customer/order/$fargo_order_id/status?status=cancelled";
            $cancel_order = php_curl($url, [], "PUT", fargoAuth());

            if ($cancel_order->status == "success") {
                db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $data, $order_id);

                $errors = showErrors('success', $_REQUEST, "success");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }

            $errors = showErrors('error', [], "error");
            Registry::get('ajax')->assign('result', $errors);
            exit();
        }

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
    $page = $_REQUEST['page'] ?? 0;
    $offset = 10 * $page;

    $data = [
        "params" => [
            [
                $contract => $status_data,
            ]
        ],
        "online" => 1,
        "limit" => 10,
        "offset" => $offset,
        "orderByDesc" => "created_at",
        "api_token" => "83d31dbe5da41397ea2352f58e163dee"
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
    $page = $_REQUEST['page'] ?? 0;
    $offset = 10 * $page;

    $data = [
        "params" => [
            [
                $contract => $status_data,
                "partner_id" => [
                    215084
                ]
            ]
        ],
        "online" => 1,
        "limit" => 10,
        "offset" => $offset,
        "orderByDesc" => "created_at",
        "api_token" => "5233c73b2a68016fbcfc51ccfd35c6ed"
    ];

    $order_res = php_curl('/orders/list', $data, 'POST', null);

    Tygh::$app['view']->assign('paymart_orders', $order_res);
}