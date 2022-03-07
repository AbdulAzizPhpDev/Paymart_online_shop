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
    $child_cities = [
        [
            "id" => 234827628,
            "city_name" => "Bektemir Tumani"
        ],
        [
            "id" => 234827631,
            "city_name" => "Chilanzar Tumani"
        ],
        [
            "id" => 234827632,
            "city_name" => "Mirobod Tumani"
        ],
        [
            "id" => 234827633,
            "city_name" => "Mirzo Ulugbek Tumani"
        ],
        [
            "id" => 234827634,
            "city_name" => "Olmazor Tumani"
        ],
        [
            "id" => 234827641,
            "city_name" => "Sirgali Tumani"
        ],
        [
            "id" => 234827642,
            "city_name" => "Yakkasaroy Tumani"
        ],
        [
            "id" => 234827647,
            "city_name" => "Yunusabad Tumani"
        ],
        [
            "id" => 234827643,
            "city_name" => "Uchtepa Tumani"
        ],
        [
            "id" => 234827644,
            "city_name" => "Shayxontohur Tumani"
        ],
        [
            "id" => 234827645,
            "city_name" => "Yashnobod Tumani"
        ],

    ];

    foreach ($child_cities as $city) {
        fn_print_die($city['id']);
        $data = [
            'country_id' => 234,
            'city_id' => $city['id'],
            'city_name' => $city['city_name']
        ];
        db_query('UPDATE INTO ?:fargo_countries ?e', $data);

    }
}