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


    }

}

if ($mode == 'confirm') {

    $data = [
        "phone" => "998900430246",
        "code" => "6765"
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
    fn_print_die(json_decode($response));
    echo $response;

}

