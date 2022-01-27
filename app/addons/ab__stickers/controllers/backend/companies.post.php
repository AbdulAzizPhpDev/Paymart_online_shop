<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2021   *
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
use Tygh\Registry;use Tygh\Enum\YesNo;use Tygh\Enum\ObjectStatuses;if (!defined('BOOTSTRAP')) {
die('Access denied');}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
return [CONTROLLER_STATUS_OK];}
if (call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\142\137\x5f\137\137\137","\142\130\62\170\x63\110\72\154\133\122\76\x3e")),"",["\141\142\137\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\64\137\144\145\x63\157\144\145","\130\126\126\66\141\x47\154\144\125\62\132\157\141\156\x52\61\143\63\157\67\117\62\150\x6d\144\121\75\75")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\x62\130\62\170\143\110\72\x6c\133\122\76\76")),"",["\141\142\137\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\64\137\144\145\x63\157\144\145","\141\155\65\170\142\x58\102\154\132\147\75\75")),"",["\142\141\163\145\66\x34\137\144\145","\143\157\144\x65"]),call_user_func("\141\142\137\137\137\137\x5f","\144\157\127\166\145\110\x6d\165\133\124\66\165\143\x33\123\155"))) == call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\x64\145",call_user_func("\141\142\137\137\x5f\137\137","\142\130\62\170\143\x48\72\154\133\122\76\76")),"",["\141\142\137\137","\137\137\x5f"]),call_user_func("\142\141\163\145\66\64\137\144\x65\143\157\144\145","\141\155\65\170\x62\130\102\154\132\147\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\142\137\x5f\137\137\137","\142\130\62\170\x63\110\72\154\133\122\76\x3e")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145","\144\110\126\x7a\143\62\132\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\x62\130\62\170\143\110\72\x6c\133\122\76\76")),"",["\141\142\137\137","\137\137\137"]),call_user_func("\142\x61\163\145\66\64\137\144\145\143\x6f\144\145","\116\124\144\155\144\107\x4a\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\142\141\x73\145\66\64\137\144\145\x63\157\144\145",call_user_func("\141\142\x5f\137\137\137\137","\142\130\62\x78\143\110\72\154\133\122\x3e\76")),"",["\141\142\x5f\137","\137\137\137"]),call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\144\145","\x64\110\126\172\143\62\132\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\x34\137\144\145\143\157\144\x65",call_user_func("\141\142\137\137\137\x5f\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\141\142\137\137","\137\x5f\137"]),call_user_func("\142\141\163\145\66\64\137\x64\145\143\157\144\145","\132\155\126\x77\132\107\132\154\131\101\75\75")))]),call_user_func("\141\142\137\137\137\137\x5f","\145\131\103\154\132\131\123\x6d"))
&& call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\142\137\x5f\137\137\137","\142\130\62\170\x63\110\72\154\133\122\76\x3e")),"",["\141\142\137\137","\137\137\137"]),call_user_func("\x62\141\163\145\66\64\137\144\145\x63\157\144\145","\130\126\126\66\141\x47\154\144\125\62\132\157\141\156\x52\61\143\63\157\67\117\62\150\x6d\144\121\75\75")),call_user_func(call_user_func("\163\164\162\x72\145\166","\137\x5f\137\137\137\x62\141"),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\131\x6d\126\154\143\x47\71\60\114\x32\112\152\131\x47\102\60\144\x57\160\153\142\x47\132\172\144\x43\71\155\142\x32\112\152\142\x57\132\147\132\x33\102\172\131\x48\144\155\142\x32\126\167\143\x33\121\75"))) == YesNo::YES
&& fn_allowed_for('MULTIVENDOR')
&& (fn_check_view_permissions('ab__stickers.view','GET') || Registry::ifGet('addons.vendor_privileges.status',ObjectStatuses::DISABLED) != ObjectStatuses::ACTIVE)) {
Registry::set('navigation.tabs.ab__stickers',[
'title'=>__('ab__stickers'),'js'=>true,
]);
$repository=Tygh::$app['addons.ab__stickers.repository'];$params=array_merge($_REQUEST,[
'status'=>ObjectStatuses::ACTIVE,
]);list($stickers)=$repository->find($params);
$view=Tygh::$app['view'];$view->assign([
'ab__stickers'=>$stickers,
]);$default_placeholders=[];$conditions_schema=fn_get_schema('ab__stickers','conditions')['dynamic']['conditions'];foreach ($conditions_schema as $condition) {
if (!empty($condition['available_placeholders'])) {
foreach ($condition['available_placeholders'] as $placeholder=>$data) {
if (!empty($data['default_value'])) {
$default_placeholders[$placeholder]=$data['default_value'];}}}}
Tygh::$app['view']->assign('ab__stickers_default_placeholders',$default_placeholders);return [CONTROLLER_STATUS_OK];}
