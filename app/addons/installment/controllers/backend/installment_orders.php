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
        $errors = [];
        $order_id = $_REQUEST['order_id'];
        $contract_status = $_REQUEST['status'];
        $order_data = null;

        $order = db_get_row("SELECT *,order_data.phone as user_phone from ?:orders as order_data 
                         INNER JOIN ?:companies as company ON order_data.company_id = company.company_id   
                         WHERE order_data.p_contract_id=?i", $order_id);

        $address = unserialize($order['fargo_address']);

        if (filter_var($contract_status, FILTER_VALIDATE_BOOLEAN)) {

            $order_data = [
                "status" => OrderStatuses::PAID
            ];

            $data_confirm = [
                "contract_id" => (int)$order['p_contract_id'],
                "online" => 1
            ];

            $confirm_res = php_curl('/buyers/partner-confirm', $data_confirm, "POST", $order['p_c_token'], 1);

            if ($confirm_res->status) {

                if (isset($address['address']['address_type']) && $address['address']['address_type'] !== 'self') {
                    createFargoOrder($order, $address);

                }

                db_query("UPDATE ?:orders SET ?u WHERE p_contract_id=?i", $order_data, $order_id);

                $errors = showErrors('success', $_REQUEST, "success");

            } else {

                $errors = showErrors('error', [], "error");

            }
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

                foreach ($address['shipping_params'] as $product_id => $product) {

                    $data = db_get_row("SELECT order_detail.amount AS amount,product.weight AS weight,product.amount AS product_amount  FROM ?:order_details AS order_detail
                       INNER JOIN ?:products AS product ON order_detail.product_id = product.product_id 
                       WHERE order_detail.order_id =?i AND order_detail.product_id= ?i", $order['order_id'], $product_id);

                    product_check_status($product_id, (int)$data['product_amount']);
//                    $product_data = [
//                        'amount' => (int)$data['amount'] + (int)$data['product_amount']
//                    ];
//                    db_query('UPDATE ?:products SET ?u WHERE product_id = ?i', $product_data, $product_id);
                }

            } else {

                $errors = showErrors('error', $contract_cancel_res, "error");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }
            $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", (int)$order_id);
            if (empty($fargo_data)) {
                $errors = showErrors('success', $_REQUEST, "success");
            } else {
                $fargo_order_id = $fargo_data['fargo_contract_id'];
                $url = FARGO_URL . "/v1/customer/order/$fargo_order_id/status?status=cancelled";
                $cancel_order = php_curl($url, [], "PUT", fargoAuth());
                if ($cancel_order->status == "success") {
                    $errors = showErrors('success', $_REQUEST, "success");
                } else {
                    $errors = showErrors('error', $cancel_order);
                }
            }
            Registry::get('ajax')->assign('result', $errors);
            exit();
        }
    }

    if ($mode == "upload_imei") {
        if ($auth['user_id']) {
            $user = db_get_row('select p_c_token from ?:companies where company_id = ?i ', $auth['company_id']);
            $file = $_FILES['file'];
            $data = [
                "id" => $_REQUEST['contract_id'],
                "imei" => createCurlFile($file)
            ];
            $response = php_curl('/contracts/upload-imei', $data, 'POST', $user['p_c_token'], 1);
            if ($response->status == "success") {
                $errors = showErrors('success', $_REQUEST, "success");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            } else {
                $errors = showErrors($data->response->message[0]->text, null, "error");
                Registry::get('ajax')->assign('result', $errors);
                exit();
            }
        }

        $errors = showErrors("auth", null, "error");
        Registry::get('ajax')->assign('result', $errors);
        exit();
    }

}

if ($mode == "index") {

    $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : null;
    $status_data = [];
    $params = [];
    $contract_status = null;

    switch ($status) {
        case 'moderation':
            $params = [
                [
                    'status' => 9,
                ],
            ];
            $contract_status = [0, 2];
            Tygh::$app['view']->assign('moderation', 'active');
            break;
        case 1:
            $params = [
                [
                    'contract|status' => ACCEPTED_ORDER,
                ]
            ];
            Tygh::$app['view']->assign('active', 'active');
            break;
        case '3|4':
            $params = [
                [
                    'contract|status' => [3, 4],
                ]
            ];
            Tygh::$app['view']->assign('overdue', 'active');
            break;
        case 5:
            $params = [
                [
                    'contract|status' => CANCELED_ORDER,
                ]
            ];
            Tygh::$app['view']->assign('cancelled', 'active');
            break;
        case 9:
            $params = [
                [
                    'contract|status' => COMPLETED_INSTALLMENT,
                ]
            ];
            Tygh::$app['view']->assign('closed', 'active');
            break;
        default:
            $params = [
                [
                    'status' => [
                        MODERATION_CONFIRMATION_FROM_USER,
                        CANCELED_ORDER,
                        COMPLETED_INSTALLMENT
                    ],
                ]
            ];

            Tygh::$app['view']->assign('all', 'active');
            break;
    }

    $page = $_REQUEST['page'] ?? 0;
    $offset = (10 * $page) - 10;

    $data = [
        "params" => $params,
        "online" => 1,
        "contract_status" => $contract_status,
        "limit" => 10,
        "offset" => $offset,
        "orderByDesc" => "created_at",
        "api_token" => "0621eee19912e71a4992d663184344a1"
    ];

    $order_res = php_curl('/orders/list', $data, 'POST', null);


    foreach ($order_res->data as $index => $order) {
        $order->company = db_get_row("select * from ?:companies where p_c_id = ?i ", $order->company_id);
    }

    Tygh::$app['view']->assign('paymart_orders', $order_res);

//    fn_print_die($data);
}

if ($mode == 'vendor') {

    $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : null;
    $company_id = Registry::get('runtime.company_id');
    $company_data = db_get_row("select *  from ?:companies where company_id=?i ", (int)$company_id);
    $user = db_get_row('select * from ?:users where company_id=?i', $company_id);

    $status_data = [];
    $params = [];

    switch ($status) {
        case 'moderation':
            $params = [
                [
                    'contract|status' => 0,
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ],
                [
                    'query_operation' => 'or',
                    'contract|status' => 2,
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];
            Tygh::$app['view']->assign('moderation', 'active');
            break;
        case 1:
            $params = [
                [
                    'contract|status' => ACCEPTED_ORDER,
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];
            Tygh::$app['view']->assign('active', 'active');
            break;
        case '3|4':
            $params = [
                [
                    'contract|status' => [3, 4],
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];
            Tygh::$app['view']->assign('overdue', 'active');
            break;
        case 5:
            $params = [
                [
                    'contract|status' => CANCELED_ORDER,
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];
            Tygh::$app['view']->assign('cancelled', 'active');
            break;
        case 9:
            $params = [
                [
                    'contract|status' => COMPLETED_INSTALLMENT,
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];
            Tygh::$app['view']->assign('closed', 'active');
            break;
        default:
            $params = [
                [
                    'status' => [
                        MODERATION_CONFIRMATION_FROM_USER,
                        CANCELED_ORDER,
                        COMPLETED_INSTALLMENT
                    ],
                    "partner_id" => [
                        $user['p_user_id']
                    ]
                ]
            ];

            Tygh::$app['view']->assign('all', 'active');
            break;
    }
    $page = $_REQUEST['page'] ?? 0;
    $offset = (10 * $page) - 10;

    $data = [
        "params" => $params,
        "online" => 1,
        "limit" => 10,
        "offset" => $offset,
        "orderByDesc" => "created_at",
        "api_token" => $company_data['p_c_token']
    ];
    $order_res = php_curl('/orders/list', $data, 'POST', null);

    Tygh::$app['view']->assign('paymart_orders', $order_res);
}


