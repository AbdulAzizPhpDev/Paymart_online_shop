<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == "city") {

        if ($_REQUEST["city_id"] == 228171787) {
            $data = db_get_row('select * from ?:fargo_countries where parent_city_id=?i', 228171787);
            Registry::get('ajax')->assign('result', $data);
            exit();
        }

        Registry::get('ajax')->assign('result', null);
        exit();
    }
}