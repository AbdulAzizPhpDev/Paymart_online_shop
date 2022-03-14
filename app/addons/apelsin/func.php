<?php

use Tygh\Log;
use Tygh\Registry;

function fn_apelsin_install() {
    Log::info('apelsin ' . __METHOD__);
    fn_apelsin_uninstall();

    $_data = array(
        'processor' => 'Apelsin Uzbekistan',
        'processor_script' => 'apelsin.php',
        'processor_template' => '',
        'admin_template' => 'apelsin.tpl',
        'callback' => 'N',
        'type' => 'P',
        'addon' => 'apelsin'
    );

    db_query("INSERT INTO ?:payment_processors ?e", $_data);
}

function fn_apelsin_uninstall() {
    Log::info('apelsin ' . __METHOD__);
    db_query("DELETE FROM ?:payment_processors WHERE processor_script = ?s", "apelsin.php");
}

// проверка пользователя
function apelsin_check_user()
{

    $login_data = [
        'user_login'=>$_SERVER['PHP_AUTH_USER'],
        'password' =>$_SERVER['PHP_AUTH_PW']
    ];

    $user_data = db_get_row("SELECT * FROM ?:users WHERE email = ?s",  $login_data['user_login']);

    if (fn_password_verify($login_data['password'], $user_data['password'], '')) {
        Log::info('оплата с помощью APELSIN');
        return true;
    }

    return false;

}
/*function fn_is_apelsin_payment_received($order_id) {
    $order_info = fn_get_order_info($order_id);
    Log::info('is_apelsin_payment_received');
    Log::info($order_info);
    return !empty($order_info['payment_info']['payment_receiving_time']);
} */

function fn_apelsin_user_init(&$auth, &$user_info, &$first_init)
{
   // Log::info('apelsin ' . __METHOD__);

    return true;

    /*$orders_list = array();
    if (!empty(Tygh::$app['session']['cart']['processed_order_id'])) {
        $orders_list = array_merge($orders_list, (array)Tygh::$app['session']['cart']['processed_order_id']);
    }
    if (!empty(Tygh::$app['session']['cart']['failed_order_id'])) {
        $orders_list = array_merge($orders_list, (array)Tygh::$app['session']['cart']['failed_order_id']);
    }


    Log::info('orders_list BEFORE ');
    Log::info($orders_list);
    foreach ($orders_list as $order_id) {
        //if (fn_is_apelsin_payment_received($order_id)) {
            fn_clear_cart(Tygh::$app['session']['cart'], true, true);
            break;
        //}
    }
    Log::info('orders_list AFTER ');
    Log::info($orders_list); */

}

// проверка платежа
function fn_validate_apelsin_request( $order_info,$post_data ) {

    Log::info('apelsin validate');
    Log::info($order_info);

    $result['error'] = APELSIN_SUCCESS;

    if ( $order_info['status'] == 'P') { // если уже оплачен
        Log::info('ERROR ORDER ALREADY PAID ' . $order_info['order_id']);
        return ['error' => APELSIN_ERROR_ALREADY_PAID];
    }

    if ( $order_info['status'] != 'O') { // если не в ожидании оплаты
        Log::info('ERROR ORDER NOT OPEN ' . $order_info['order_id']);
        return ['error' => APELSIN_ERROR_ORDER_NOT_FOUND];
    }

    if($order_info['order_id'] != $post_data['order_id']){ // неверный заказ
        Log::info('ERROR APELSIN_ERROR_ORDER_NOT_FOUND order_id ' . $order_info['order_id']);
        return ['error'=>APELSIN_ERROR_ORDER_NOT_FOUND];
    }

    Log::info('APELSIN_AMOUNT. сумма: ' . $order_info['total']*100 . ' оплачено: ' . $post_data['amount']);

    if($order_info['total']*100 != $post_data['amount']){ // неверная сумма
        Log::info('ERROR APELSIN_ERROR_AMOUNT. сумма: ' . $order_info['total']*100 . ' оплачено: ' . $post_data['amount']);
        return ['error'=>APELSIN_ERROR_AMOUNT];
    }

    return $result;

}

// удаляем траблу доставки при прохождением оплаты
// для функции fn.cart.php->fn_allow_place_order()
function fn_apelsin_allow_place_order_post(&$cart, $auth, $parent_order_id, $total, $result){

    //Log::info('apelsin allow place order');
    unset($cart['shipping_failed']);
    unset($cart['company_shipping_failed']);

}
