<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2022   *
* / /_\ | | _____  _| |_/ /_ __ __ _ _ __   __| |_ _ __   __ _   | |_ ___  __ _ _ __ ___   *
* |  _  | |/ _ \ \/ / ___ \ '__/ _` | '_ \ / _` | | '_ \ / _` |  | __/ _ \/ _` | '_ ` _ \  *
* | | | | |  __/>  <| |_/ / | | (_| | | | | (_| | | | | | (_| |  | ||  __/ (_| | | | | | | *
* \_| |_/_|\___/_/\_\____/|_|  \__,_|_| |_|\__,_|_|_| |_|\__, |  \___\___|\__,_|_| |_| |_| *
*                                                         __/ |                            *
*                                                        |___/                             *
* ---------------------------------------------------------------------------------------- *
* This is commercial software, only users who have purchased a valid license and accept    *
* to the terms of the License Agreement can install and use this program.                  *
* ---------------------------------------------------------------------------------------- *
* website: https://cs-cart.alexbranding.com                                                *
*   email: info@alexbranding.com                                                           *
*******************************************************************************************/
use Tygh\ABTUT2;
use Tygh\Embedded;
use Tygh\Registry;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
function fn_abt__ut2_get_microdata()
{
if (Embedded::isEnabled()) {
return false;
}
$schema_items = fn_get_schema('abt__ut2_microdata', 'items');
$schema_groups = fn_get_schema('abt__ut2_microdata', 'groups');
$data = ABTUT2::fn_get_microdata(CART_LANGUAGE);
if (empty($data)) {
return false;
}
$microdata = (object) [
'@context' => 'https://schema.org',
'@type' => 'Organization',
];
foreach ($data as $item) {
if (empty($schema_items[$item['field']])) {
continue;
}
if (empty($schema_items[$item['field']]['group'])) {
$item_parent = &$microdata;
} else {
$group_name = $schema_items[$item['field']]['group'];
if (empty($microdata->{$group_name})) {
$microdata->{$group_name}
= new stdClass();
}
$item_parent = &$microdata->{$group_name};
if (!empty($schema_groups[$group_name]) && !empty($schema_groups[$group_name]['@type'])) {
$item_parent->{'@type'} = $schema_groups[$group_name]['@type'];
}
}
if (empty($item_parent->{$item['field']})) {
$item_parent->{$item['field']}
= $item['value'];
} else {
if (!is_array($item_parent->{$item['field']})) {
$item_parent->{$item['field']}
= [$item_parent->{$item['field']}];
}
$item_parent->{$item['field']}
[] = $item['value'];
}
}
return $microdata;
}
function fn_abt__ut2_get_product_brand($product_id)
{
$settings = fn_get_abt__ut2_settings();
if ($settings['general']['brand_feature_id']) {
return db_get_field(
'SELECT variant_descriptions.variant FROM ?:product_features_values AS v'
.' LEFT JOIN ?:product_feature_variant_descriptions AS variant_descriptions ON variant_descriptions.variant_id = v.variant_id AND v.lang_code = variant_descriptions.lang_code'
.' WHERE v.product_id = ?i AND v.feature_id = ?i AND variant_descriptions.lang_code = ?s'
, $product_id, $settings['general']['brand_feature_id'], CART_LANGUAGE);
}
return '';
}
function fn_abt__ut2_get_locale()
{
$schema = fn_get_schema('abt__ut2_microdata', 'og_locales');
return empty($schema[CART_LANGUAGE]) ? CART_LANGUAGE : $schema[CART_LANGUAGE];
}
function fn_abt__unitheme2_seo_get_schema_org_markup_items_post($product_data, $show_price, $currency, &$markup_items)
{
if (!empty($product_data) && !empty($markup_items['product'])) {
$markup_items['product']['brand']['name'] = fn_abt__ut2_get_product_brand($product_data['product_id']);
}
}
function fn_abt__ut2_print_bc_markup ($breadcrumbs)
{
$microdata = [
'@context' => 'http://schema.org',
'@type' => 'BreadcrumbList',
];
foreach ($breadcrumbs as $k => $breadcrumb) {
$item = [
'@type' => 'ListItem',
'position' => $k + 1,
'name' => $breadcrumb['title'],
];
if (!empty($breadcrumb['link'])) {
$item['item'] = fn_url($breadcrumb['link']);
}
$microdata['itemListElement'][] = $item;
}
return json_encode($microdata);
}
function fn_abt__print_page_murkup ($page)
{

$formatter = Tygh::$app['formatter'];
$company_name = Registry::get('runtime.company_data.company');
$logos = Tygh::$app['view']->getTemplateVars('logos');
$microdata = [
'@context' => 'http://schema.org',
'@type' => $page['abt__ut2_microdata_schema_type'],
'mainEntityOfPage' => [
'@type' => 'WebPage',
'@id' => fn_url('pages.view?page_id=' . $page['page_id']),
],
'headline' => $page['page'],
'image' => empty($page['main_pair']['icon']['image_path']) ? $logos['theme']['image']['image_path'] : $page['main_pair']['icon']['image_path'],
'datePublished' => $formatter->asDatetime($page['timestamp']),
'dateModified' => $formatter->asDatetime($page['timestamp']),
'author' => [
'@type' => 'Person',
'name' => empty($page['author']) ? $company_name : $page['author'],
],
"publisher" => [
'@type' => 'Organization',
'name' => $company_name,
'logo' => [
'@type' => 'ImageObject',
'url' => $logos['theme']['image']['image_path'],
],
],
'description' => fn_truncate_chars(strip_tags($page['description']), 380, "..."),
];
return json_encode($microdata);
}