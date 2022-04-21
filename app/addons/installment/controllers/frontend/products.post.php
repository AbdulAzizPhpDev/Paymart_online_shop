<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($mode == 'view' || $mode == 'quick_view') {


    $company_info = db_get_row('select company.p_c_token,company.p_c_id from ?:products as product
                                   INNER JOIN ?:companies as company ON product.company_id = company.company_id 
                                   WHERE product.product_id = ?i ', $_REQUEST['product_id']);
    $view = Tygh::$app['view'];

    /** @var array $product */
    $product = $view->getTemplateVars('product');

    Tygh::$app['session']['test_xxx'] = [
        "parent_product_id" => $product['parent_product_id'],
        "price" => $product['price'],
        "variation_name" => $product['variation_name'] ?? null,
        "product_id" => $product['product_id'],
    ];
    Tygh::$app['view']->assign('company_info', $company_info);
}