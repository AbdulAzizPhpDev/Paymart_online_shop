<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'set_card') {

        $data = [
            "card" => $_REQUEST['card'],
            "exp" => $_REQUEST['exp'],
        ];

        fn_set_session_data('card_info', $data);
        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            $response = php_curl('/buyer/send-sms-code-uz', $data, 'POST', $user['api_key']);

            Registry::get('ajax')->assign('result', $response);
            exit();
        }
        Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
        exit();
    }
    if ($mode == "confirm_card") {

        if ($auth['user_id']) {
            if (empty(fn_get_session_data('card_info'))) {
                Registry::get('ajax')->assign('result', showErrors('card_info_not_set'));
                exit();
            }
            $data['card_valid_date'] = fn_get_session_data('card_info')['exp'];
            $data['card_number'] = fn_get_session_data('card_info')['card'];
            $data['code'] = $_REQUEST['code'];
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            $response = php_curl('/buyer/check-sms-code-uz', $data, 'POST', $user['api_key']);
            Registry::get('ajax')->assign('result', $response);
            exit();
        }
        Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
        exit();
    }
    if ($mode == 'set_passport') {
        $response = null;
        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            foreach ($_FILES as $key => $image) {
                $data = [];
                if ($key == "passport_selfie") {

                    $data = [
                        $key => new CURLFILE(
                            str_replace('\\', '/', $image['tmp_name']),
                            mime_content_type($image['tmp_name']),
                            $image['name']
                        ),
                        "step" => 2,
                        "type" => 2
                    ];

                } else {
                    $data = [
                        $key => new CURLFILE(
                            str_replace('\\', '/', $image['tmp_name']),
                            mime_content_type($image['tmp_name']),
                            $image['name']
                        ),
                        "step" => 2
                    ];
                }
                $response = php_curl('/buyer/verify/modify', $data, 'POST', $user['api_key'], 1);
            }
            if ($response->status == "success") {
                $user_info['i_step'] = $response->data->status;
                db_query('UPDATE ?:users SET ?u WHERE p_user_id = ?i', $user_info, $response->data->id);
            }
            Registry::get('ajax')->assign('result', $response);
            exit();
        }
        Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
        exit();
    }
    if ($mode == 'set_passport_id') {
        $response = null;
        if ($auth['user_id']) {

            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            $file = $_FILES['passport_first_page'];
            $data = [
                "passport_first_page" => new CURLFILE(
                    str_replace('\\', '/', $file['tmp_name']),
                    $file['type'],
                    $file['name']
                ),
                "step" => 2,
            ];
            $response = php_curl('/buyer/verify/modify', $data, 'POST', $user['api_key'], 1);

            $file = $_FILES['passport_second_page'];
            $data = [
                "passport_first_page" => new CURLFILE(
                    str_replace('\\', '/', $file['tmp_name']),
                    $file['type'],
                    $file['name']
                ),
                "step" => 2,
            ];
            $response = php_curl('/buyer/verify/modify', $data, 'POST', $user['api_key'], 1);

            $file = $_FILES['passport_with_address'];
            $data = [
                "passport_with_address" => new CURLFILE(
                    str_replace('\\', '/', $file['tmp_name']),
                    $file['type'],
                    $file['name']
                ),
                "step" => 2,
            ];
            $response = php_curl('/buyer/verify/modify', $data, 'POST', $user['api_key'], 1);

            $file = $_FILES['passport_selfie'];
            $data = [
                "passport_selfie" => new CURLFILE(
                    str_replace('\\', '/', $file['tmp_name']),
                    $file['type'],
                    $file['name']
                ),
                "step" => 2,
                "type" => 2
            ];
            $response = php_curl('/buyer/verify/modify', $data, 'POST', $user['api_key'], 1);
            if ($response->status == "success") {
                $user_info['i_step'] = $response->data->status;
                db_query('UPDATE ?:users SET ?u WHERE p_user_id = ?i', $user_info, $response->data->id);

            }

            Registry::get('ajax')->assign('result', $response);
            exit();
        }
        Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
        exit();

    }
    if ($mode == 'set_guarantee') {
        if ($auth['user_id']) {
            $response = null;
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            foreach ($_REQUEST['guarantees'] as $item) {
                $data = [
                    'name' => $item['name'],
                    'phone' => $item['phone'],
                    'buyer_id' => $user['p_user_id']
                ];
                $response = php_curl('/buyer/add-guarant', $data, 'POST', $user['api_key']);

            }
            if ($response->status == "success") {
                $itme['i_step'] = 2;
                db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $itme, $user['user_id']);
            }
            Registry::get('ajax')->assign('result', $response);

            exit();
        }
        Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
        exit();
    }
    if ($mode == 'set_contracts') {
        if (!$auth['user_id']) {
            Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
            exit();
        }
        $user = db_get_row('select * from ?:users where user_id=?i', $auth['user_id']);
        $products = [];
        $company = Tygh::$app['session']['installment_data']['company'];
        $products_data = Tygh::$app['session']['installment_data']['products'];
        foreach ($products_data as $key => $product) {
            $data = [
                "price" => $product['price'],
                "amount" => $product['amount'],
                "name" => $product['name']
            ];
            $products[] = $data;
        }
        $data = [
            'products' => $products,
            "limit" => $_REQUEST['limit'],
            "buyer_phone" => $user['phone'],
            "online" => 1
        ];

        $response = php_curl('/buyers/credit/add', $data, 'POST', $company['p_c_token']);
        if (isset($response->result) && ($response->result->status == 0 || $response->status == "error")) {
            $errors = showErrors("user_has_indebtedness", [], "error");
            Registry::get('ajax')->assign('result', $errors);
            exit();
        } elseif ($response->status == 1) {

            Registry::get('ajax')->assign('result', $response);
            exit();
        } else {
            $errors = showErrors("error", [], "error");
            Registry::get('ajax')->assign('result', $response);
            exit();
        }
    }


    if ($mode == "set_confirm_contract") {
        if (!$auth['user_id']) {
            Registry::get('ajax')->assign('result', showErrors('user_not_authorized'));
            exit();
        }
        $user = db_get_row('select * from ?:users where user_id=?i', $auth['user_id']);
        $company = Tygh::$app['session']['installment_data']['company'];
        $products_data = Tygh::$app['session']['installment_data']['products'];
        $total_amount = Tygh::$app['session']['installment_data']['total_quantity'];
        $total_price = Tygh::$app['session']['installment_data']['total_price'];
        $check_quantity = false;
        $params = [];
        $data_contract = [
            "contract_id" => $_REQUEST['contract_id'],
            "code" => $_REQUEST['code'],
            "phone" => $user['phone']
        ];
        $response = php_curl('/buyers/check-user-sms', $data_contract, 'POST', $user['api_key']);
        if ($response->result->status == 1) {
            foreach ($products_data as $product) {
                $product_data = db_get_row('SELECT amount,shipping_params FROM ?:products WHERE product_id = ?i', $product['product_id']);
                $product_quantity = $product_data['amount'] - $product['amount'];
                $data = [
                    'amount' => $product_quantity
                ];
                $params["shipping_params"][$product['product_id']] = unserialize($product_data['shipping_params']);
                db_query('UPDATE ?:products SET ?u WHERE product_id = ?i', $data, $product['product_id']);
            }


//        if ($product_quantity < 0) {
//            $errors = showErrors('product_is_not_exist');
//            Registry::get('ajax')->assign('result', $errors);
//            exit();
//        }

            if ($_REQUEST['address_type'] === 'shipping') {
                $params['address']["apartment"] = $_REQUEST['apartment'];
                $params['address']["building"] = $_REQUEST['building'];
                $params['address']["street"] = $_REQUEST['street'];
                $params['address']['address_type'] = $_REQUEST['address_type'];
                $neighborhood = [];
                if ((int)$_REQUEST['region'] == 228171787) {
                    $address = db_get_row("select * from ?:fargo_countries where  city_id=?i ", $_REQUEST['city']);

                    $params['address']["city_id"] = 228171787;
                    $params['address']["neighborhood"] = $address['city_name'];


                } else {
                    $params['address']["city_id"] = (int)$_REQUEST['region'];
                    $params['address']["neighborhood"] = $_REQUEST['city'];
                }

            } else {
                $params['address']['address_type'] = $_REQUEST['address_type'];
            }
            $data = createOrder($products_data, $user, $company, $params, $_REQUEST['contract_id'], $total_price, $total_amount);
            unset(Tygh::$app['session']['product_info']);
            unset(Tygh::$app['session']['installment_data']);

            $errors = showErrors('contract_create_successfully', [], "success");
            Registry::get('ajax')->assign('result', $errors);
            exit();

        } else {

            $errors = showErrors('wrong_confirmation_code');
            Registry::get('ajax')->assign('result', $errors);
            exit();

        }
    }

    if ($mode == 'bundle_products') {

        if (isset($_REQUEST['bundle_id']) && !empty($_REQUEST['bundle_id'])) {
            Tygh::$app['session']['product_info'] = array(
                "type" => "multiple",
                "bundle_id" => $_REQUEST['bundle_id'],
                "total_price" => $_REQUEST['total_price'],

            );
            $errors = showErrors('success', [], "success");
            Registry::get('ajax')->assign('result', $errors);
            exit();
        }
        $errors = showErrors('sever_error', [], "error");
        Registry::get('ajax')->assign('result', $errors);
        exit();
    }
}

if ($mode == 'get_qty') {

    $product_id = $_REQUEST['product_id'];
    $qty = $_REQUEST['qty'] ?? 1;
    $product = db_get_row("select * from ?:products where product_id = ?i", $product_id);

    if (($product['amount'] - $qty) < 0) {
        Registry::get('ajax')->assign('result', showErrors('product_not_exit'));
        exit();
    }

    $period = $_REQUEST['period'];
    $product_name = $_REQUEST['variation_name'];
    $company_id = $_REQUEST['company_id'];

    Tygh::$app['session']['product_info'] = array(
        'product_id' => $product_id,
        'product_qty' => $qty,
        'period' => $period,
        'product_name' => $product_name,
        'company_id' => $company_id,
        'type' => 'single',
    );

    $data = [
        'redirect_to' => 'installment_product.index'
    ];

    Registry::get('ajax')->assign('result', showErrors('success', $data, 'success'));
    exit();
}

if ($mode == 'index') {

    if ($auth['user_id']) {
        checkUserFromPaymart($auth['user_id']);
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . checkInstallmentStep($auth['user_id']));
        }

    }

}

if ($mode == "card-add") {
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        checkUserFromPaymart($auth['user_id']);
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }
    }
}

if ($mode == "type-passport") {
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        checkUserFromPaymart($auth['user_id']);
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }
    }
}

if ($mode == 'upload-passport') {

    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    }
//    else {
//        checkUserFromPaymart($auth['user_id']);
//        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
//        $user_step = checkInstallmentStep($auth['user_id']);
//        if ($mode_type !== $user_step) {
//            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
//        }
//    }


}

if ($mode == 'upload-passport-id') {
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    }

}

if ($mode == "guarant") {


    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        checkUserFromPaymart($auth['user_id']);
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }
    }
}

if ($mode == "await") {

    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        checkUserFromPaymart($auth['user_id']);
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }

        $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
        Tygh::$app['view']->assign('user_api_token', $user['api_key']);
        Tygh::$app['view']->assign('api_base_url', PAYMART_CABINET_API_URL);

    }
}

if ($mode == "contract-create") {
    $user = db_get_row('SELECT * FROM ?:users WHERE user_id = ?i', $auth['user_id']);
    if (empty($user['firstname']) && empty($user['lastname'])) {
        $response = php_curl('/buyer/detail', [], 'GET', $user['api_key']);
        if ($response->status == "success") {
            $user_data['firstname'] = $response->data->name;
            $user_data['lastname'] = $response->data->surname;
            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_data, $auth['user_id']);
            $user = db_get_row('SELECT * FROM ?:users WHERE user_id = ?i', $auth['user_id']);
        }
    }
    checkUserFromPaymart($auth['user_id']);
    list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
    $user_step = checkInstallmentStep($auth['user_id']);

    if ($mode_type !== $user_step) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
    }


    $period = 12;
    $product_text = "";
    $calculator_data = [];
    $calculator_res_data = null;
    $session_data = null;
    $products = [];
    $company = null;
    $total_products = 0;
    $total_price = 0;

    $field = [
        'product_id',
        'company_id'
    ];
    $periods = [
        6 => [
            'name' => 6 . ' ' . __('ab__dotd.countdown.simple.months'),
            'selected' => null
        ],
        9 => [
            'name' => 9 . ' ' . __('ab__dotd.countdown.simple.months'),
            'selected' => null
        ],
        12 => [
            'name' => 12 . ' ' . __('ab__dotd.countdown.simple.months'),
            'selected' => null
        ],
    ];


    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        if (!isset(Tygh::$app['session']['product_info'])) {
            return array(CONTROLLER_STATUS_REDIRECT, fn_url());
        }
        $session_data = Tygh::$app['session']['product_info'];
        $period = $session_data['period'] ?? 12;
        $periods[$period]['selected'] = 'selected';
        if ($session_data['type'] == "single") {
            if (!empty($session_data['company_id'])) {
                $company = db_get_row('SELECT * FROM ?:companies WHERE company_id = ?i ', $session_data['company_id']);
            } else {
                $company = db_get_row('SELECT * FROM ?:products as product
                             INNER JOIN ?:companies as company ON product.company_id = company.company_id
                             WHERE product.product_id = ?i ', $session_data['product_id']);
            }

            $get_product = getProductInfo($session_data['product_id'], $field);
            $total_products = $session_data['product_qty'];
            $total_price = $get_product['price']['price'] * $total_products;
            if (!empty($session_data['product_name'])) {
                $product_text = $session_data['product_name'];
            } else {
                $product_text = Tygh::$app['session']['test_xxx']['variation_name'] ?? $get_product['descriptions'];
            }

            $calculator_data = [
                $company['p_c_id'] => []
            ];

            $products[] = [
                "product_id" => $get_product['product']['product_id'],
                "name" => $product_text,
                "total_price" => $get_product['price']['price'] * $session_data['product_qty'],
                "price" => $get_product['price']['price'],
                "amount" => $session_data['product_qty'],
            ];

            Tygh::$app['session']['installment_data']['products'] = $products;
            Tygh::$app['session']['installment_data']['company'] = $company;
            Tygh::$app['session']['installment_data']['total_price'] = $total_price;
            Tygh::$app['session']['installment_data']['total_quantity'] = $total_products;

            $data = [
                "price" => $get_product['price']['price'],
                "amount" => $session_data['product_qty'],
                "name" => $product_text
            ];
            $total_products = $data['amount'];
            $total_price = $data['price'];

            $calculator_data[$company['p_c_id']][] = $data;

        } elseif ($session_data['type'] == "multiple") {
            $total_price = $session_data['total_price'];
            $bundle_data = db_get_row('SELECT * FROM ?:product_bundles WHERE bundle_id =?i', $session_data['bundle_id']);

            $bundle_products = unserialize($bundle_data['products']);
            $company = db_get_row("SELECT * FROM ?:companies WHERE company_id =?i", $bundle_data['company_id']);
            $calculator_data = [
                $company['p_c_id'] => []
            ];
            foreach ($bundle_products as $key => $product) {
                $total_products += $product['amount'];
                $get_product = getProductInfo($product['product_id'], $field);
                $price = calculatePriceProduct($get_product, $product['modifier_type'], $product['modifier']);
                $products[] = [
                    "product_id" => $get_product['product']['product_id'],
                    "name" => $get_product['descriptions'],
                    "total_price" => $price * $product['amount'],
                    "price" => $price,
                    "amount" => $product['amount'],
                ];
                $data = [
                    "price" => $price,
                    "amount" => $product['amount'],
                    "name" => $get_product['descriptions']
                ];
                $calculator_data[$company['p_c_id']][] = $data;
            }

            Tygh::$app['session']['installment_data']['products'] = $products;
            Tygh::$app['session']['installment_data']['company'] = $company;
            Tygh::$app['session']['installment_data']['total_price'] = $total_price;
            Tygh::$app['session']['installment_data']['total_quantity'] = $total_products;

        } else {
            return array(CONTROLLER_STATUS_REDIRECT, '/');
        }

        $data = [
            "type" => "credit",
            "period" => $period,
            "products" => $calculator_data,
            "partner_id" => $company["p_c_id"],
            "user_id" => $user['p_user_id']

        ];

        $company_p_i = db_get_field('select parent_city_id from ?:fargo_countries where city_id=?i ', $company['city']);


        $city = db_get_array('SELECT distinct(city_name),country.id as id, days FROM ?:fargo_countries as country  
                              inner join ?:fargo_deliver_time as d_time 
                              on country.id = d_time.to  and d_time.from = ?i
                              WHERE country.parent_city_id=?i ORDER BY country.city_name ASC', $company_p_i, 0);


        $response = php_curl('/order/calculate', $data, 'POST', $company['p_c_token']);
        $calculator_res_data = $response->data->price;
        $redirect_url = fn_url('/');
        $city_name = db_get_field('SELECT city_name FROM ?:fargo_countries WHERE city_id = ?i', $company['city']);

        $company['full_address'] = $city_name . ' ' . __('city') . ' ' . $company['state'] . ' ' . $company['address'];

        Tygh::$app['view']->assign('city', $city);
        Tygh::$app['view']->assign('redirect_url', $redirect_url);
        Tygh::$app['view']->assign('api_base_url', PAYMART_CABINET_API_URL);
        Tygh::$app['view']->assign('company', $company);
        Tygh::$app['view']->assign('calculator', $calculator_res_data);
        Tygh::$app['view']->assign('periods', $periods);
        Tygh::$app['view']->assign('products', $products);
        Tygh::$app['view']->assign('total_price', $total_price);
        Tygh::$app['view']->assign('total_products', $total_products);
        Tygh::$app['view']->assign('customer_support_phone', CUSTOMER_SUPPORT_PHONE);
        Tygh::$app['view']->assign('user', $user);

        if ((int)$user['i_limit'] < $total_price) {
            Tygh::$app['view']->assign('notifier', true);
        } else {
            Tygh::$app['view']->assign('notifier', false);
        }
    }
}

if ($mode == 'profile-contracts') {
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {

        $user = db_get_row('SELECT * FROM ?:users WHERE user_id = ?i', $auth['user_id']);
        $response = php_curl('/buyer/contracts', [], 'GET', $user['api_key']);

        if ($response->status == 'error') {
            Tygh::$app['view']->assign('contracts', $contract['errors'] = showErrors($response->response->message));
            return false;
        }

        $result = $response;
        $payed_list = [];
        $payed_list_group_by_contract_id = [];
        $contracts = null;

        foreach ($result->contracts as $key => $contract) {
            $result->contracts[$key]->status = InstallmentVar::Status[$contract->status];
            foreach ($contract->schedule_list as $list) {
                if ($list->status == 1) {
                    $payed_list[$list->contract_id][] = $list;
                }
            }
        }

        foreach ($payed_list as $item => $value) {
            $payed_list_group_by_contract_id[$item] = count($value);
        }

        foreach ($result->contracts as $item) {

            if ($item->status == 'active') {
                $check = db_get_row("select * from ?:returned_products where contract_id = ?i ", $item->order_id);
                if ($check) {
                    $item->descriptions['user'] = db_get_field(" select `description` from ?:returned_product_descriptions 
                                                               where `from` = ?i and `to`=?i", $auth['user_id'], $check['vendor_id']);

                    $item->descriptions['vendor'] = db_get_field(" select `description` from ?:returned_product_descriptions 
                                                               where `from` = ?i and `to`=?i", $check['vendor_id'], $auth['user_id']);

                    $item->return_status = true;

                } else {

                    $item->return_status = false;

                }

                $contracts[] = $item;
            }
        }

        Tygh::$app['view']->assign('contracts', $contracts);
        Tygh::$app['view']->assign('group_by', $payed_list_group_by_contract_id);
        Tygh::$app['view']->assign('user_api_token', $user['api_key']);
        Tygh::$app['view']->assign('user_phone', $user['phone']);

    }
}


