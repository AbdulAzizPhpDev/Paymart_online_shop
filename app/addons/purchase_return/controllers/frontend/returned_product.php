<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'upload') {
        fn_print_die($_REQUEST['product_ids'], $_FILES);
        if (empty($_REQUEST['product_ids'])) {
            Registry::get('ajax')->assign('result', showErrors('product_not_selected'));
            exit();
        }
        if (empty($_REQUEST['text'])) {
            Registry::get('ajax')->assign('result', showErrors('empty_description'));
            exit();
        }
        if (empty($_REQUEST['contract_id'])) {
            Registry::get('ajax')->assign('result', showErrors('contract_id_not_set'));
            exit();
        }
        $order = db_get_row("SELECT * FROM ?:orders  WHERE p_contract_id = ?i  ", $_REQUEST['contract_id']);

        $description = [
            "from" => $auth['user_id'],
            "to" => $order['company_id'],
            "order_id" => $order['order_id'],
            "description" => $_REQUEST['text']
        ];

        db_query("insert into ?:returned_product_descriptions ?e", $description);

        $status = 0;

        if (!isset($_FILES['images'])) {
            Registry::get('ajax')->assign('result', showErrors('success', [], 'success'));
            exit();
        }

        $images[] = $_FILES['images'];

        foreach ($images as $image) {
            $is_image = fn_get_image_extension($image['type']);
            if (!$is_image) {
                $status++;
            }
        }

        if ($status > 0) {
            Registry::get('ajax')->assign('result', showErrors('incorrect_image_type'));
            exit();
        }

        $files = $_FILES['images'];
        $file_path = null;
        $products = json_encode($_REQUEST['product_ids']);

        foreach ($files as $product_id => $image) {
            $image['path'] = fn_array_multimerge([], $image['tmp_name'], 'path');
            $format = 'sess_data/' . $order['order_id'] . '/%s';
            $file_path = sprintf($format, \Tygh\Tools\SecurityHelper::sanitizeFileName(urldecode($image['name'])));
            list(, $image['path']) = Storage::instance('custom_files')->put($file_path, array(
                'file' => $image['path']
            ));
            $data = [
                "order_id" => $order['order_id'],
                "product_id" => $product_id,
                "path" => $file_path
            ];
            db_query(" insert into ?:returned_product_images ?e", $data);
        }

//        if (!empty($file['path']) && is_uploaded_file($file['path'])) {
//
////            $status = "exchange_product";
////            $status = "refund";
////            $date = [
////                "order_id" => $order['order_id'],
////                "contract_id" => $_REQUEST['contract_id'],
////                "status" => $_REQUEST['status'],
////                "products" => $products,
////                "description" => $_REQUEST['text'],
////                "image" => $file_path,
////                "timestamp" => 132165,
////            ];
////            $r_p = db_query("insert into ?:returned_products ?e", $date);
////            Registry::get('ajax')->assign('result', showErrors('success', [], 'success'));
////            exit();
//        } else {
//            Registry::get('ajax')->assign('result', showErrors(__('empty')));
//            exit();
//        }

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

