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

namespace Tygh\Enum\Addons\Installment;

class InstallmentVar
{
    const Pages = [
        0 => 'index',
        1 => 'card-add',
        2 => 'await',
        6 => 'await',
        4 => 'contract-create',
        5 => 'type-passport',
        10 => 'type-passport',
        11 => 'type-passport',
        12 => 'guarant',
        8 => 'refusal',
    ];

//    public static function getAll()
//    {
//        return array(
//            self::SEMICOLON => ';',
//            self::COMMA     => ',',
//            self::TAB       => "\t",
//        );
//    }
}