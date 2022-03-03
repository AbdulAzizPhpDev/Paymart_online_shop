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
                $check_user_res = php_curl('/login/validate-form', $data, 'POST', null);

                if ($check_user_res->status == "success") {

                    $data = [
                        'api_format' => 'object',
                        'partner_id' => $_REQUEST['id'],
                        'password' => $_REQUEST['password'],
                        'role' => 'partner'
                    ];

                    $check_pass_res = php_curl('/login/check-password', $data, 'POST', null);

                    if ($check_pass_res->status == "success") {

                        $check = db_get_row('select * from ?:companies where p_c_id=?i ', $_REQUEST['id']);

                        if (!$check) {
                            list($email) = createEmail();
                            $data = [
                                "lang_code" => "ru",
                                "status" => "A",
                                "company" => $check_user_res->company_name,
                                "email" => $email,
                                "redirect_customer" => "Y",
                                "pre_moderation" => "N",
                                "pre_moderation_edit" => "N",
                                "pre_moderation_edit_vendors" => "N",
                                "plan_id" => 3,
                                "p_c_token" => $check_user_res->user_token,
                                "p_c_id" => $_REQUEST['id'],
                            ];
                            $company_id = db_query('INSERT INTO ?:companies ?e', $data);
                            $data_des = [
                                "company_id" => $company_id,
                                "lang_code" => "ru",
                                "company_description"=>$check_user_res->company_description
                            ];
                            db_query('INSERT INTO ?:company_descriptions ?e', $data_des);
                            //$user_data = db_get_row('select * from ?:users where p_user_id=?i ', $check_user_res->data->user_id);

                            $user_detail = php_curl('/buyer/detail', [], 'GET', $check_user_res->user_token);
                            if ($user_detail->status == "success") {
                                $user_id = create_user(999999999, $user_detail->data->name, $user_detail->data->surname, $_REQUEST['password'], 'V', $company_id, $email);
                                $data_u = [
                                    'api_key' => $check_user_res->user_token,
                                    'p_user_id' => $user_detail->data->id
                                ];
                                db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $data_u, $user_id);
                            }

                            Tygh::$app['session']->regenerateID();
                            fn_login_user($user_id, true);

                            $ekey = fn_generate_ekey($user_id, 'U', SECONDS_IN_DAY);

                            $url = "http://market.paymart.uz/vendor.php?dispatch=auth.ekey_login&ekey=$ekey&company_id=$company_id";

                            $res = [
                                'result' => $check_pass_res,
                                'url' => $url
                            ];

                            Registry::get('ajax')->assign('result', $res);
                            exit();

                        } else {
                            $data_u = [
                                'company' => $check_user_res->company_name
                            ];
                            db_query('UPDATE ?:companies SET ?u WHERE company_id = ?i', $data_u, $check['company_id']);
                            $user_data = db_get_row('select * from ?:users where user_type="V" and company_id=?i ', $check['company_id']);
                            if (empty($user_data)) {
                                $error = showErrors('vendor_id_empty');
                                Registry::get('ajax')->assign('result', $error);
                                exit();
                            }
                            $ekey = fn_generate_ekey($user_data['user_id'], 'U', SECONDS_IN_DAY);
                            $vendor_id = $check['company_id'];
                            $url = "http://market.paymart.uz/vendor.php?dispatch=auth.ekey_login&ekey=$ekey&company_id=$vendor_id";
                            $res = [
                                'result' => $check_pass_res,
                                'url' => $url
                            ];
                            Registry::get('ajax')->assign('result', $res);

                            exit();
                        }
                    }
                    Registry::get('ajax')->assign('result', $check_pass_res);
                    exit();
                }
                Registry::get('ajax')->assign('result', $check_user_res);
                exit();
            }
        }
        $error = showErrors('vendor_id_empty');
        Registry::get('ajax')->assign('result', $error);
        exit();
    }
}
if ($mode == "login_form") {

}