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

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

function cat_hide()
{
    try {

        $category = db_get_fields("select distinct(parent_id) as category_id from cscart_categories where status = 'A' and parent_id !=0");
//
//        //enable parent categories
        db_query("UPDATE ?:categories SET status = 'A' where category_id in (?n)", $category);
//
        $category = db_get_fields("select distinct(parent_id) as category_id from cscart_categories where status = 'A' and parent_id !=0");
//
//        //refresh enable parent categories
        db_query("UPDATE ?:categories SET status = 'A' where category_id in (?n)", $category);


        return true;

    } catch (PDOException $e) {

        return false;

    }
}

function categories_hide($product_id = 0)
{

    //изменение категорий
    if ($product_id != 0 && is_numeric($product_id)) {

        //если передан product_id то меняем для категорий продукта

        $category_id = db_get_field("select category_id from  ?:products_categories where product_id = ?i ", $product_id);

        if ($category_id) {

            //получение кл-во остатка категорий
            $amount = db_get_field("SELECT sum(p.amount) as amount  FROM ?:products p join ?:products_categories c
                on c.product_id = p.product_id where c.category_id = ?i", $category_id);

            //запись на основную категорию


            $status = "A";

            if ($amount == 0) {
                $status = "H";
            }

            $product_amount = [
                "product_amount" => $amount,
                "status" => $status
            ];

            db_query("UPDATE ?:categories SET ?u where category_id = ?i ", $product_amount, $category_id);

            //скрывание категория с 0 остатком
            cat_hide();

        } else die('Category Not Found');

    } else {

        //иначе меняем все

        //получение кл-во остатка по категориям
        $categories = db_get_array("SELECT c.category_id, sum(p.amount) as amount FROM ?:products p 
                                    INNER JOIN ?:products_categories c  
                                    on c.product_id = p.product_id 
                                    group by c.category_id", array('category_id', 'amount'));

        foreach ($categories as $category) {

            $status = "A";

            if ($category['amount'] == 0) {
                $status = "H";
            }

            //запись на основную категорию

            $product_amount = [
                "product_amount" => $category['amount'],
                "status" => $status
            ];

            db_query("UPDATE ?:categories SET ?u  where category_id = ?i", $product_amount, $category['category_id']);
        }

        //скрывание категория с 0 остатком
        cat_hide();
    }
}

function fn_demons_update_product_pre(&$product_data, $product_id, $lang_code, $can_update)
{

    categories_hide($product_id);

    if (isset($product_data['price']) && $product_data['price'] > 0)
        $product_data['status'] = 'A';
    else
        $product_data['status'] = 'H';

}

function product_check_status($product_id, $amount, $type = true)
{
    //получение текущего количество
    $cur_amount = db_get_field("SELECT amount FROM ?:products where product_id = ?i", $product_id);
    //обновляем количество
    $new_amount = ($type == true) ? ($cur_amount + $amount) : ($cur_amount - $amount);
    //меняем статус
    $status = $new_amount > 0 ? 'A' : 'H';
    //получение текущего количество

    $data = [
        "amount" => $new_amount,
        "status" => $status
    ];

    db_query("update ?:products set ?u where product_id = ?i", $data, $product_id);

    //если продукт не остался обновляем статус категорий

    if ($new_amount == 0) categories_hide($product_id);

}

function fn_demons_gather_additional_product_data_post(&$product, $auth, $params)
{

    $precent = $product['price'] / 100 * 44;
    $new_price = round(($product['price'] + $precent) / 12);
    $product['installment'] = $new_price;


}



