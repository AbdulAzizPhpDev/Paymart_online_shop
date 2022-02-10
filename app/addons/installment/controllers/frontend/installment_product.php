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

use Tygh\Registry;
use Tygh\Tools\Url;

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
        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
    if ($mode == 'set_passport_id') {

        if ($auth['user_id']) {
            $user = db_get_row('select * from ?:users where user_id = ?s', $auth['user_id']);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
                CURLOPT_URL => 'https://dev.paymart.uz/api/v1/buyer/verify/modify',
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
    if ($mode == 'check_status') {

    }


}

if ($mode == 'get_qty') {
    $qty = $_REQUEST['qty'];
    $product_id = $_REQUEST['product_id'];

    fn_set_session_data('product_id', $product_id, 7);
    fn_set_session_data('product_qty', $qty, 7);

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
    } else {
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }
    }

}

if ($mode == "guarant") {
    if (!$auth['user_id']) {
        return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.index');
    } else {
        list($controller, $mode_type) = explode('.', $_REQUEST['dispatch']);
        $user_step = checkInstallmentStep($auth['user_id']);
        if ($mode_type !== $user_step) {
            return array(CONTROLLER_STATUS_REDIRECT, 'installment_product.' . $user_step);
        }
    }
}


