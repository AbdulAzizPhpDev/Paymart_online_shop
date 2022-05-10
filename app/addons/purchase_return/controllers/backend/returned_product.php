<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'returns') {
        fn_print_die($mode);
    }
    if ($mode == 'response') {

        $contract_id = 64722;
        $category_name = '';

        $order = db_get_row("SELECT *,order_data.phone as user_phone from ?:orders as order_data 
                         INNER JOIN ?:companies as company ON order_data.company_id = company.company_id   
                         WHERE order_data.p_contract_id=?i", $contract_id);

        $address = @unserialize($order['fargo_address']);
        $user = db_get_row("select * from ?:users where user_id = ?i ", $order['user_id']);

        $product_ids = db_get_fields("select product_id from ?:order_details where order_id = ?i", $order['order_id']);
        $user_address = $address['address'];

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

        if ($user_address['address_type'] == "shipping") {

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

            fn_print_die($fargo_order_res);
        }


    }

}

if ($mode == 'manage') {

    $returns = null;

    if ($auth['user_type'] == "A") {
        $returns = db_get_array("select * from ?:returned_products order by status asc ");
    } else {
        $company_id = db_get_fields("select company_id from ?:users where user_id = ?i", $auth['user_id']);
        $returns = db_get_array("select * from ?:returned_products where vendor_id = ?i", $company_id);
    }
    Tygh::$app['view']->assign('returned_products', $returns);


}

