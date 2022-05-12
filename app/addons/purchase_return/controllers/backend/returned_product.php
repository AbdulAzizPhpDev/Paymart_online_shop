<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'response') {
        if ($_REQUEST['status'] == "accepted") {

            $order_id = $_REQUEST['order_id'];

            $order_check = db_get_row("select * from ?:returned_products  where order_id = ?i ", $order_id);

            if ($order_check['status'] != "processing") {
                Registry::get('ajax')->assign('result', showErrors('impossible_to_change_status'));
                exit();
            }

            $text = "";
            $company_id = 0;

            if ($auth['user_type'] == "A") {

                $text = "accepted_by_admin";
                $company_id = $_REQUEST['company_id'];

            } else {

                $text = "accepted_by_vendor";
                $company_id = $auth['company_id'];

            }

            $description = [
                "from" => $company_id,
                "to" => $_REQUEST['user_id'],
                "order_id" => $_REQUEST['order_id'],
                "description" => $text
            ];

            db_query("insert into ?:returned_product_descriptions ?e", $description);

            db_query("UPDATE ?:returned_products  SET `status` = 'accepted' where order_id = ?i ", $order_id);

            $category_name = '';

            $order = db_get_row("SELECT *,order_data.phone as user_phone from ?:orders as order_data 
                         INNER JOIN ?:companies as company ON order_data.company_id = company.company_id   
                         WHERE order_data.order_id=?i", $order_id);

            $address = @unserialize($order['fargo_address']);
            $user_address = $address['address'];


            if ($user_address['address_type'] == "shipping") {

                $user = db_get_row("select * from ?:users where user_id = ?i ", $order['user_id']);

                $box_width = 0;
                $box_height = 0;
                $box_length = 0;

                $product_ids = [];
                $total_weight = 0;
                $total_amount = 0;

                foreach ($address['shipping_params'] as $product_id => $product) {
                    $box_width += $product['box_width'];
                    $box_height += $product['box_height'];
                    $box_length += $product['box_length'];
                    $product_ids[] = $product_id;
                    $data = db_get_row("SELECT order_detail.amount AS amount,product.weight AS weight FROM ?:order_details AS order_detail
                       INNER JOIN ?:products AS product ON order_detail.product_id = product.product_id 
                       WHERE order_detail.order_id =?i AND order_detail.product_id= ?i", $order['order_id'], $product_id);

                    $total_weight += $data['weight'] * $data['amount'];
                    $total_amount += $data['amount'];
                }

                $category_names = db_get_array('select category.category as name from ?:products_categories as product 
                            inner join ?:category_descriptions as category on product.category_id = category.category_id and product.link_type="M"  and category.lang_code = ?s 
                            where product.product_id IN (?a)', CART_LANGUAGE, $product_ids);

                foreach ($category_names as $name) {
                    $category_name .= ' ' . $name['name'];
                }

                $product_shipping_data = $address['address'];

                $neighborhood = [
                    "name" => $address['address']['neighborhood']
                ];

                $fargo_data = [
                    "sender_data" => fn_fargo_uz_sender_recipient_data(
                        "residential",
                        (!empty($user['lastname']) || !empty($user['firstname'])) ? $user['lastname'] . ' ' . $user['firstname'] : "user",
                        263947002,
                        234,
                        '+' . $user['phone'],
                        null,
                        $product_shipping_data['apartment'],
                        $product_shipping_data['building'],
                        $product_shipping_data['street'],
                        null,
                        $neighborhood

                    ),
                    "recipient_data" => fn_fargo_uz_sender_recipient_data(
                        "residential",
                        $order['company'],
                        $order['city'],
                        234,
                        '+' . $order['phone'],
                        null,
                        $order['address'],
                        null,
                        null,
                        null,
                        ["name" => $order['state']]

                    ),
                    "dimensions" => fn_fargo_uz_dimensions(
                        ($total_weight > 1) ? round($total_weight) : 1,
                        $box_width,
                        $box_height,
                        $box_length,
                        1,
                        true),
                    "package_type" => [
                        "courier_type" => "DOOR_DOOR"
                    ],
                    "charge_items" => [
                        fn_fargo_uz_charge_items("service_custom", "sender")
                    ],
                    "recipient_not_available" => "do_not_deliver",
                    "payment_type" => "credit_balance",
                    "payer" => "sender",
                    "note" => "$category_name - НУЖНО ПОДПИСАТЬ АКТ И ВЕРНУТЬ ОТПРАВИТЕЛЮ"
                ];

                $fargo_data_auth = [
                    "username" => FARGO_USERNAME,
                    "password" => FARGO_PASSWORD
                ];
                $url = FARGO_URL . "/v1/customer/authenticate";
                $fargo_auth_res = php_curl($url, $fargo_data_auth, 'POST', '');


                $url = FARGO_URL . '/v2/customer/order';
                $fargo_order_res = php_curl($url, $fargo_data, 'POST', $fargo_auth_res->data->id_token);

            }
        } else {
            $order_id = $_REQUEST['order_id'];
            $order_check = db_get_row("select * from ?:returned_products  where order_id = ?i ", $order_id);


            if ($order_check['status'] != "processing") {
                Registry::get('ajax')->assign('result', showErrors('impossible_to_change_status'));
                exit();
            }

            if ($auth['user_type'] == "A") {
                $company_id = $_REQUEST['company_id'];
            } else {
                $company_id = $auth['company_id'];
            }

            $description = [
                "from" => $company_id,
                "to" => $_REQUEST['user_id'],
                "order_id" => $_REQUEST['order_id'],
                "description" => $_REQUEST['description']
            ];

            db_query("insert into ?:returned_product_descriptions ?e", $description);

            db_query("UPDATE ?:returned_products  SET `status` = 'cancelled' where order_id = ?i ", $order_id);
        }
        Registry::get('ajax')->assign('result', showErrors('status_change_successfully', [], "success"));
        exit();
    }

}

if ($mode == 'manage') {

    $returns = null;
    $data = [];
    if ($auth['user_type'] == "A") {
        $quantity = db_get_row("select COUNT(order_id) as number from ?:returned_products");
        $returns = db_get_array("select *  from ?:returned_products");


        foreach ($returns as $item) {
            $order_info = fn_get_order_info($item['order_id'], false, false);

            $data['quantity'] = $quantity['number'];

            $data['data'][$item['order_id']] = $item;

            $data['data'][$item['order_id']]['user'] = db_get_row("select * from ?:users where user_id = ?i ", $order_info['user_id']);

            $data['data'][$item['order_id']]['company'] = db_get_row("select * from ?:companies where company_id = ?i ", $item['vendor_id']);

            $data['data'][$item['order_id']]['description']['user'] = db_get_row("select * from ?:returned_product_descriptions 
                                                                                    where order_id = ?i and `from` = ?i ", $item['order_id'], $order_info['user_id']);

            $data['data'][$item['order_id']]['description']['vendor'] = db_get_row("select * from ?:returned_product_descriptions 
                                                                                      where order_id = ?i and `from` = ?i ", $item['order_id'], $item['vendor_id']);


            $images = db_get_array("select * from ?:returned_product_images where order_id = ?i ", $item['order_id']);
            foreach ($images as $image) {
                $field = [
                    'product_id',
                    'company_id'
                ];
                $product_info = getProductInfo($image['product_id'], $field);

                $new_array = [
                    'image' => $image['path'],
                    'name' => $product_info['descriptions'],
                    'price' => $product_info['price']['price'],
                    'quantity' => db_get_field("select amount from ?:order_details where order_id = ?i and product_id = ?i", $item['order_id'], $image['product_id'])
                ];

                $data['data'][$item['order_id']]['product_data'][$image['product_id']] = $new_array;

            }
        }


    } else {

        $company_id = db_get_fields("select company_id from ?:users where user_id = ?i", $auth['user_id']);

        $quantity = db_get_row("select COUNT(order_id) as number from ?:returned_products  where vendor_id = ?i", $company_id);

        $returns = db_get_array("select *  from ?:returned_products where vendor_id = ?i", $company_id);


        foreach ($returns as $item) {
            $order_info = fn_get_order_info($item['order_id'], false, false);

            $data['quantity'] = $quantity['number'];

            $data['data'][$item['order_id']] = $item;

            $data['data'][$item['order_id']]['user'] = db_get_row("select * from ?:users where user_id = ?i ", $order_info['user_id']);

            $data['data'][$item['order_id']]['description']['user'] = db_get_row("select * from ?:returned_product_descriptions 
                                                                                  where order_id = ?i and `from` = ?i ", $item['order_id'], $order_info['user_id']);

            $data['data'][$item['order_id']]['description']['vendor'] = db_get_row("select * from ?:returned_product_descriptions 
                                                                                    where order_id = ?i and `from` = ?i ", $item['order_id'], $item['vendor_id']);

            $images = db_get_array("select * from ?:returned_product_images where order_id = ?i ", $item['order_id']);

            foreach ($images as $image) {
                $field = [
                    'product_id',
                    'company_id'
                ];
                $product_info = getProductInfo($image['product_id'], $field);

                $new_array = [
                    'image' => $image['path'],
                    'name' => $product_info['descriptions'],
                    'price' => $product_info['price']['price'],
                    'quantity' => db_get_field("select amount from ?:order_details where order_id = ?i and product_id = ?i", $item['order_id'], $image['product_id'])
                ];

                $data['data'][$item['order_id']]['product_data'][$image['product_id']] = $new_array;

            }
        }

    }

    Tygh::$app['view']->assign('returned_products', $data);


}

