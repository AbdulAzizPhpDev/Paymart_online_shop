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

defined('BOOTSTRAP') or die('Access denied');

$schema['controllers']['installment_orders'] = [
    'modes' => [
        'vendor' => [
            'permissions' => true,
        ],
        'get_barcode' => [
            'permissions' => true,
        ],
        'change_status' => [
            'permissions' => true,
        ],
        'upload_imei' => [
            'permissions' => true,
        ],
        'order_tracking' => [
            'permissions' => true,
        ],
        'delete' => [
            'permissions' => false,
        ],
        'm_delete' => [
            'permissions' => false,
        ],
        /**
         * For add-on Vendor privileges
         */
        'products_and_pages' => [
            'permissions' => true,
        ],
    ],
];

$schema['controllers']['installment'] = [
    'modes' => [
        'manage' => [
            'permissions' => true,
        ],

        'view' => [
            'permissions' => true,
        ],

        'update' => [
            'permissions' => false,
        ],

        'delete' => [
            'permissions' => false,
        ],

        'm_delete' => [
            'permissions' => false,
        ],
        /**
         * For add-on Vendor privileges
         */
        'products_and_pages' => [
            'permissions' => true,
        ],
    ],
];


return $schema;
