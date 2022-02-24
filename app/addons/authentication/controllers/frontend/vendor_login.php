<?php

use Tygh\Registry;
use Tygh\Tools\Url;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}
//php_curl()

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($mode == "login") {

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

                        $check = db_get_row('select * from ?:companies where p_c_id=?i ', $_REQUEST['id']);

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
                            $user_data = db_get_row('select * from ?:users where p_user_id=?i ', $response->data->user_id);

                            $user_detail = php_curl('/buyer/detail', [], 'POST', $response->data->api_token);

                            $user_id = create_user(999999999, $user_detail->data->name, $user_detail->data->surname, $_REQUEST['password'], 'V', $com, $email);

                            $data_u = [
                                'api_key' => $response->data->api_token,
                                'p_user_id' => $response->data->user_id
                            ];
                            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $data_u, $user_id);


                            Tygh::$app['session']->regenerateID();
                            fn_login_user($user_id, true);

                            $ekey = fn_generate_ekey($user_id, 'U', SECONDS_IN_DAY);

                            $url = "http://market.paymart.uz/vendor.php?dispatch=auth.ekey_login&ekey=$ekey&company_id=$com";

                            $res =[
                                'result'=>$response,
                                'url'=>$url
                            ];
                            Registry::get('ajax')->assign('result', $res);
                            exit();


                        } else {
                            $user_data = db_get_row('select * from ?:users where p_user_id=?i ', $response->data->user_id);
                            $ekey = fn_generate_ekey($user_data['user_id'], 'U', SECONDS_IN_DAY);
                            $vendor_id = $check['company_id'];
                            $url = "http://market.paymart.uz/vendor.php?dispatch=auth.ekey_login&ekey=$ekey&company_id=$vendor_id";
                           $res =[
                               'result'=>$response,
                               'url'=>$url
                           ];
                            Registry::get('ajax')->assign('result', $res);

                            exit();
                        }

                    }

                    Registry::get('ajax')->assign('result', $response);
                    exit();
                }
                Registry::get('ajax')->assign('result', $response);
                exit();

            }

//            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_info, (int)fn_get_session_data('user_info')['id']);

        }
        $error = showErrors('vendor_id_empty');
        Registry::get('ajax')->assign('result', $error);
        exit();
    }
}
if ($mode == "login_form") {

}