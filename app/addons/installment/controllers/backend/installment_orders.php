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
        $order_data = null;

        $order = db_get_row("select *,order_data.phone as user_phone from ?:orders as order_data 
                         INNER JOIN ?:companies as company ON order_data.company_id = company.company_id   
                         INNER JOIN ?:order_details as order_detail ON order_data.order_id = order_detail.order_id
                         where order_data.p_contract_id=?i", $order_id);

        if (filter_var($contract_status, FILTER_VALIDATE_BOOLEAN)) {

            $order_data = [
                "status" => OrderStatuses::COMPLETE
            ];
            $data_confirm = [
                "contract_id" => (int)$order['p_contract_id'],
                "online" => 1
            ];

            $confirm_res = php_curl('/buyers/partner-confirm', $data_confirm, "POST", $order['p_c_token'], 1);
            if ($confirm_res->status) {
                createFargoOrder($order_id);
                db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $order_data, $order_id);
                $errors = showErrors('success', $_REQUEST, "success");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }
            $errors = showErrors('error', [], "error");
            Registry::get('ajax')->assign('result', $errors);
            exit();

        } else {
            $order_data = [
                "status" => OrderStatuses::CANCELED
            ];
            $cancel_contract_data = [
                "contract_id" => $order['p_contract_id'],
                "buyer_phone" => $order['user_phone'],
                "api_token" => $order['p_c_token'],
                "online" => 1
            ];
            $contract_cancel_res = php_curl('/buyers/credit/cancel', $cancel_contract_data, 'POST', null);

            if ($contract_cancel_res->result->status === 1) {

            db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $order_data, $order_id);

            $product = db_get_row('select * from ?:products where product_id=?i', $order['product_id']);
            $product_data = [
                'amount' => (int)$product['amount'] + (int)$order['amount']
            ];
            db_query('UPDATE ?:products SET ?u WHERE product_id = ?i', $product_data, $product['product_id']);

            } else {
                $errors = showErrors('error', $contract_cancel_res, "error");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }

            $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", (int)$order_id);

            if (empty($fargo_data)) {

                $errors = showErrors('success', $_REQUEST, "success");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            } else {
                $fargo_order_id = $fargo_data['fargo_contract_id'];
                $url = FARGO_URL . "/v1/customer/order/$fargo_order_id/status?status=cancelled";
                $cancel_order = php_curl($url, [], "PUT", fargoAuth());

                if ($cancel_order->status == "success") {
                    $errors = showErrors('success', $_REQUEST, "success");
                    Registry::get('ajax')->assign('result', $errors);
                    exit();
                }
                $errors = showErrors('error', $cancel_order, "error");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }


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
    $offset = (10 * $page) - 10;

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
        "api_token" => "76d66c5a5356104a8fc6784e007d9c33"
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
    $offset = (10 * $page) - 10;

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