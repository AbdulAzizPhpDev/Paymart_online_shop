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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == "sms_send") {
        fn_print_die($_REQUEST);
    }

}
if ($mode == 'index') {

//    fn_print_die($_REQUEST);
    Registry::get('view')->assign('id', $_REQUEST['id']);

}
if ($mode == "view") {

//    fn_print_die($_REQUEST);

    Registry::get('view')->assign('id', $_REQUEST['id']);

}


