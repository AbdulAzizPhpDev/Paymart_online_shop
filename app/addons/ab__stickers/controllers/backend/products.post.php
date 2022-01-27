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
use Tygh\Registry;if (!defined('BOOTSTRAP')) {
die('Access denied');}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
return;}
if (call_user_func(call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\145\66\x34\137\144\145\143\157\144\x65",call_user_func("\141\142\137\137\137\x5f\137","\142\130\62\170\143\110\x3a\154\133\122\76\76")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\141\x6d\65\170\142\x58\102\154\132\x67\75\75")),"",[call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\145\x36\64\137\144\145\143\157\x64\145",call_user_func("\141\142\137\137\x5f\137\137","\142\130\62\170\143\x48\72\154\133\122\76\76")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\144\x48\126\172\143\x32\132\63")),call_user_func(call_user_func(call_user_func("\x62\141\163\145\66\64\137\x64\145\143\157\144\145",call_user_func("\x61\142\137\137\137\137\137","\142\x58\62\170\143\110\72\154\x5b\122\76\76")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\116\x54\144\155\144\x47\112\152"))),call_user_func(call_user_func(call_user_func(call_user_func("\142\141\163\x65\66\64\137\144\145\143\x6f\144\145",call_user_func("\141\142\137\x5f\137\137\137","\142\130\62\170\x63\110\72\154\133\122\76\x3e")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\144\x48\126\172\143\x32\132\63")),call_user_func(call_user_func(call_user_func("\142\141\163\145\66\64\x5f\144\145\143\157\144\145",call_user_func("\141\142\137\137\137\137\x5f","\x62\130\62\170\143\110\72\x6c\133\122\76\76")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\132\x6d\126\167\132\x47\132\154\131\x41\75\75")))]),call_user_func("\x61\x62\x5f\x5f\x5f\x5f\x5f","\x59\x47\x53\x36\x5b\x33\x69\x64\x56\x6e\x57\x6f\x62\x59\x4f\x31\x64\x6f\x6c\x37\x50\x6e\x65\x6d\x65\x42\x3e\x3e")),call_user_func(call_user_func(call_user_func(call_user_func(call_user_func("\x62\141\163\145\66\64\137\x64\145\143\157\144\145",call_user_func("\x61\142\137\137\137\137\137","\142\x58\62\170\143\110\72\154\x5b\122\76\76")),"",["\141\x62\137\137","\137\x5f\137"]),call_user_func("\142\141\x73\145\66\64\x5f\144\145\143\x6f\144\145","\141\x6d\65\170\142\x58\102\154\132\x67\75\75")),"",["\142\141\163\145\66\64\x5f\144\145","\143\157\144\145"]),call_user_func("\x61\142\137\137\137\137\137","\x64\157\127\166\145\110\155\x75\133\124\66\165\143\63\x53\155"))) == 'update' && fn_check_permissions('ab__stickers','view','admin')) {
$tabs=Registry::get('navigation.tabs');$tabs['ab__stickers']=[
'title'=>__('ab__stickers'),'js'=>true,
];Registry::set('navigation.tabs',$tabs);
$repository=Tygh::$app['addons.ab__stickers.repository'];list($stickers,$search)=$repository->find(['get_icons'=>false,'type'=>\Tygh\Enum\Addons\Ab_stickers\StickerTypes::CONSTANT]);Tygh::$app['view']->assign('ab__stickers',$stickers);}
