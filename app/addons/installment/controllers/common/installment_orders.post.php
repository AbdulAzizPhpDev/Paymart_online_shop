<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;
use Tygh\Enum\OrderStatuses;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode == "order_tracking") {
        $order_id = $_REQUEST['order_id'];
        $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", (int)$order_id);
        $fargo_order_id = $fargo_data['fargo_order_id'];

        $url = FARGO_URL . "/v1/customer/order/$fargo_order_id/history_items";
        $track_order = php_curl($url, [], "GET", fargoAuth());

        $array_order['list'] = [];

        foreach ($track_order->data->list as $item) {
            $data = [
                "status" => __($item->status),
                "date" => $item->date
            ];
            array_push($array_order['list'], $data);
        }

        Registry::get('ajax')->assign('result', $array_order);
        exit();
    }

    if ($mode == "get_barcode") {


        $order_id = $_REQUEST['order_id'];
        $fargo_label_res = php_curl(
            FARGO_URL . '/v1/customer/orders/airwaybill_mini?ids=&order_numbers=' . $order_id,
            [],
            'GET',
            fargoAuth()
        );
        $data_label = [
            "fargo_contract_label" => $fargo_label_res->data->value
        ];
        db_query('UPDATE ?:fargo_orders SET ?u WHERE fargo_order_id = ?i', $data_label, $order_id);
        $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", $order_id
        );

        Registry::get('ajax')->assign('result', $fargo_label_res->data->value);
        exit();
    }
}

