<?php

use Tygh\Registry;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'upload') {

    }

}

if ($mode == 'manage') {

    if ($_REQUEST['contract_id'] == 0) {
        Registry::get('ajax')->assign('result', showErrors(__('empty')));
        exit();
    }

    $products = [];
    $order_items = db_get_array("SELECT * FROM ?:orders AS order_data
                          INNER JOIN ?:order_details AS order_detail ON order_data.order_id = order_detail.order_id  
                          WHERE order_data.p_contract_id = ?i  ", $_REQUEST['contract_id']);
    if (!empty($order_items)) {
        foreach ($order_items as $item) {
            $products[] = @unserialize($item['extra']);
        }
        Registry::get('ajax')->assign('result', showErrors("success", $products, "success"));
        exit();
    } else {

        Registry::get('ajax')->assign('result', showErrors(__('empty')));
        exit();
    }


}

