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
    return false;
}

function php_curl($url = '', $data = [], $method = 'GET', $token = null)
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
    $curl_options[CURLOPT_HTTPHEADER] = array('Content-Type: application/json');
    if (!empty($token)) {

        array_push($curl_options[CURLOPT_HTTPHEADER], ('Authorization: Bearer ' . $token));
    }
    if (!empty($data)) {
        $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);

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

function change_contracts_tabs($status = null) {
    switch ($status) {
        case 'moderation':
            $status = Tygh::$app['view']->assign('moderation', 'active');
            break;
        case 1:
            $status = Tygh::$app['view']->assign('active', 'active');
            break;
        case '3|4':
            $status = Tygh::$app['view']->assign('overdue', 'active');
            break;
        case 5:
            $status = Tygh::$app['view']->assign('cancelled', 'active');
            break;
        case 9:
            $status = Tygh::$app['view']->assign('closed', 'active');
            break;
        default:
            $status = Tygh::$app['view']->assign('all', 'active');
            break;
    }

    return $status;
}




