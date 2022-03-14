<?php

// удаляем траблу доставки при прохождением оплаты
// для функции fn.cart.php->fn_allow_place_order()
use Tygh\Log;

function fn_payme_allow_place_order_post(&$cart, $auth, $parent_order_id, $total, $result){

    Log::info('payme allow place order');

    unset($cart['shipping_failed']);
    unset($cart['company_shipping_failed']);

}