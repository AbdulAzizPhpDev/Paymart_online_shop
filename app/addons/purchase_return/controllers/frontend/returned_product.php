<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'upload') {

fn_print_die($_FILES);
        if (!isset($_FILES['image'])) {

            Registry::get('ajax')->assign('result', showErrors('success', [], 'success'));
            exit();
        }
        $file = $_FILES['image'];
        $file['path'] = fn_array_multimerge([], $file['tmp_name'], 'path');
        $order = db_get_row("SELECT * FROM ?:orders  WHERE p_contract_id = ?i  ", $_REQUEST['contract_id']);
        $format = 'sess_data/' . $order['order_id'] . '/%s';
        $products = json_encode($_REQUEST['product_ids']);
        $file_path = null;

        if (!empty($file['path']) && is_uploaded_file($file['path'])) {
            $file_path = sprintf($format, \Tygh\Tools\SecurityHelper::sanitizeFileName(urldecode($file['name'])));
            list(, $file['path']) = Storage::instance('custom_files')->put($file_path, array(
                'file' => $file['path']
            ));
            $status = "exchange_product";
            $status = "refund";
            $date = [
                "order_id" => $order['order_id'],
                "contract_id" => $_REQUEST['contract_id'],
                "status" => $_REQUEST['status'],
                "products" => $products,
                "description" => $_REQUEST['text'],
                "image" => $file_path,
                "timestamp" => 132165,
            ];
            $r_p = db_query("insert into ?:returned_products ?e", $date);
            Registry::get('ajax')->assign('result', showErrors('success', [], 'success'));
            exit();
        } else {
            Registry::get('ajax')->assign('result', showErrors(__('empty')));
            exit();
        }

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
            $products[] = unserialize($item['extra']);
        }
        Registry::get('ajax')->assign('result', showErrors("success", $products, "success"));
        exit();
    } else {

        Registry::get('ajax')->assign('result', showErrors(__('empty')));
        exit();
    }


}

