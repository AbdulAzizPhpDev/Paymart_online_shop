<?php

use Tygh\Registry;
use Tygh\Tools\Url;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
//php_curl()

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode == "login") {
//
//        Tygh::$app['session']->regenerateID();
//        fn_login_user(32, true);
//        return array(CONTROLLER_STATUS_REDIRECT, ('vendor.php?dispatch=index.index'));
        if (isset($_REQUEST['id'])) {
            if (empty($_REQUEST['id'])) {
                $error = showErrors('vendor_id_empty');
                Registry::get('ajax')->assign('result', $error);
                exit();
            } else {
                $data = [
                    "partner_id" => $_REQUEST['id'],
                    "role" => "partner"
                ];
                $response = php_curl('/login/validate-form', $data, 'POST', null);

                if ($response->status == "success") {
                    $data = [
                        'api_format' => 'object',
                        'partner_id' => $_REQUEST['id'],
                        'password' => $_REQUEST['password'],
                        'role' => 'partner'];
                    $response = php_curl('/login/auth', $data, 'POST', null);

                    if ($response->status == "success") {

                        $check = db_get_field('select p_c_id from ?:companies where p_c_id=?i ', $_REQUEST['id']);
                        if (!$check) {
                            list($email) = createEmail();
                            $data = [
                                "lang_code" => "ru",
                                "status" => "A",
                                "company" => "test",
                                "email" => $email,
                                "redirect_customer" => "Y",
                                "pre_moderation" => "N",
                                "pre_moderation_edit" => "N",
                                "pre_moderation_edit_vendors" => "N",
                                "plan_id" => 3,
                                "p_c_token" => $response->data->api_token,
                                "p_c_id" => $_REQUEST['id'],
                            ];
                            $com = db_query('INSERT INTO ?:companies ?e', $data);

                            $com = db_query('INSERT INTO ?:users ?e', $data);

                        } else {

                        }

                    }

                    Registry::get('ajax')->assign('result', $response);
                    exit();
                }
                Registry::get('ajax')->assign('result', $response);
                exit();

            }

            fn_print_die($response);

//            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_info, (int)fn_get_session_data('user_info')['id']);

        }
        $error = showErrors('vendor_id_empty');
        Registry::get('ajax')->assign('result', $error);
        exit();
    }
}
if ($mode == "login_form") {

}