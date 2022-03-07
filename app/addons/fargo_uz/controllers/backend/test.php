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
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($mode == "test") {
    $data = [
        "username" => FARGO_USERNAME,
        "password" => FARGO_PASSWORD
    ];

    $url = FARGO_URL . "/customer/authenticate";
    $fargo_auth_res = php_curl($url, $data, 'POST', '');
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://prodapi.shipox.com/api/v2/customer/cities?country_id=234&page=0&size=200&search=',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$fargo_auth_res->data->id_token,
            'Content-Type: application/json'
        ),
    ));
    $response = json_decode(curl_exec($curl));

    curl_close($curl);


    foreach ($response->data->list as $city) {

        $data = [
            'country_id' => 234,
            'city_id' => $city->id,
            'city_name' => $city->name
        ];
        fn_print_r($data);
//        db_query('INSERT INTO ?:fargo_countries ?e', $data);
    }
//    fn_print_die($response->data->list);
//
//    fn_print_die($fargo_auth_res->list);




}