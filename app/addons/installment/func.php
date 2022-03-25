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
        $curl_options[CURLOPT_URL] = PAYMART_URL . $url;
    }
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_ENCODING] = '';
    $curl_options[CURLOPT_MAXREDIRS] = 10;
    $curl_options[CURLOPT_TIMEOUT] = 0;
    $curl_options[CURLOPT_FOLLOWLOCATION] = true;
    $curl_options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
    $curl_options[CURLOPT_CUSTOMREQUEST] = "$method";
    if ($header_type == 1) {
        $curl_options[CURLOPT_HTTPHEADER] = [];
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


function createOrder($product, $quantity, $user, $params, $contract_id)
{

    $ip = fn_get_ip();
    $order['ip_address'] = fn_ip_to_db($ip['host']);
    $order['timestamp'] = TIME;
    $order['updated_at'] = $order['timestamp'];
    $order['lang_code'] = isset($user_lang) && !empty($user_lang) ? $user_lang : CART_LANGUAGE;
    $order['status'] = STATUS_INCOMPLETED_ORDER;
    $order['is_parent_order'] = 'N';
    $order['company_id'] = $product['company_id'];

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

    $order_details['order_id'] = $order_id;
    $order_details['item_id '] = TIME;
    $order_details['product_id'] = $product['product_id'];
    $order_details['price'] = $product['price'];
    $order_details['product_code'] = $product['product_code'];
    $order_details['amount'] = $quantity;
    $order_details['extra'] = serialize($product);

    db_query("INSERT INTO ?:order_details ?e", $order_details);

    return true;

}

function createFargoOrder($contract_id)
{

    $order = db_get_row("select * from ?:orders as order_data 
                         INNER JOIN ?:order_details as order_detail ON order_data.order_id = order_detail.order_id   
                         where order_data.p_contract_id=?i", $contract_id);

    $product_info = db_get_row('SELECT *,product_description.product as product_name FROM ?:products as product 
        INNER JOIN ?:companies as company ON product.company_id = company.company_id 
        INNER JOIN ?:product_prices as product_price ON product.product_id = product_price.product_id 
        INNER JOIN ?:product_descriptions as product_description ON product.product_id = product_description.product_id 
        WHERE product.product_id = ?i ', $order['product_id']);
    $user = db_get_row('select * from ?:users where user_id=?i', $order['user_id']);
    $product_shipping_data = unserialize($order['fargo_address']);

    $fargo_data = [
        "sender_data" => fn_fargo_uz_sender_recipient_data(
            "residential",
            $product_info['company'],
            $product_shipping_data['city_id'],
            234,
            '+' . $product_info['phone'],
            null,
            $product_info['address']
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
            $product_shipping_data['street']
        ),
        "dimensions" => fn_fargo_uz_dimensions(
            $product_info['weight'],
            $product_shipping_data['shipping_params']['box_width'],
            $product_shipping_data['shipping_params']['box_height'],
            $product_shipping_data['shipping_params']['box_length'],
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
        "payer" => "sender"
    ];

    $fargo_data_auth = [
        "username" => FARGO_USERNAME,
        "password" => FARGO_PASSWORD
    ];
    $url = FARGO_URL . "/v1/customer/authenticate";
    $fargo_auth_res = php_curl($url, $fargo_data_auth, 'POST', '');


    $url = FARGO_URL . '/v2/customer/order';
    $fargo_order_res = php_curl($url, $fargo_data, 'POST', $fargo_auth_res->data->id_token);

    if ($fargo_order_res->status != "success") {
        $errors_data = [
            'error_test' => $fargo_order_res->message
        ];
        $errors = showErrors("service_error", $errors_data, "error");
        Registry::get('ajax')->assign('result', $errors);
        exit();
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

    return true;
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



