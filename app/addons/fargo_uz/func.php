<?php

use Tygh\Registry;

if (!defined('AREA')) {
    die('Access denied');
}

function fn_fargo_uz_install()
{
    $path = Registry::get('config.dir.root') . '/app/addons/fargo_uz/database/fargo_cities.csv';
    $cities_file = fopen($path, 'r');
    $max_line_size = 165536;
    $delimiter = ',';
    $import_schema = fgetcsv($cities_file, $max_line_size, $delimiter);

    while (($data = fn_fgetcsv($cities_file, $max_line_size, $delimiter)) !== false) {
        $data_city = [
            'country_id' => trim($data[0]),
            'city_id' => trim($data[2]),
            'city_name' => trim($data[3]),
            'parent_city_id' => trim($data[4])
        ];
        db_query('INSERT INTO ?:fargo_countries ?e', $data_city);
    }


//    $data = [
//        "username" => FARGO_USERNAME,
//        "password" => FARGO_PASSWORD
//    ];
//
//    $url = FARGO_URL . "/customer/authenticate";
//    $fargo_auth_res = php_curl($url, $data, 'POST', '');
//    $curl = curl_init();
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => 'https://prodapi.shipox.com/api/v2/customer/cities?country_id=234&page=0&size=200&search=',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => '',
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 0,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'GET',
//        CURLOPT_HTTPHEADER => array(
//            'Authorization: Bearer ' . $fargo_auth_res->data->id_token,
//            'Content-Type: application/json'
//        ),
//    ));
//    $response = json_decode(curl_exec($curl));
//    curl_close($curl);
//
//    foreach ($response->data->list as $city) {
//
//        $data = [
//            'country_id' => 234,
//            'city_id' => $city->id,
//            'city_name' => $city->name
//        ];
//        db_query('INSERT INTO ?:fargo_countries ?e', $data);
//    }
//
//    $child_cities = [
//        [
//            "id" => 234827628,
//            "city_name" => "Bektemir Tumani"
//        ],
//        [
//            "id" => 234827631,
//            "city_name" => "Chilanzar Tumani"
//        ],
//        [
//            "id" => 234827632,
//            "city_name" => "Mirobod Tumani"
//        ],
//        [
//            "id" => 234827633,
//            "city_name" => "Mirzo Ulugbek Tumani"
//        ],
//        [
//            "id" => 234827634,
//            "city_name" => "Olmazor Tumani"
//        ],
//        [
//            "id" => 234827641,
//            "city_name" => "Sirgali Tumani"
//        ],
//        [
//            "id" => 234827642,
//            "city_name" => "Yakkasaroy Tumani"
//        ],
//        [
//            "id" => 234827647,
//            "city_name" => "Yunusabad Tumani"
//        ],
//        [
//            "id" => 234827643,
//            "city_name" => "Uchtepa Tumani"
//        ],
//        [
//            "id" => 234827644,
//            "city_name" => "Shayxontohur Tumani"
//        ],
//        [
//            "id" => 234827645,
//            "city_name" => "Yashnobod Tumani"
//        ],
//
//    ];
//
//    foreach ($child_cities as $city2) {
//
//        $data1 = [
//            'country_id' => 234,
//            'city_id' => $city2['id'],
//            'city_name' => $city2['city_name'],
//            'parent_city_id' => 228171787
//        ];
//        db_query('INSERT INTO ?:fargo_countries ?e', $data1);
//
//    }


}

//function fn_rus_edost_uninstall()
//{
//    $service_ids = db_get_fields('SELECT service_id FROM ?:shipping_services WHERE module = ?s', 'edost');
//
//    if (!empty($service_ids)) {
//        db_query('DELETE FROM ?:shipping_services WHERE service_id IN (?a)', $service_ids);
//        db_query('DELETE FROM ?:shipping_service_descriptions WHERE service_id IN (?a)', $service_ids);
//    }
//}
//
//function fn_rus_edost_update_cart_by_data_post(&$cart, $new_cart_data, $auth)
//{
//    if (!empty($new_cart_data['select_office'])) {
//        $cart['select_office'] = $new_cart_data['select_office'];
//    }
//
//    if (!empty($new_cart_data['pickpointmap'])) {
//        $cart['pickpointmap'] = $new_cart_data['pickpointmap'];
//    }
//}
//
//function fn_rus_edost_calculate_cart_taxes_pre(&$cart, $cart_products, &$product_groups)
//{
//    if (!empty($cart['shippings_extra'])) {
//        if (!empty($cart['select_office'])) {
//            $select_office = $cart['select_office'];
//
//        }
//
//        if (!empty($cart['pickpointmap'])) {
//            $pickpointmap = $cart['pickpointmap'];
//
//        }
//
//        if (!empty($select_office)) {
//            foreach ($product_groups as $group_key => $group) {
//                if (!empty($group['chosen_shippings'])) {
//                    foreach ($group['chosen_shippings'] as $shipping_key => $shipping) {
//                        $shipping_id = $shipping['shipping_id'];
//
//                        if ($shipping['module'] != 'edost' && empty($cart['shippings_extra']['data'][$group_key][$shipping_id])) {
//                            continue;
//                        }
//
//                        $shippings_extra = $cart['shippings_extra']['data'][$group_key][$shipping_id];
//                        $product_groups[$group_key]['chosen_shippings'][$shipping_key]['data'] = $shippings_extra;
//
//                        if (empty($select_office[$group_key][$shipping_id])) {
//                            continue;
//                        }
//
//                        $office_id = $select_office[$group_key][$shipping_id];
//                        $product_groups[$group_key]['chosen_shippings'][$shipping_key]['office_id'] = $office_id;
//
//                        if (!empty($shippings_extra['office'][$office_id])) {
//                            $office_data = $shippings_extra['office'][$office_id];
//                            $product_groups[$group_key]['chosen_shippings'][$shipping_key]['office_data'] = $office_data;
//                        }
//                    }
//                }
//            }
//        }
//
//        if (!empty($pickpointmap)) {
//            foreach ($product_groups as $group_key => $group) {
//                fn_edost_add_data_product_groups($cart, $product_groups, $group_key, $pickpointmap);
//            }
//        }
//
//        if (!empty($cart['shippings_extra']['data'])) {
//            foreach ($cart['shippings_extra']['data'] as $group_key => $shippings) {
//                foreach ($shippings as $shipping_id => $shipping_data) {
//                    if (!empty($product_groups[$group_key]['shippings'][$shipping_id]['module']))
//                    {
//                        $module = $product_groups[$group_key]['shippings'][$shipping_id]['module'];
//                        if (!empty($shipping_data) && $module == 'edost') {
//                            $product_groups[$group_key]['shippings'][$shipping_id]['data'] = $shipping_data;
//                        }
//                    }
//
//                }
//            }
//        }
//
//        if (!empty($cart['shippings_extra']['rates'])) {
//            foreach ($cart['shippings_extra']['rates'] as $group_key => $shippings) {
//                foreach ($shippings as $shipping_id => $shipping) {
//                    if (!empty($shipping['day']) && !empty($product_groups[$group_key]['shippings'][$shipping_id])) {
//                        $product_groups[$group_key]['shippings'][$shipping_id]['delivery_time'] = $shipping['day'];
//                    }
//                }
//            }
//        }
//    }
//
//    if (!empty($cart['payment_id'])) {
//        $payment_info = fn_get_payment_method_data($cart['payment_id']);
//
//        if (strpos($payment_info['template'], 'edost_cod.tpl')) {
//            $cart['shippings_extra']['sum'] = array(
//                'pricediff' => 0,
//                'transfer' => 0,
//                'total' => 0
//            );
//
//            foreach ($product_groups as $group_key => $group) {
//                foreach ($group['shippings'] as $shipping_id => $shipping) {
//                    if (!empty($cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'])) {
//                        $cart['product_groups'][$group_key]['shippings'][$shipping_id]['rate'] = $cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'];
//                        $product_groups[$group_key]['shippings'][$shipping_id]['rate'] = $cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'];
//                    }
//
//                    if (!empty($cart['shipping'][$shipping_id])) {
//                        $cart['shipping'][$shipping_id]['rate'] = $cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'];
//                        $cart['shipping'][$shipping_id]['rates'] = 1;
//                    }
//                }
//
//                if (!empty($group['chosen_shippings'])) {
//                    foreach ($group['chosen_shippings'] as $shipping_key => $shipping) {
//                        $shipping_id = $shipping['shipping_id'];
//
//                        if (!empty($cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'])) {
//                            $cart['product_groups'][$group_key]['shippings'][$shipping_id]['rate'] = $cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricecash'];
//                            $cart['shippings_extra']['sum']['pricediff'] += $cart['shippings_extra']['rates'][$group_key][$shipping_id]['pricediff'];
//                        }
//
//                        $cart['shippings_extra']['sum']['transfer'] += $cart['shippings_extra']['rates'][$group_key][$shipping_id]['transfer'];
//
//                        if (!empty($cart['shippings_extra']['rates'][$group_key][$shipping['shipping_id']]['pricecash'])) {
//                            $product_groups[$group_key]['chosen_shippings'][$shipping_key]['rate'] = $cart['shippings_extra']['rates'][$group_key][$shipping['shipping_id']]['pricecash'];
//                            $cart['shipping_cost'] = $cart['shippings_extra']['rates'][$group_key][$shipping['shipping_id']]['pricecash'];
//                            $cart['display_shipping_cost'] = $cart['shipping_cost'];
//                        }
//                    }
//
//                    $cart['shippings_extra']['sum']['total'] = $cart['shippings_extra']['sum']['transfer'] + $cart['shippings_extra']['sum']['pricediff'];
//                }
//
//            }
//
//        }
//
//        Tygh::$app['session']['shipping_hash'] = fn_get_shipping_hash($cart['product_groups']);
//    }
//}
//
///**
// * Adds information about a PickPoint shipping method.
// *
// * @param array $cart Array of cart content and user information necessary for purchase
// * @param $product_groups Products groups from cart
// * @param $group_key Group number
// * @param $pickpointmap The array with the data of a PickPoint pickup point
// *
// * @return void
// */
//function fn_edost_add_data_product_groups($cart, &$product_groups, $group_key, $pickpointmap)
//{
//    if (empty($product_groups[$group_key]['chosen_shippings'])) {
//        return;
//    }
//
//    $chosen_shippings = $product_groups[$group_key]['chosen_shippings'];
//
//    foreach ($chosen_shippings as $shipping_key => $shipping) {
//        $shipping_id = $shipping['shipping_id'];
//
//        if ($shipping['module'] != 'edost' || empty($cart['pickpointmap'][$group_key][$shipping_id])) {
//            continue;
//        }
//
//        $shippings_pickpoint = $cart['pickpointmap'][$group_key][$shipping_id];
//        $product_groups[$group_key]['chosen_shippings'][$shipping_key]['pickpointmap_data'] = $shippings_pickpoint;
//
//        if (empty($pickpointmap[$group_key][$shipping_id])) {
//            continue;
//        }
//
//        $pickpoint_id = $pickpointmap[$group_key][$shipping_id]['pickpoint_id'];
//        $product_groups[$group_key]['chosen_shippings'][$shipping_key]['pickpoint_id'] = $pickpoint_id;
//
//        if (!empty($shippings_pickpoint)) {
//            $pickpointmap_data = $shippings_pickpoint;
//            $product_groups[$group_key]['chosen_shippings'][$shipping_key]['pickpointmap_data'] = $pickpointmap_data;
//        }
//    }
//}
//
///**
// * Hook handler: on before getting cities list. The adds the join and the field in the sql query.
// */
//function fn_rus_edost_get_cities_pre($params, $items_per_page, $lang_code, &$fields, $condition, &$join)
//{
//    $fields[] = '?:rus_edost_cities_link.edost_code';
//
//    $join .= ' LEFT JOIN ?:rus_edost_cities_link ON ?:rus_cities.city_id = ?:rus_edost_cities_link.city_id';
//}
//
///**
// * Hook handler: on after update cities. The updates of city for the edost table.
// */
//function fn_rus_edost_update_city_post($city_data, $city_id, $lang_code)
//{
//    if (isset($city_data['edost_code'])) {
//        $edost_link = array(
//            'city_id' => $city_id,
//            'edost_code' => $city_data['edost_code']
//        );
//
//        db_replace_into('rus_edost_cities_link', $edost_link);
//    }
//}
//
///**
// * Gets the edost code for the cities.
// *
// * @param array $cities_ids The array with the cities identificators.
// *
// * @return array The array code cities for edost.
// */
//function fn_rus_edost_get_codes($cities_ids)
//{
//    $cities = db_get_fields(
//        'SELECT edost_code'
//        . ' FROM ?:rus_edost_cities_link'
//        . ' WHERE city_id IN (?a)',
//        $cities_ids
//    );
//
//    return $cities;
//}
//
///**
// * Adds the cities data in the table.
// *
// * @param array $rows The array with cities data.
// *
// * @return void.
// */
//function fn_rus_edost_add_cities_in_table($rows)
//{
//    $cities_hash = fn_rus_cities_get_all_cities($rows);
//
//    foreach ($rows as $city_data) {
//        $city_data['City'] = fn_strtolower($city_data['City']);
//
//        if (!empty($cities_hash[$city_data['Country']][$city_data['OblName']][$city_data['City']])) {
//            $city_id = $cities_hash[$city_data['Country']][$city_data['OblName']][$city_data['City']];
//
//            $city = array(
//                'city_id' => $city_id,
//                'edost_code' => $city_data['edost']
//            );
//
//            db_replace_into('rus_edost_cities_link', $city);
//        }
//    }
//}
//
///**
// * Hook handler: on before delete cities. The deletes of city in the edost table.
// */
//function fn_rus_edost_delete_city_post($city_id)
//{
//    db_query('DELETE FROM ?:rus_edost_cities_link WHERE city_id = ?i', $city_id);
//}
//
///**
// * Hook handler: sets pickup point data.
// */
//function fn_rus_edost_pickup_point_variable_init(
//    PickpupPointVariable $instance,
//    $order,
//    $lang_code,
//    &$is_selected,
//    &$name,
//    &$phone,
//    &$full_address,
//    &$open_hours_raw,
//    &$open_hours,
//    &$description_raw,
//    &$description
//) {
//    if (!empty($order['shipping'])) {
//        if (is_array($order['shipping'])) {
//            $shipping = reset($order['shipping']);
//        } else {
//            $shipping = $order['shipping'];
//        }
//
//        if (!isset($shipping['module']) || $shipping['module'] !== 'edost') {
//            return;
//        }
//
//        if (isset($shipping['office_data'])) {
//            $pickup_data = $shipping['office_data'];
//
//            $is_selected = true;
//            $name = $pickup_data['name'];
//            $phone = $pickup_data['tel'];
//            $full_address = fn_rus_edost_format_pickup_point_address($order, $pickup_data['address'], $lang_code);
//            $open_hours = $pickup_data['schedule'];
//            $open_hours_raw = [$pickup_data['schedule']];
//        }
//    }
//
//    return;
//}
//
///**
// * Formats eDost pickup point address.
// *
// * @param array  $order_info           Order data
// * @param string $pickup_point_address Pickup point address from API response
// * @param string $lang_code            Two-letter language code
// *
// * @return string Address
// */
//function fn_rus_edost_format_pickup_point_address($order_info, $pickup_point_address, $lang_code)
//{
//    $address_parts = array_filter([
//        fn_get_country_name($order_info['s_country'], $lang_code),
//        fn_get_state_name($order_info['s_state'], $order_info['s_country'], $lang_code) ?: $order_info['s_state'],
//        $order_info['s_city'],
//        $pickup_point_address,
//    ], 'fn_string_not_empty');
//
//    $address = implode(', ', $address_parts);
//
//    return $address;
//}
