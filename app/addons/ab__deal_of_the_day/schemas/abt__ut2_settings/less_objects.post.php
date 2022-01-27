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
use Tygh\Enum\YesNo;
$schema['addons']['items']['ab__deal_of_the_day'] = [
'position' => 100,
'is_group' => YesNo::YES,
'items' => [
'block_background' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'colorpicker',
'position' => 100,
'value' => '#ffffff',
'value_styles' => [
'Black.less' => '#ffffff',
'Blue.less' => '#ffffff',
'Brick.less' => '#ffffff',
'Cobalt.less' => '#ffffff',
'Dark_Blue.less' => '#ffffff',
'Dark_Navy.less' => '#ffffff',
'Default.less' => '#ffffff',
'Fiolent.less' => '#ffffff',
'Flame.less' => '#ffffff',
'Gray.less' => '#ffffff',
'Green.less' => '#ffffff',
'Indigo.less' => '#ffffff',
'Ink.less' => '#ffffff',
'Mint.less' => '#ffffff',
'Original.less' => '#ffffff',
'Powder.less' => '#ffffff',
'Purple.less' => '#ffffff',
'Skyfall.less' => '#ffffff',
'Velvet.less' => '#ffffff',
'White.less' => '#ffffff',
],
],
'block_fonts_color' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'colorpicker',
'position' => 100,
'value' => '#000000',
'value_styles' => [
'Black.less' => '#000000',
'Blue.less' => '#1e1e1e',
'Brick.less' => '#1e1e1e',
'Cobalt.less' => '#1e1e1e',
'Dark_Blue.less' => '#191b1e',
'Dark_Navy.less' => '#000000',
'Default.less' => '#000000',
'Fiolent.less' => '#000000',
'Flame.less' => '#000000',
'Gray.less' => '#000000',
'Green.less' => '#000000',
'Indigo.less' => '#333333',
'Ink.less' => '#333333',
'Mint.less' => '#2a2c30',
'Original.less' => '#363636',
'Powder.less' => '#000000',
'Purple.less' => '#000000',
'Skyfall.less' => '#000000',
'Velvet.less' => '#000000',
'White.less' => '#1e1e1e',
],
],
'bright_color_promotion_title' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::YES,
'value_styles' => [
'Black.less' => YesNo::YES,
'Blue.less' => YesNo::YES,
'Brick.less' => YesNo::YES,
'Cobalt.less' => YesNo::YES,
'Dark_Blue.less' => YesNo::YES,
'Dark_Navy.less' => YesNo::YES,
'Default.less' => YesNo::YES,
'Fiolent.less' => YesNo::YES,
'Flame.less' => YesNo::YES,
'Gray.less' => YesNo::YES,
'Green.less' => YesNo::YES,
'Indigo.less' => YesNo::YES,
'Ink.less' => YesNo::YES,
'Mint.less' => YesNo::YES,
'Original.less' => YesNo::YES,
'Powder.less' => YesNo::YES,
'Purple.less' => YesNo::YES,
'Skyfall.less' => YesNo::YES,
'Velvet.less' => YesNo::YES,
'White.less' => YesNo::YES,
],
],
'bordered_block' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::YES,
'value_styles' => [
'Black.less' => YesNo::YES,
'Blue.less' => YesNo::YES,
'Brick.less' => YesNo::YES,
'Cobalt.less' => YesNo::YES,
'Dark_Blue.less' => YesNo::YES,
'Dark_Navy.less' => YesNo::YES,
'Default.less' => YesNo::YES,
'Fiolent.less' => YesNo::YES,
'Flame.less' => YesNo::YES,
'Gray.less' => YesNo::YES,
'Green.less' => YesNo::YES,
'Indigo.less' => YesNo::YES,
'Ink.less' => YesNo::YES,
'Mint.less' => YesNo::YES,
'Original.less' => YesNo::YES,
'Powder.less' => YesNo::YES,
'Purple.less' => YesNo::YES,
'Skyfall.less' => YesNo::YES,
'Velvet.less' => YesNo::YES,
'White.less' => YesNo::YES,
],
],
'shadow_block' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::NO,
'value_styles' => [
'Black.less' => YesNo::NO,
'Blue.less' => YesNo::NO,
'Brick.less' => YesNo::NO,
'Cobalt.less' => YesNo::NO,
'Dark_Blue.less' => YesNo::NO,
'Dark_Navy.less' => YesNo::NO,
'Default.less' => YesNo::NO,
'Fiolent.less' => YesNo::NO,
'Flame.less' => YesNo::NO,
'Gray.less' => YesNo::NO,
'Green.less' => YesNo::NO,
'Indigo.less' => YesNo::NO,
'Ink.less' => YesNo::NO,
'Mint.less' => YesNo::NO,
'Original.less' => YesNo::NO,
'Powder.less' => YesNo::NO,
'Purple.less' => YesNo::NO,
'Skyfall.less' => YesNo::NO,
'Velvet.less' => YesNo::NO,
'White.less' => YesNo::NO,
],
],
'rounded_corners_blocks' => [
'is_for_all_devices' => YesNo::YES,
'type' => 'checkbox',
'position' => 100,
'value' => YesNo::YES,
'value_styles' => [
'Black.less' => YesNo::YES,
'Blue.less' => YesNo::YES,
'Brick.less' => YesNo::YES,
'Cobalt.less' => YesNo::YES,
'Dark_Blue.less' => YesNo::YES,
'Dark_Navy.less' => YesNo::YES,
'Default.less' => YesNo::YES,
'Fiolent.less' => YesNo::YES,
'Flame.less' => YesNo::YES,
'Gray.less' => YesNo::YES,
'Green.less' => YesNo::YES,
'Indigo.less' => YesNo::YES,
'Ink.less' => YesNo::YES,
'Mint.less' => YesNo::YES,
'Original.less' => YesNo::YES,
'Powder.less' => YesNo::YES,
'Purple.less' => YesNo::YES,
'Skyfall.less' => YesNo::YES,
'Velvet.less' => YesNo::YES,
'White.less' => YesNo::YES,
],
],
],
];
return $schema;