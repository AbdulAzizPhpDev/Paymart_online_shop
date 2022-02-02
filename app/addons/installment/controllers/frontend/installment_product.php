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

    if ($mode == "index") {
    }

}
if ($mode == 'index') {


    fn_authentication_test_hook("var", 'var2');
//    fn_print_die(Tygh->app()->view());

//    Registry::get('view')->assign('id', $_REQUEST['id']);


//    fn_print_die($_REQUEST);

}
if ($mode == "view") {

//    fn_print_die($_REQUEST);

    Registry::get('view')->assign('id', $_REQUEST['id']);

}


