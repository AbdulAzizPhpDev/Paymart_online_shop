<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == "city") {

        $data = db_get_array('select * from ?:fargo_countries where parent_city_id=?i', $_REQUEST["city_id"]);
        Registry::get('ajax')->assign('result', $data);
        exit();
    }
}