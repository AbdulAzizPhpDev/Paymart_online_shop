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

/**
 * @var string $mode
 * @var string $action
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    if ($mode == 'send_sms') {

        $pattern = "/^998\d{9}$/";

        if (!preg_match($pattern, $_REQUEST['phone'])) {
            $error = [
                'status' => "error",
                'response' => [
                    "code" => "404",
                    "message" => __('wrong_format_number'),
                    "errors" => ""
                ],
                'data' => [
                    'phone' => $_REQUEST['phone']
                ]
            ];

            Registry::get('ajax')->assign('result', $error);
            exit();
        }

        $data = [
            'phone' => $_REQUEST['phone']
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.paymart.uz/api/v1/login/send-sms-code',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);

        $response_data = json_decode($response);
        curl_close($curl);

        $data = db_get_field('SELECT user_id FROM ?:users WHERE phone = ?i', $_REQUEST['phone']);
        if (empty($data)) {
            $user = create_user($_REQUEST['phone']);
            $user_info = [
                'phone' => $_REQUEST['phone'],
                'id' => $user,
                'hash' => $response_data->hash
            ];
            fn_set_session_data('user_info', $user_info);
        } else {
            $user_info = [
                'phone' => $_REQUEST['phone'],
                'id' => $data,
                'hash' => $response_data->hash
            ];
            fn_set_session_data('user_info', $user_info);
        }
        $error = [
            'status' => "success",
            'response' => [
                "code" => "202",
                "message" => __('massage_send'),
                "errors" => ""
            ],
            'data' => [
                'phone' => $_REQUEST['phone']
            ]
        ];

        Registry::get('ajax')->assign('result', $error);
        exit();
    }


    if ($mode == 'confirm') {

        $pattern = "/^998\d{9}$/";

        if (!preg_match($pattern, $_REQUEST['phone'])) {
            $error = [
                'status' => "error",
                'response' => [
                    "code" => "404",
                    "message" => __('wrong_format_number'),
                    "errors" => ""
                ],
                'data' => [
                    'phone' => $_REQUEST['phone']
                ]
            ];

            Registry::get('ajax')->assign('result', $error);
            exit();
        }
        if (fn_get_session_data('user_info')['phone'] !== $_REQUEST['phone']) {
            $error = [
                'status' => "error",
                'response' => [
                    "code" => "404",
                    "message" => __('wrong_phone_number'),
                    "errors" => ""
                ],
                'data' => [
                    'phone' => $_REQUEST['phone']
                ]
            ];

            Registry::get('ajax')->assign('result', $error);
            exit();
        }

        if (!preg_match($pattern, $_REQUEST['phone'])) {
            $error = [
                'status' => "error",
                'response' => [
                    "code" => "404",
                    "message" => __('wrong_format_number'),
                    "errors" => ""
                ],
                'data' => [
                    'phone' => $_REQUEST['phone']
                ]
            ];

            Registry::get('ajax')->assign('result', $error);
            exit();
        }

        $data = [
            "phone" => $_REQUEST['phone'],
            "code" => $_REQUEST['code'],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.paymart.uz/api/v1/login/auth',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response);
//
//        data:
//        access_token: "7dbe6bed62c8535daf18ae5b42b30ea1"
//api_token: "7dbe6bed62c8535daf18ae5b42b30ea1"
//user_id: 371618
//user_status: 1
//[[Prototype]]: Object
//is_seller: 0
//response: {code: 200, message: Array(0), errors: Array(0)}
//status: "success"


        if ($response->status == "success") {
            $user_info['api_key'] = $response->data->access_token;
            $user_info['p_user_id'] = $response->data->user_id;
            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_info, (int)fn_get_session_data('user_info')['id']);

        }


        Tygh::$app['session']->regenerateID();
        fn_login_user(fn_get_session_data('user_info')['id'], true);

//        Helpdesk::auth();

//        if (!empty($_REQUEST['redirect_url'])) {
//            return $_REQUEST['redirect_url'];
//        }
//        else {
//            $redirect_url = fn_url('auth.login' . !empty($_REQUEST['return_url']) ? '?return_url=' . $_REQUEST['return_url'] : '');
//        }

        Registry::get('ajax')->assign('result', $response);
        exit();

    }
}

