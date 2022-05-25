<?php

/***************************************************************************
 *                                                                          *
 *   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
 *                                                                          *
 * This  is  commercial  software,  only  users  who have purchased a valid *
 * license  and  accept  to the terms of the  License Agreement can install *
 * and use this program.                                                    *
 *                                                                          *
 ****************************************************************************
 * PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
 * "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
 ****************************************************************************/

use Tygh\Languages\Languages;
use Tygh\Registry;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

function checkInstallmentStep($user_id)
{
    $user = db_get_row('select * from ?:users where user_id = ?s', $user_id);
    return InstallmentVar::Pages[$user['i_step']];
}

function checkUserFromPaymart($user_id)
{
    $user = db_get_row('select * from ?:users where user_id = ?s', $user_id);

    if (!empty($user['api_key'])) {
        $response = php_curl('/buyer/check_status', [], 'POST', $user['api_key']);
        if ($response->status == "success") {
            if ($response->data->status != $user['i_step']) {
                $user_info = [
                    'i_step' => $response->data->status
                ];
                db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_info, $user['user_id']);
            } else {
                if ($response->data->status == 4) {
                    $user_info = ['i_limit' => $response->data->available_balance];
                    db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_info, $user['user_id']);
                }
            }
            return true;
        }

    }
    return false;
}

function php_curl($url = '', $data = [], $method = 'GET', $token = null, $header_type = 0)
{

    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $curl_options[CURLOPT_URL] = $url;
    } else {
        $curl_options[CURLOPT_URL] = PAYMART_CABINET_API_URL . $url;
    }
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_ENCODING] = '';
    $curl_options[CURLOPT_MAXREDIRS] = 10;
    $curl_options[CURLOPT_TIMEOUT] = 0;
    $curl_options[CURLOPT_FOLLOWLOCATION] = true;
    $curl_options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
    $curl_options[CURLOPT_CUSTOMREQUEST] = "$method";
    if ($header_type == 1) {
        $curl_options[CURLOPT_HTTPHEADER] = array('Content-Type:multipart/form-data');
    } else {
        $curl_options[CURLOPT_HTTPHEADER] = array('Content-Type: application/json');
    }
    if (!empty($token)) {

        array_push($curl_options[CURLOPT_HTTPHEADER], ('Authorization: Bearer ' . $token));
    }
    if (!empty($data)) {
        if ($header_type == 1) {
            $curl_options[CURLOPT_POSTFIELDS] = ($data);
        } else {
            $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

    }

    $curl = curl_init();
    curl_setopt_array($curl, $curl_options);
    $response = json_decode(curl_exec($curl));
    curl_close($curl);
    return $response;
}

function showErrors($text, $data = [], $status = "error"): array
{
    $error = [
        'status' => $status,
        'response' => [
            "code" => "401",
            "message" => __("$text"),
            "errors" => ""
        ],
        'data' => $data

    ];

    return $error;
}


function createOrder($products, $user, $company, $params, $contract_id, $total_price, $total_amount)
{
    $ip = fn_get_ip();
    $order['ip_address'] = fn_ip_to_db($ip['host']);
    $order['timestamp'] = TIME;
    $order['updated_at'] = $order['timestamp'];
    $order['lang_code'] = isset($user_lang) && !empty($user_lang) ? $user_lang : CART_LANGUAGE;
    $order['status'] = STATUS_INCOMPLETED_ORDER;
    $order['is_parent_order'] = 'N';
    $order['issuer_id'] = 1;
    $order['total'] = $total_price;
    $order['company_id'] = $company['company_id'];

    $order['user_id'] = $user['user_id'];
    $order['phone'] = $user['phone'];
    $order['email'] = $user['email'];
    $order['firstname'] = $user['firstname'];
    $order['lastname'] = $user['lastname'];
    $order['b_firstname'] = $user['firstname'];
    $order['b_lastname'] = $user['lastname'];


    if (!empty($params)) {
        $order['fargo_address'] = serialize($params);
        $order['p_contract_id'] = $contract_id;
    }
    $order_id = db_query("INSERT INTO ?:orders ?e", $order);
    $test = [];
//    foreach ($products as $key => $product) {
//     $test[] = $product;
//    }
//    fn_print_die($test);
    foreach ($products as $key => $product) {
        $order_details = [];
        $order_details['item_id'] = rand(111111111, 999999999);
        $order_details['order_id'] = $order_id;
        $order_details['product_id'] = $product['product_id'];
        $order_details['price'] = $product['price'];
        $order_details['product_code'] = "AA$order_id" . $product['price'] . $product['product_id'];
        $order_details['amount'] = $product['amount'];
        $product['is_edp'] = "N";
        $order_details['extra'] = serialize($product);


        (db_query("INSERT INTO ?:order_details ?e", $order_details));;
    }


    return $order_id;

}

function createFargoOrder($order, $user_address)
{
    $box_width = 0;
    $box_height = 0;
    $box_length = 0;

    $product_ids = [];
    $total_weight = 0;
    $total_amount = 0;

    foreach ($user_address['shipping_params'] as $product_id => $product) {
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

    $category_name = null;
    $user = db_get_row('select * from ?:users where user_id=?i', $order['user_id']);
    $category_names = db_get_array('select category.category as name from ?:products_categories as product 
                            inner join ?:category_descriptions as category on product.category_id = category.category_id and product.link_type="M"  and category.lang_code = ?s 
                            where product.product_id IN (?a)', CART_LANGUAGE, $product_ids);

    foreach ($category_names as $name) {
        $category_name .= ' ' . $name['name'];
    }

    $product_shipping_data = $user_address['address'];

    $neighborhood = [
        "name" => $product_shipping_data['neighborhood']
    ];

    $fargo_data = [
        "sender_data" => fn_fargo_uz_sender_recipient_data(
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
        "recipient_data" => fn_fargo_uz_sender_recipient_data(
            "residential",
            $user['lastname'] . ' ' . $user['firstname'],
            $product_shipping_data['city_id'],
            234,
            '+' . $user['phone'],
            null,
            $product_shipping_data['apartment'],
            $product_shipping_data['building'],
            $product_shipping_data['street'],
            null,
            $neighborhood

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

    if (!isset($fargo_order_res->status) || $fargo_order_res->status != "success") {
        $errors_data = [
            'error_test' => $fargo_order_res->message
        ];
        return showErrors("service_error", $errors_data);
    } else {
        $data_order = [
            'fargo_order_id' => $fargo_order_res->data->order_number,
            'fargo_contract_id' => $fargo_order_res->data->id,
            'paymart_contract_id' => $order['p_contract_id']
        ];
        db_query('INSERT INTO ?:fargo_orders ?e', $data_order);
    }

    $fargo_label_res = php_curl(
        FARGO_URL . '/v1/customer/orders/airwaybill_mini?ids=&order_numbers=' . $fargo_order_res->data->order_number,
        [],
        'GET',
        $fargo_auth_res->data->id_token
    );

    $data_label = [
        "fargo_contract_label" => $fargo_label_res->data->value
    ];

    db_query('UPDATE ?:fargo_orders SET ?u WHERE fargo_order_id = ?i', $data_label, $fargo_order_res->data->order_number);

    $fargo_response = [
        "id" => $fargo_order_res->data->id,
        "order_number" => $fargo_order_res->data->order_number,
    ];

    return showErrors('success', $fargo_response, 'success');
}


function fargoAuth()
{
    $fargo_data_auth = [
        "username" => FARGO_USERNAME,
        "password" => FARGO_PASSWORD
    ];
    $url = FARGO_URL . "/v1/customer/authenticate";
    $fargo_auth_res = php_curl($url, $fargo_data_auth, 'POST', '');
    return $fargo_auth_res->data->id_token;
}

function createCurlFile($file)
{
    return new CURLFILE(
        str_replace('\\', '/', $file['tmp_name']),
        $file['type'],
        $file['name'],
    );
}

function getProductInfo($product_id, $fields): array
{
    $data = [];
    $field_string = implode(',', $fields);
    $data['product'] = db_get_row("SELECT $field_string FROM ?:products WHERE product_id =?i", $product_id);
    $data['price'] = db_get_row("SELECT * FROM ?:product_prices WHERE product_id =?i", $product_id);
    $name = db_get_field("SELECT product FROM ?:product_descriptions WHERE product_id =?i", $product_id);
    $product_feature_values = db_get_fields("SELECT pfvd.variant FROM ?:product_features_values AS pfv
        INNER JOIN ?:product_feature_variant_descriptions AS pfvd 
        ON pfvd.variant_id = pfv.variant_id AND pfvd.lang_code = 'ru'
        WHERE pfv.product_id=?i AND pfv.lang_code=?s AND pfv.variant_id!=0 ", $product_id, CART_LANGUAGE);
    if (!empty($product_feature_values)) {
        $name .= " (" . implode(',', $product_feature_values) . " )";
    }
    $data['descriptions'] = $name;

    return $data;
}

function calculatePriceProduct($product, $type, $modifier): int
{
    $price = $product['price']['price'];
    if ($modifier != 0) {
        if ($type === 'by_percentage') {
            $price -= $price * $modifier / 100;
        } else {
            $price -= $modifier;
        }
    }

    return $price;
}

function test()
{
    static $var = 0;
    $var++;
    return $var;
}

function dateDifference($timestamp, $added_day)
{
    $delivered_time = date("d-m-Y H:i:s", strtotime(date('d-m-Y H:i:s', $timestamp) . " + $added_day day"));
    $current_time = date('d-m-Y H:i:s', TIME);

    $delivered_date = date_create($delivered_time);
    $current_date = date_create($current_time);
    $diff = date_diff($current_date, $delivered_date);

    $day = $diff->format('%r%d');
    $hours = $diff->format('%r%H');
    $minutes = $diff->format('%r%I');
    return [
        $day,
        $hours,
        $minutes
    ];
}





