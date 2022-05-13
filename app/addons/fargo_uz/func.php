<?php

use Tygh\Registry;
use Tygh\Languages\Languages;

if (!defined('AREA')) {
    die('Access denied');
}

function fn_fargo_uz_install()
{
    $path = Registry::get('config.dir.root') . '/app/addons/fargo_uz/database/fargo.csv';
    $cities_file = fopen($path, 'r');
    $max_line_size = 165536;
    $delimiter = ',';
//    $import_schema = fgetcsv($cities_file, $max_line_size, $delimiter);

    while (($data = fn_fgetcsv($cities_file, $max_line_size, $delimiter)) !== false) {

        $data_city = [
            'country_id' => trim($data[0]),
            'city_id' => trim($data[3]),
            'city_name' => trim($data[4]),
            'parent_city_id' => trim($data[5]),
            'extra_days' => trim($data[6])
        ];

        db_query('INSERT INTO ?:fargo_countries ?e', $data_city);
    }

    $path = Registry::get('config.dir.root') . '/app/addons/fargo_uz/database/fargo_days.csv';

    $delimiter = ';';

    $cities_file = fopen($path, 'r');

    while (($data = fn_fgetcsv($cities_file, $max_line_size, $delimiter)) !== false) {

        $from = preg_replace("/[^a-zA-Z0-9]+/", "", $data[0]);
        $from = db_get_field("SELECT `id` FROM ?:fargo_countries WHERE city_id = 0 AND city_name = ?s", $from);

        $to  = preg_replace("/[^a-zA-Z0-9]+/", "", $data[1]);
        $to = db_get_field("SELECT `id` FROM ?:fargo_countries WHERE city_id = 0 AND city_name =?s", $to);


        $data_city = [
            'from' => $from,
            'to' => $to,
            'days' => trim($data[2])
        ];

        db_query('INSERT INTO ?:fargo_deliver_time ?e', $data_city);
    }

    $service = [
        'status' => 'A',
        'module' => FARGO_MODULE_NAME,
        'code' => 'fargo',
        'sp_file' => ''
    ];

    $service['service_id'] = db_query("INSERT INTO ?:shipping_services ?e", $service);

    foreach (Languages::getAll() as $lang_code => $lang_data) {

        if ($lang_code == 'ru') {
            $service['description'] = "FARGO: Курьерская служба";
        } elseif ($lang_code == 'uz') {
            $service['description'] = "Fargo: Posilka xizmati";
        } else {
            $service['description'] = "FARGO: Parcel Service";
        }
        $service['lang_code'] = $lang_code;

        db_query('INSERT INTO ?:shipping_service_descriptions ?e', $service);

    }

}

function fn_fargo_uz_uninstall()
{
    $service_ids = db_get_fields('SELECT service_id FROM ?:shipping_services WHERE module = ?s', 'fargo');
    if (!empty($service_ids)) {
        db_query('DELETE FROM ?:shipping_services WHERE service_id IN (?a)', $service_ids);
        db_query('DELETE FROM ?:shipping_service_descriptions WHERE service_id IN (?a)', $service_ids);
    }
}

function fn_fargo_uz_sender_recipient_data(
    $address_type = "residential",
    $name = "unknown",
    $city,
    $country = 234,
    $phone = null,
    $email = null,
    $apartment = null,
    $building = null,
    $street = null,
    $landmark = null,
    $neighborhood = null,
    $lat = null,
    $lon = null

)
{
    $data = [
        "adress_type" => $address_type,
        "name" => $name,
        "country" => [
            "id" => $country
        ],
        "city" => [
            "id" => $city
        ],
        "email" => $email,
        "apartment" => $apartment,
        "building" => $building,
        "street" => $street,
        "landmark" => $landmark,
        "neighborhood" => $neighborhood,
        "lat" => $lat,
        "lon" => $lon,
        "phone" => $phone

    ];
    return $data;
}

function fn_fargo_uz_dimensions($weight, $width, $height, $length, $unit = 1, $domestic = false)
{
    $data_unit = null;
    if ($unit == 1) {
        $data_unit = "METRIC";
    } else {
        $data_unit = "IMPERIAL";
    }

    $data = [
        "weight" => ($weight == 0) ? 1 : $weight,
        "width" => $width,
        "height" => $height,
        "length" => $length,
        "unit" => $data_unit,
        "domestic" => boolval($domestic)
    ];

    return $data;
}

function fn_fargo_uz_charge_items($charge_type = "service_custom", $payer, $paid = true, $charge = 0)
{
    $data = [
        "paid" => $paid,
        "charge_type" => $charge_type,
        "payer" => $payer,
        "charge" => ($charge_type == "service_custom") ? 0 : $charge,
    ];

    return $data;
}

