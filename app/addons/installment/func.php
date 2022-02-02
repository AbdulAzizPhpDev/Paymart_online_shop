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

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

function fn_installment_test_hook($var1, $var2)
{
//    $service = array(
//        'status' => 'A',
//        'module' => 'sdek',
//        'code' => '1',
//        'sp_file' => '',
//        'description' => 'СДЭК',
//    );
//    foreach (Languages::getAll() as $service['lang_code'] => $lang_data) {
//        db_query('INSERT INTO ?:shipping_service_descriptions ?e', $service);
//    }

    $path = Registry::get('config.dir.root') . '/app/addons/rus_sdek/database/cities_sdek.csv';
//    fn_rus_cities_read_cities_by_chunk($path, RUS_CITIES_FILE_READ_CHUNK_SIZE, 'fn_rus_sdek_add_cities_in_table');
    $cities_file = fopen($path, 'rb');
    $max_line_size = 165536;
    $import_schema = fgetcsv($cities_file, $max_line_size, ',');
    $schema_size = sizeof($import_schema);


//    $curl = curl_init();
//
//    curl_setopt_array($curl, array(
//        CURLOPT_URL => 'https://prodapi.shipox.com/api/v2/customer/countries?page=0&size=20&search=',
//        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_ENCODING => '',
//        CURLOPT_MAXREDIRS => 10,
//        CURLOPT_TIMEOUT => 0,
//        CURLOPT_FOLLOWLOCATION => true,
//        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        CURLOPT_CUSTOMREQUEST => 'GET',
//        CURLOPT_HTTPHEADER => array(
//            'Authorization: Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJ0ZXN0QGNzdC5jb20iLCJ1c2VySWQiOjExOTc1NjM2NTcsImV4cCI6MTY0Mzg3NjkyNn0.Iu7l4bYPkfGBzh1CR7XUgqprBzrbBqffn5-zye2ImiNjk_FdOA-wWyjjGtMhyY2cC5a07x6omCAiQLHb6V_d_A'
//        ),
//    ));
//
//    $response = curl_exec($curl);
//
//    curl_close($curl);



    fn_print_die($path,Registry::get('config.dir.root'),$import_schema,$schema_size);
    return $var1;
}



