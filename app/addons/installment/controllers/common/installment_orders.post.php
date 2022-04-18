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
        $array_order['list'] = [];
        $order_id = $_REQUEST['order_id'];

        $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", (int)$order_id);
        $order_data = db_get_row("select  fargo_address, timestamp,company_id  from ?:orders where p_contract_id=?i ", $order_id);
        $address = unserialize($order_data['fargo_address']);

        if (empty($fargo_data) && $address['address_type'] === 'self') {
            $company_data = db_get_row('SELECT * FROM ?:companies WHERE company_id = ?i ', $order_data['company_id']);
            $company_data['city_name'] = db_get_field('SELECT city_name FROM ?:fargo_countries WHERE city_id = ?i', $company_data['city']);
            $company_address = $company_data['city_name'] . ' '
                . __('city') . ' '
                . $company_data['state'] . ' '
                . $company_data['address'];
            $data = [
                "status" => $address['address_type'],
                "address" => $company_address,
                "phone" => $company_data['phone'],
                "text" => __('pickup')
            ];

            Registry::get('ajax')->assign('result', $data);
            exit();
        }
        $fargo_order_id = $fargo_data['fargo_order_id'];
        $url = FARGO_URL . "/v1/customer/order/$fargo_order_id/history_items";
        $track_order = php_curl($url, [], "GET", fargoAuth());


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
        $fargo_data = db_get_row("select *  from ?:fargo_orders where paymart_contract_id=?i ", $order_id);
        $order_data = db_get_field("select  fargo_address from ?:orders where p_contract_id=?i ", $order_id);
        $address = unserialize($order_data);
        if (empty($fargo_data) && $address['address_type'] === 'self') {
            Registry::get('ajax')->assign('result', __('pickup'));
            Registry::get('ajax')->assign('status', 'self');
            exit();
        }
        $fargo_label_res = php_curl(
            FARGO_URL . '/v1/customer/orders/airwaybill_mini?ids=&order_numbers=' . $fargo_data['fargo_order_id'],
            [],
            'GET',
            fargoAuth()
        );
        $data_label = [
            "fargo_contract_label" => $fargo_label_res->data->value
        ];
        db_query('UPDATE ?:fargo_orders SET ?u WHERE fargo_order_id = ?i', $data_label, $order_id);
        Registry::get('ajax')->assign('result', $fargo_label_res->data->value);
        Registry::get('ajax')->assign('status', 'shipping');
        exit();
    }
}

