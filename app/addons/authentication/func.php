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


if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

function fn_authentication_send_sms($phone, $code = 0000)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://91.204.239.44/broker-api/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 20,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
    "messages":[{"recipient":"' . $phone . '",
    "message-id":"itsm' . $phone . $code . TIME . '",
    "sms":{"originator": "3700",
    "content":{"text":"Kod: ' . $code . '"}}}]
}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic cGF5bWFydDo1a05OdDc4Ums0',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

function createEmail()
{
    $string = "abcdefghijklmnopqrstuvwxyz";

    $first_part = rand(5, strlen($string) - 10);
    $string_first = substr($string, $first_part, rand(5, 10));

    $string_second = str_shuffle(substr($string, rand(5, strlen($string) - 10), rand(5, 10)));
    $email = $string_first . '@' . $string_second . '.uz';

    if (checkEmail($email)) {
        createEmail();
    }

//    $first_name = ucfirst(str_shuffle(substr($string, $first_part, rand(10, strlen($string)))));
//    $last_name = ucfirst(substr($string, $first_part, rand(10, strlen($string))));

    return array(
        $email
    );
}

function create_user($phone = 0, $first_name = '', $last_name = '', $password = 123456789, $user_type = 'C', $company_id = 0, $email = null)
{
    if (!$email) {
        list($email) = createEmail();
    }
    $user_data['firstname'] = $first_name;
    $user_data['lastname'] = $last_name;
    $user_data['phone'] = $phone;
    $user_data['email'] = $email;
    $user_data['password'] = fn_password_hash($password);;
    $user_data['company_id'] = $company_id;
    $user_data['lang_code'] = CART_LANGUAGE;
    $user_data['timestamp'] = TIME;
    $user_data['user_type'] = $user_type;
    $user_data['status'] = "A";
    $user_data['password_change_timestamp'] = 1;

    $user_id = db_query('INSERT INTO ?:users ?e', $user_data);
    $data['user_login'] = 'user_' . $user_id;
    db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $data, $user_id);
    return $user_id;
}

function checkEmail($email)
{
    if (!empty(db_get_field("SELECT email FROM ?:users WHERE email = ?s", $email)))
        return true;
    return false;
}

function fn_authentication_get_profile_fields($location, $select, $condition, $params)
{

}

function fn_authentication_get_profile_fields_post($location, $_auth, $lang_code, $params, &$profile_fields, $sections)
{
    foreach ($profile_fields['C'] as $key => $data) {
        $profile_fields['C'][$key]['required'] = "Y";
    }
}


function fn_authentication_get_user_short_info_pre($user_id, &$fields, $condition, $join, $group_by)
{
    array_push($fields, 'api_key', 'i_step', 'i_limit');
}



