<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

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

        Registry::get('ajax')->assign('result', $track_order);
        exit();
    }


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
        $url = PAYMART_URL . '/buyer/verify/modify';
        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_first_page' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_first_page']['tmp_name'])),
                    'step' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_with_address' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_with_address']['tmp_name'])),
                    'step' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_selfie' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_selfie']['tmp_name'])),
                    'step' => '2',
                    'type' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

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
        $url = PAYMART_URL . '/buyer/verify/modify';
        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_first_page' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_first_page']['tmp_name'])),
                    'step' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_first_page' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_second_page']['tmp_name'])),
                    'step' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);


            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_with_address' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_with_address']['tmp_name'])),
                    'step' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('passport_selfie' =>
                    new CURLFILE(str_replace('\\', '/', $_FILES['passport_selfie']['tmp_name'])),
                    'step' => '2',
                    'type' => '2'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $user['api_key']
                ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);

            if ($response->status == "success") {
                $user_info['i_step'] = $response->data->status;
                db_query('UPDATE ?:users SET ?u WHERE p_user_id = ?i', $user_info, $response->data->id);

            }
//            $passport_with_address['passport_with_address'] = $_FILES['passport_with_address'];
//            $passport_with_address['step'] = 2;
//            $response = php_curl('/buyer/verify/modify', $passport_with_address, 'POST', $user['api_key']);
//
//            $passport_selfie['passport_selfie'] = $_FILES['passport_selfie'];
//            $passport_selfie['step'] = 2;
//            $passport_selfie['type'] = 2;
//            $response = php_curl('/buyer/verify/modify', $passport_selfie, 'POST', $user['api_key']);

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

        $product_info = db_get_row('SELECT *,product_description.product as product_name FROM ?:products as product 
        INNER JOIN ?:companies as company ON product.company_id = company.company_id 
        INNER JOIN ?:product_prices as product_price ON product.product_id = product_price.product_id 
        INNER JOIN ?:product_descriptions as product_description ON product.product_id = product_description.product_id 
        WHERE product.product_id = ?i ', Tygh::$app['session']['product_info']['product_id']);

        $user = db_get_row('select * from ?:users where user_id=?i', $auth['user_id']);


        $product_feature_values = db_get_array("
        select pfvd.variant from ?:product_features_values as pfv
        INNER JOIN ?:product_feature_variant_descriptions as pfvd ON pfvd.variant_id = pfv.variant_id and
         pfvd.lang_code = 'ru'
        where pfv.product_id=?i and pfv.lang_code=?s and pfv.variant_id!=0",
            $product_info['product_id'], CART_LANGUAGE);

        foreach ($product_feature_values as $value) {
            if (!empty($value['variant'])) {
                $product_text .= $value['variant'] . ' ';
            }

        }
        $datas['product_text'] = $product_text;

        $data = [
            'products' => [
                [
                    "name" => $product_info['product_name'] . '; ' . $product_text,
                    "amount" => (int)Tygh::$app['session']['product_info']['product_qty'],
                    "price" => (int)$product_info['price']
                ]
            ],
            "limit" => $_REQUEST['limit'],
            "buyer_phone" => $user['phone'],
            "online" => 1
        ];

        $response = php_curl('/buyers/credit/add', $data, 'POST', $product_info['p_c_token']);
        if (isset($response->result) && $response->result->status == 0) {

            $errors = showErrors("user_has_indebtedness", [], "error");
            Registry::get('ajax')->assign('result', $response);
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

        $user = db_get_row('select * from ?:users 
                            where user_id=?i', $auth['user_id']);

        $product_id = Tygh::$app['session']['product_info']['product_id'];
        $product_amount = (int)Tygh::$app['session']['product_info']['product_qty'];

        $product_info = db_get_row('SELECT *,product_description.product as product_name FROM ?:products as product 
        INNER JOIN ?:companies as company ON product.company_id = company.company_id 
        INNER JOIN ?:product_prices as product_price ON product.product_id = product_price.product_id 
        INNER JOIN ?:product_descriptions as product_description ON product.product_id = product_description.product_id 
        WHERE product.product_id = ?i ', $product_id);

        $product_quantity = (int)$product_info['amount'] - $product_amount;

        if ($product_quantity < 0) {
            $errors = showErrors('product_is_not_exist');
            Registry::get('ajax')->assign('result', $errors);
            exit();
        }

        $data = [
            'amount' => $product_quantity
        ];

        $data_contract = [
            "contract_id" => $_REQUEST['contract_id'],
            "code" => $_REQUEST['code'],
            "phone" => $user['phone']
        ];

        $response = php_curl('/buyers/check-user-sms', $data_contract, 'POST', $user['api_key']);


        if ($response->result->status == 1) {


            db_query('UPDATE ?:products SET ?u WHERE product_id = ?i', $data, $product_id);

            $params["apartment"] = $_REQUEST['apartment'];
            $params["building"] = $_REQUEST['building'];
            $params["street"] = $_REQUEST['street'];

            $neighborhood = [];
            if ((int)$_REQUEST['region'] == 228171787) {
                $address = db_get_row("select * from ?:fargo_countries where  city_id=?i ", $_REQUEST['city']);

                $params["city_id"] = 228171787;
                $params["neighborhood"] = $address['city_name'];


            } else {
                $params["city_id"] = (int)$_REQUEST['region'];
                $params["neighborhood"] = $_REQUEST['city'];
            }
            $product_shipping_data = unserialize($product_info['shipping_params']);
            $params["shipping_params"] = $product_shipping_data;

            $data = createOrder($product_info, $product_amount, $user, $params, $_REQUEST['contract_id']);
            unset(Tygh::$app['session']['product_info']);
            $errors = showErrors('contract_create_successfully', [], "success");
            Registry::get('ajax')->assign('result', $errors);
            exit();

        } else {

            $errors = showErrors('wrong_confirmation_code', [], "error");
            Registry::get('ajax')->assign('result', $errors);
            exit();

        }
    }
}

if ($mode == 'get_qty') {
    $qty = $_REQUEST['qty'];
    $product_id = $_REQUEST['product_id'];
    $period = $_REQUEST['period'];

    Tygh::$app['session']['product_info'] = array(
        'product_id' => $product_id,
        'product_qty' => $qty,
        'period' => $period
    );
//    fn_set_session_data('product_id', $product_id, 7);
//    fn_set_session_data('product_id', $qty, 7);

    Registry::get('ajax')->assign('result', [
        'status' => 'success',
        'redirect_to' => 'installment_product.index'
    ]);
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
    }
}

if ($mode == "contract-create") {
    $product_text = "";
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {

        if (!isset(Tygh::$app['session']['product_info'])) {
            return array(CONTROLLER_STATUS_REDIRECT, fn_url());
        }
        $product_id = Tygh::$app['session']['product_info']['product_id'];
        $product_quantity = Tygh::$app['session']['product_info']['product_qty'];
        $period = Tygh::$app['session']['product_info']['period'];

        $datas = db_get_row('SELECT * FROM ?:products as product 
                             INNER JOIN ?:companies as company ON product.company_id = company.company_id 
                             WHERE product.product_id = ?i ', $product_id);


        $product_feature_values = db_get_array("
        select pfvd.variant from ?:product_features_values as pfv
        INNER JOIN ?:product_feature_variant_descriptions as pfvd ON pfvd.variant_id = pfv.variant_id and
         pfvd.lang_code = 'ru'
        where pfv.product_id=?i and pfv.lang_code=?s and pfv.variant_id!=0",
            $datas['product_id'], CART_LANGUAGE);

        $product_text = '';
        foreach ($product_feature_values as $value) {
            if (!empty($value['variant'])) {
                $product_text .= $value['variant'] . ' ';
            }

        }
        $datas['product_text'] = $product_text;

        $datas['product_descriptions'] = db_get_row('SELECT * FROM ?:product_descriptions WHERE product_id = ?i', $datas['product_id']);

        $datas['product_price'] = db_get_row('SELECT * FROM ?:product_prices WHERE product_id = ?i', $datas['product_id']);
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
        $data = [
            "type" => "credit",
            "period" => $period,
            "products" => [
                $datas["p_c_id"] => [
                    [
                        "price" => $datas['product_price']['price'],
                        "amount" => $product_quantity,
                        "name" => $datas['product_descriptions']['product'] . "; " . $product_text
                    ]
                ]
            ],
            "partner_id" => $datas["p_c_id"],
            "user_id" => $user['p_user_id']

        ];

        $response = php_curl('/order/calculate', $data, 'POST', $datas['p_c_token']);

        $id = (int)$datas["p_c_id"];

        $items = $response->data->orders->$id->price;

        $city = db_get_array('select * from ?:fargo_countries where parent_city_id=?i ORDER BY city_name ASC', 0);

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
        switch ($period) {
            case 6:
            case 9:
            case 12:
                $periods[$period]['selected'] = 'selected';
                break;
        }
//        fn_print_die($selected);

        Tygh::$app['view']->assign('city', $city);
        Tygh::$app['view']->assign('total', $items->total);
        Tygh::$app['view']->assign('origin', $items->origin);
        Tygh::$app['view']->assign('month', $items->month);
        Tygh::$app['view']->assign('periods', $periods);
        Tygh::$app['view']->assign('deposit', $items->deposit);
        Tygh::$app['view']->assign('product_info', $datas);
        Tygh::$app['view']->assign('customer_support_phone', CUSTOMER_SUPPORT_PHONE);

        Tygh::$app['view']->assign('product_quantity', $product_quantity);
        Tygh::$app['view']->assign('user', $user);
        if ((int)$user['i_limit'] < $product_quantity * (int)$datas['product_price']['price']) {
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

        $result = $response;
        $payed_list = [];
        $payed_list_group_by_contract_id = [];

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
        };

        $city = db_get_row('select * from ?:fargo_countries where parent_city_id=?i', 0);
        Tygh::$app['view']->assign('city', $city);
        Tygh::$app['view']->assign('contracts', array_reverse($result->contracts));
        Tygh::$app['view']->assign('group_by', $payed_list_group_by_contract_id);
        Tygh::$app['view']->assign('user_api_token', $user['api_key']);
        Tygh::$app['view']->assign('user_phone', $user['phone']);

    }
}


