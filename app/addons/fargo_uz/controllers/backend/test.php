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


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://prodapi.shipox.com/api/v2/customer/cities?country_id=234&page=0&size=200',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_POSTFIELDS =>'{
    
    "size":200
}',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJsb2dpc3RpY3NAcGF5bWFydC51eiIsInVzZXJJZCI6MTE3NjU2MDQ5OCwiZXhwIjoxNjQ2NDc2OTA2fQ.9mkWjrbzHjGFuquV-oq-N3JJ4fm2HBWdRYbU5wqGZEdAHuRrE2doRodhx0lxHTrQteTNFn-0LUhVHXXl3KqLMg',
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);

curl_close($curl);



    fn_print_die(json_decode($response));
}