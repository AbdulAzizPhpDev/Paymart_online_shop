<?php

use Tygh\Registry;
use Tygh\Storage;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'returns') {
        fn_print_die($mode);
    }

}

if ($mode == 'manage') {

    $returns = null;

    if ($auth['user_type'] == "A") {
        $returns = db_get_array("select * from ?:returned_products order by status asc ");
    } else {
        $company_id = db_get_fields("select company_id from ?:users where user_id = ?i", $auth['user_id']);
        $returns = db_get_array("select * from ?:returned_products where company_id = ?i", $company_id);
    }

    fn_print_die($returns);

}

