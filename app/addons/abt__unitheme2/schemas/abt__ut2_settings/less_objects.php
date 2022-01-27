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
use Tygh\Enum\YesNo;
$schema = [
'general' => [
'position' => 100,
'items' => [
'use_rounding' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 100,
'value' => 'full',
'variants' => ['do_not_use', 'little', 'full'],
'value_styles' => [
'Black.less' => 'full',
'Blue.less' => 'little',
'Brick.less' => 'little',
'Cobalt.less' => 'do_not_use',
'Dark_Blue.less' => 'little',
'Dark_Navy.less' => 'little',
'Default.less' => 'little',
'Fiolent.less' => 'full',
'Flame.less' => 'full',
'Gray.less' => 'full',
'Green.less' => 'little',
'Indigo.less' => 'do_not_use',
'Ink.less' => 'little',
'Mint.less' => 'full',
'Original.less' => 'little',
'Powder.less' => 'full',
'Purple.less' => 'full',
'Skyfall.less' => 'full',
'Velvet.less' => 'little',
'White.less' => 'do_not_use',
],
],
'use_titles_uppercase' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'position' => 200,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'N',
'Indigo.less' => 'N',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
'stars_rating_color' => [
'is_for_all_devices' => 'Y',
'type' => 'colorpicker',
'position' => 300,
'value' => '#ffc107',
'value_styles' => [
'Black.less' => '#333333',
'Blue.less' => '#ffc107',
'Brick.less' => '#ea5920',
'Cobalt.less' => '#007aff',
'Dark_Blue.less' => '#ffc107',
'Dark_Navy.less' => '#ffc107',
'Default.less' => '#0077cc',
'Fiolent.less' => '#f25529',
'Flame.less' => '#be0318',
'Gray.less' => '#ff9800',
'Green.less' => '#43b02a',
'Indigo.less' => '#792c9b',
'Ink.less' => '#ed1e63',
'Mint.less' => '#ff6457',
'Original.less' => '#00a9aa',
'Powder.less' => '#ff7f66',
'Purple.less' => '#c51162',
'Skyfall.less' => '#e25945',
'Velvet.less' => '#cc9900',
'White.less' => '#a1497e',
],
],
'buttons' => [
'position' => 200,
'is_group' => 'Y',
'items' => [
'style' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 100,
'value' => 'use_background',
'variants' => ['use_background', 'use_border'],
'value_styles' => [
'Black.less' => 'use_background',
'Blue.less' => 'use_background',
'Brick.less' => 'use_background',
'Cobalt.less' => 'use_background',
'Dark_Blue.less' => 'use_background',
'Dark_Navy.less' => 'use_background',
'Default.less' => 'use_background',
'Fiolent.less' => 'use_background',
'Flame.less' => 'use_background',
'Gray.less' => 'use_background',
'Green.less' => 'use_background',
'Indigo.less' => 'use_background',
'Ink.less' => 'use_background',
'Mint.less' => 'use_background',
'Original.less' => 'use_background',
'Powder.less' => 'use_background',
'Purple.less' => 'use_background',
'Skyfall.less' => 'use_background',
'Velvet.less' => 'use_background',
'White.less' => 'use_background',
],
],
'use_text_uppercase' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 200,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'Y',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'N',
'Indigo.less' => 'Y',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
'use_shadow' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 400,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'Y',
'Brick.less' => 'Y',
'Cobalt.less' => 'Y',
'Dark_Blue.less' => 'Y',
'Dark_Navy.less' => 'Y',
'Default.less' => 'Y',
'Fiolent.less' => 'Y',
'Flame.less' => 'Y',
'Gray.less' => 'Y',
'Green.less' => 'Y',
'Indigo.less' => 'Y',
'Ink.less' => 'Y',
'Mint.less' => 'N',
'Original.less' => 'Y',
'Powder.less' => 'Y',
'Purple.less' => 'Y',
'Velvet.less' => 'Y',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
'use_gradient' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 500,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'N',
'Indigo.less' => 'N',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
],
],
'labels' => [
'position' => 300,
'is_group' => 'Y',
'items' => [
'style' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 100,
'value' => 'as_drop',
'variants' => ['as_drop', 'as_circle', 'as_rectangle'],
'value_styles' => [
'Black.less' => 'as_drop',
'Blue.less' => 'as_drop',
'Brick.less' => 'as_drop',
'Cobalt.less' => 'as_drop',
'Dark_Blue.less' => 'as_drop',
'Dark_Navy.less' => 'as_drop',
'Default.less' => 'as_drop',
'Fiolent.less' => 'as_drop',
'Flame.less' => 'as_rectangle',
'Gray.less' => 'as_drop',
'Green.less' => 'as_drop',
'Indigo.less' => 'as_drop',
'Ink.less' => 'as_drop',
'Mint.less' => 'as_drop',
'Original.less' => 'as_drop',
'Powder.less' => 'as_drop',
'Purple.less' => 'as_drop',
'Skyfall.less' => 'as_drop',
'Velvet.less' => 'as_drop',
'White.less' => 'as_drop',
],
],
'use_outline' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 410,
'value' => 'N',
'value_styles' => [
'Black.less' => 'Y',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'Y',
'Gray.less' => 'Y',
'Green.less' => 'Y',
'Indigo.less' => 'Y',
'Ink.less' => 'N',
'Mint.less' => 'Y',
'Original.less' => 'N',
'Powder.less' => 'Y',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'Y',
'White.less' => 'N',
],
],
'use_shadow' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 420,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'N',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
'use_text_shadow' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'class' => 'input-big',
'position' => 430,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'N',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Velvet.less' => 'N',
'Skyfall.less' => 'N',
'White.less' => 'N',
],
],
],
],
'browser_interface_bg' => [
'type' => 'colorpicker',
'position' => 700,
'value' => '',
'value_styles' => [
'Black.less' => '',
'Blue.less' => '',
'Brick.less' => '',
'Cobalt.less' => '',
'Dark_Blue.less' => '',
'Dark_Navy.less' => '',
'Default.less' => '',
'Fiolent.less' => '',
'Flame.less' => '',
'Gray.less' => '',
'Green.less' => '',
'Indigo.less' => '',
'Ink.less' => '',
'Mint.less' => '',
'Original.less' => '',
'Powder.less' => '',
'Purple.less' => '',
'Skyfall.less' => '',
'Velvet.less' => '',
'White.less' => '',
],
'is_for_all_devices' => YesNo::YES,
],
],
],
'containers' => [
'position' => 200,
'items' => [
'header' => [
'position' => 100,
'is_group' => 'Y',
'items' => [
'add_delimiters' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'position' => 100,
'value' => 'N',
'value_styles' => [
'Black.less' => 'N',
'Blue.less' => 'N',
'Brick.less' => 'N',
'Cobalt.less' => 'N',
'Dark_Blue.less' => 'N',
'Dark_Navy.less' => 'N',
'Default.less' => 'N',
'Fiolent.less' => 'N',
'Flame.less' => 'N',
'Gray.less' => 'N',
'Green.less' => 'Y',
'Indigo.less' => 'N',
'Ink.less' => 'N',
'Mint.less' => 'N',
'Original.less' => 'N',
'Powder.less' => 'N',
'Purple.less' => 'N',
'Skyfall.less' => 'N',
'Velvet.less' => 'N',
'White.less' => 'N',
],
],
'use_color_menu_on_hover' => [
'is_for_all_devices' => 'Y',
'type' => 'colorpicker',
'position' => 200,
'value' => '',
'value_styles' => [
'Black.less' => '#333333',
'Blue.less' => '#cceaf6',
'Brick.less' => '#dc4d15',
'Cobalt.less' => '#0563d0',
'Dark_Blue.less' => '#f3f4f7',
'Dark_Navy.less' => '#f3f4f7',
'Default.less' => '#ffef9a',
'Fiolent.less' => '#3e4895',
'Flame.less' => '#a50315',
'Gray.less' => '#e3e3e3',
'Green.less' => '#379424',
'Indigo.less' => '#17a285',
'Ink.less' => '#182b4a',
'Mint.less' => '#88d2d3',
'Original.less' => '#2b2b2b',
'Powder.less' => '#e5684e',
'Purple.less' => '#6200ee',
'Skyfall.less' => '#eeeeee',
'Velvet.less' => '#595959',
'White.less' => '#eeeeee',
],
],
'use_color_elements_on_hover' => [
'is_for_all_devices' => 'Y',
'type' => 'colorpicker',
'position' => 300,
'value' => '',
'value_styles' => [
'Black.less' => '#333333',
'Blue.less' => '#cceaf6',
'Brick.less' => '#dc4d15',
'Cobalt.less' => '#056be0',
'Dark_Blue.less' => '#f3f4f7',
'Dark_Navy.less' => '#f3f4f7',
'Default.less' => '#ffef9a',
'Fiolent.less' => '#3e4895',
'Flame.less' => '#a50315',
'Gray.less' => '#e3e3e3',
'Green.less' => '#379424',
'Indigo.less' => '#17a285',
'Ink.less' => '#182b4a',
'Mint.less' => '#88d2d3',
'Original.less' => '#2b2b2b',
'Powder.less' => '#e5684e',
'Purple.less' => '#6200ee',
'Skyfall.less' => '#eeeeee',
'Velvet.less' => '#595959',
'White.less' => '#eeeeee',
],
],
'use_color_icons' => [
'is_for_all_devices' => 'Y',
'type' => 'colorpicker',
'position' => 400,
'value' => '',
'value_styles' => [
'Black.less' => '#c1c1c1',
'Blue.less' => '#767676',
'Brick.less' => '#fbd7ca',
'Cobalt.less' => '#a6cbff',
'Dark_Blue.less' => '#24488e',
'Dark_Navy.less' => '#00bcd4',
'Default.less' => '#363636',
'Fiolent.less' => '#c6c9e0',
'Flame.less' => '#ffffff',
'Gray.less' => '#949494',
'Green.less' => '#ffffff',
'Indigo.less' => '#b2e5d8',
'Ink.less' => '#c7ccd7',
'Mint.less' => '#2f353e',
'Original.less' => '#00a9aa',
'Powder.less' => '#ffddd6',
'Purple.less' => '#d9c5fc',
'Skyfall.less' => '#000000',
'Velvet.less' => '#d9d9d9',
'White.less' => '#919191',
],
],
'use_animation_for_not_empty_cart' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'position' => 500,
'value' => 'Y',
'value_styles' => [
'Black.less' => 'Y',
'Blue.less' => 'Y',
'Brick.less' => 'Y',
'Cobalt.less' => 'Y',
'Dark_Blue.less' => 'Y',
'Dark_Navy.less' => 'Y',
'Default.less' => 'Y',
'Fiolent.less' => 'Y',
'Flame.less' => 'Y',
'Gray.less' => 'Y',
'Green.less' => 'Y',
'Indigo.less' => 'Y',
'Ink.less' => 'Y',
'Mint.less' => 'Y',
'Original.less' => 'Y',
'Powder.less' => 'Y',
'Purple.less' => 'Y',
'Skyfall.less' => 'Y',
'Velvet.less' => 'Y',
'White.less' => 'Y',
],
],
],
],
],
],
'product_list' => [
'position' => 300,
'items' => [
'show_grid_border' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 100,
'value' => 'solid_with_margins',
'variants' => ['none', 'solid_without_margins', 'solid_with_margins'],
'value_styles' => [
'Black.less' => 'solid_without_margins',
'Blue.less' => 'solid_without_margins',
'Brick.less' => 'solid_without_margins',
'Cobalt.less' => 'solid_without_margins',
'Dark_Blue.less' => 'solid_without_margins',
'Dark_Navy.less' => 'solid_without_margins',
'Default.less' => 'solid_without_margins',
'Fiolent.less' => 'solid_without_margins',
'Flame.less' => 'solid_without_margins',
'Gray.less' => 'none',
'Green.less' => 'solid_without_margins',
'Indigo.less' => 'none',
'Ink.less' => 'solid_without_margins',
'Mint.less' => 'solid_without_margins',
'Original.less' => 'solid_without_margins',
'Powder.less' => 'solid_without_margins',
'Purple.less' => 'solid_without_margins',
'Skyfall.less' => 'solid_without_margins',
'Velvet.less' => 'solid_without_margins',
'White.less' => 'solid_without_margins',
],
],
'use_elements_alignment' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 200,
'value' => 'use',
'variants' => ['use', 'do_not_use'],
'value_styles' => [
'Black.less' => 'use',
'Blue.less' => 'use',
'Brick.less' => 'use',
'Cobalt.less' => 'use',
'Dark_Blue.less' => 'use',
'Dark_Navy.less' => 'use',
'Default.less' => 'use',
'Fiolent.less' => 'use',
'Flame.less' => 'use',
'Gray.less' => 'use',
'Green.less' => 'use',
'Indigo.less' => 'do_not_use',
'Ink.less' => 'use',
'Mint.less' => 'use',
'Original.less' => 'use',
'Powder.less' => 'use',
'Purple.less' => 'use',
'Skyfall.less' => 'use',
'Velvet.less' => 'use',
'White.less' => 'use',
],
],
'extend_grid_item_on_hover' => [
'is_for_all_devices' => 'Y',
'type' => 'checkbox',
'position' => 300,
'value' => 'Y',
'value_styles' => [
'Black.less' => 'Y',
'Blue.less' => 'Y',
'Brick.less' => 'Y',
'Cobalt.less' => 'Y',
'Dark_Blue.less' => 'Y',
'Dark_Navy.less' => 'Y',
'Default.less' => 'Y',
'Fiolent.less' => 'Y',
'Flame.less' => 'Y',
'Gray.less' => 'Y',
'Green.less' => 'Y',
'Indigo.less' => 'Y',
'Ink.less' => 'Y',
'Mint.less' => 'Y',
'Original.less' => 'Y',
'Powder.less' => 'Y',
'Purple.less' => 'Y',
'Skyfall.less' => 'Y',
'Velvet.less' => 'Y',
'White.less' => 'Y',
],
],
'grid-list' => [
'position' => 100,
'is_group' => 'Y',
'items' => [
'product_name_font_weight' => [
'is_for_all_devices' => 'Y',
'type' => 'selectbox',
'class' => 'input-big',
'position' => 100,
'value' => 'name_font_waight',
'variants' => ['normal', 'bold'],
'value_styles' => [
'Black.less' => 'normal',
'Blue.less' => 'normal',
'Brick.less' => 'normal',
'Cobalt.less' => 'normal',
'Dark_Blue.less' => 'normal',
'Dark_Navy.less' => 'normal',
'Default.less' => 'normal',
'Fiolent.less' => 'normal',
'Flame.less' => 'normal',
'Gray.less' => 'normal',
'Green.less' => 'normal',
'Indigo.less' => 'normal',
'Ink.less' => 'normal',
'Mint.less' => 'normal',
'Original.less' => 'normal',
'Powder.less' => 'normal',
'Purple.less' => 'normal',
'Skyfall.less' => 'normal',
'Velvet.less' => 'normal',
'White.less' => 'normal',
],
],
],
],
],
],
'products' => [
'position' => 400,
'items' => [
'use_color_buttons_add_to_cart' => [
'is_for_all_devices' => 'Y',
'type' => 'colorpicker',
'position' => 100,
'value' => '',
'value_styles' => [
'Black.less' => '#000000',
'Blue.less' => '#105990',
'Brick.less' => '#ea5920',
'Cobalt.less' => '#ff4b36',
'Dark_Blue.less' => '#ffc107',
'Dark_Navy.less' => '#00bcd4',
'Default.less' => '#07c',
'Fiolent.less' => '#f25529',
'Flame.less' => '#be0318',
'Gray.less' => '#039be5',
'Green.less' => '#ff671f',
'Indigo.less' => '#792c9b',
'Ink.less' => '#2a4878',
'Mint.less' => '#9ee0e1',
'Original.less' => '#00a9aa',
'Powder.less' => '#f67055',
'Purple.less' => '#c51062',
'Skyfall.less' => '#10b9e4',
'Velvet.less' => '#cc9900',
'White.less' => '#2e2e2e',
],
],
],
],
'addons' => [
'position' => 500,
'items' => [
],
],
];
return $schema;
