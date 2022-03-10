<?php

use Tygh\Registry;
use Tygh\Tools\Url;
use Tygh\Enum\Addons\Installment\InstallmentVar;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}


if ($mode == 'view' || $mode == 'quick_view') {


    $_REQUEST['product_id'] = empty($_REQUEST['product_id']) ? 0 : $_REQUEST['product_id'];

    if (!empty($_REQUEST['product_id']) && empty($auth['user_id'])) {

        $uids = explode(',', db_get_field('SELECT usergroup_ids FROM ?:products WHERE product_id = ?i', $_REQUEST['product_id']));

        if (!in_array(USERGROUP_ALL, $uids) && !in_array(USERGROUP_GUEST, $uids)) {
            return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form?return_url=' . urlencode(Registry::get('config.current_url')));
        }
    }

    $product = fn_get_product_data(
        $_REQUEST['product_id'],
        $auth,
        CART_LANGUAGE,
        '',
        true,
        true,
        true,
        true,
        fn_is_preview_action($auth, $_REQUEST),
        true,
        false,
        true
    );

    if (empty($product)) {
        return array(CONTROLLER_STATUS_NO_PAGE);
    }

    if (fn_allowed_for('MULTIVENDOR')) {
        /** @var \Tygh\Storefront\Storefront $storefront */
        $storefront = Tygh::$app['storefront'];
        if (
            !empty($product['company_id'])
            && $storefront->getCompanyIds()
            && !in_array($product['company_id'], $storefront->getCompanyIds())
        ) {
            return [CONTROLLER_STATUS_NO_PAGE];
        }
    }

    if ((empty(Tygh::$app['session']['current_category_id']) || empty($product['category_ids'][Tygh::$app['session']['current_category_id']])) && !empty($product['main_category'])) {
        if (!empty(Tygh::$app['session']['breadcrumb_category_id']) && in_array(Tygh::$app['session']['breadcrumb_category_id'], $product['category_ids'])) {
            Tygh::$app['session']['current_category_id'] = Tygh::$app['session']['breadcrumb_category_id'];
        } else {
            Tygh::$app['session']['current_category_id'] = $product['main_category'];
        }
    }

    if (!empty($product['meta_description']) || !empty($product['meta_keywords'])) {
        Tygh::$app['view']->assign('meta_description', $product['meta_description']);
        Tygh::$app['view']->assign('meta_keywords', $product['meta_keywords']);

    } else {
        $meta_tags = db_get_row(
            "SELECT meta_description, meta_keywords"
            . " FROM ?:category_descriptions"
            . " WHERE category_id = ?i AND lang_code = ?s",
            Tygh::$app['session']['current_category_id'],
            CART_LANGUAGE
        );
        if (!empty($meta_tags)) {
            Tygh::$app['view']->assign('meta_description', $meta_tags['meta_description']);
            Tygh::$app['view']->assign('meta_keywords', $meta_tags['meta_keywords']);
        }
    }
    if (!empty(Tygh::$app['session']['current_category_id'])) {
        Tygh::$app['session']['continue_url'] = "categories.view?category_id=" . Tygh::$app['session']['current_category_id'];

        $parent_ids = fn_get_category_ids_with_parent(Tygh::$app['session']['current_category_id']);

        if (!empty($parent_ids)) {
            Registry::set('runtime.active_category_ids', $parent_ids);
            $cats = fn_get_category_name($parent_ids);
            foreach ($parent_ids as $c_id) {
                fn_add_breadcrumb($cats[$c_id], "categories.view?category_id=$c_id");
            }
        }
    }
    fn_add_breadcrumb($product['product']);

    if (!empty($_REQUEST['combination'])) {
        $product['combination'] = $_REQUEST['combination'];
    }

    fn_gather_additional_product_data($product, true, true);


    $company_info = db_get_row('select company.p_c_token,company.p_c_id from ?:products as product
                                   INNER JOIN ?:companies as company ON product.company_id = company.company_id 
                                   WHERE product.product_id = ?i ', $_REQUEST['product_id']);

    Tygh::$app['view']->assign('company_info', $company_info);
    Tygh::$app['view']->assign('product', $product);
    Tygh::$app['view']->assign('product_id', $_REQUEST['product_id']);

    // If page title for this product is exist than assign it to template
    if (!empty($product['page_title'])) {
        Tygh::$app['view']->assign('page_title', $product['page_title']);
    }

    $params = array(
        'product_id' => $_REQUEST['product_id'],
        'preview_check' => true
    );
    list($files) = fn_get_product_files($params);

    if (!empty($files)) {
        Tygh::$app['view']->assign('files', $files);
    }

    // Initialize product tabs
    fn_init_product_tabs($product);

    // Set recently viewed products history
    fn_add_product_to_recently_viewed($_REQUEST['product_id']);

    // Increase product popularity
    fn_set_product_popularity($_REQUEST['product_id']);

    Tygh::$app['view']->assign('show_qty', true);

    // custom vendor blocks
    if ($vendor_id = fn_get_runtime_vendor_id()) {
        Tygh::$app['view']->assign('company_id', $vendor_id);
        $_REQUEST['company_id'] = $vendor_id;
    }

    if ($mode == 'quick_view') {
        if (defined('AJAX_REQUEST')) {
            fn_prepare_product_quick_view($_REQUEST);
            Registry::set('runtime.root_template', 'views/products/quick_view.tpl');
        } else {
            return array(CONTROLLER_STATUS_REDIRECT, 'products.view?product_id=' . $_REQUEST['product_id']);
        }
    }

}