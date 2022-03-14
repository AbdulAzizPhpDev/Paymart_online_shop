<?php

use Tygh\Log;
use Tygh\Registry;

function fn_click_uz_install() {
    fn_click_uz_uninstall();

    $_data = array(
        'processor' => 'Click Uzbekistan',
        'processor_script' => 'click_uz.php',
        'processor_template' => '',
        'admin_template' => 'click_uz.tpl',
        'callback' => 'N',
        'type' => 'P',
        'addon' => 'click_uz'
    );

    db_query("INSERT INTO ?:payment_processors ?e", $_data);
}

function fn_click_uz_uninstall() {
    db_query("DELETE FROM ?:payment_processors WHERE processor_script = ?s", "click_uz.php");
}

function fn_click_uz_user_init(&$auth, &$user_info, &$first_init)
{
    $orders_list = array();
    if (!empty(Tygh::$app['session']['cart']['processed_order_id'])) {
        $orders_list = array_merge($orders_list, (array)Tygh::$app['session']['cart']['processed_order_id']);
    }
    if (!empty(Tygh::$app['session']['cart']['failed_order_id'])) {
        $orders_list = array_merge($orders_list, (array)Tygh::$app['session']['cart']['failed_order_id']);
    }
    foreach ($orders_list as $order_id) {
        if (fn_is_click_uz_payment_received($order_id)) {
            fn_clear_cart(Tygh::$app['session']['cart'], true, true);
            break;
        }
    }
}

function fn_settings_variants_addons_click_uz_paid_status() {
    $data = array(
        '' => ' -- '
    );

    foreach (fn_get_statuses(STATUSES_ORDER) as $status) {
        $data[$status['status']] = $status['description'];
    }

    return $data;
}

function fn_is_click_uz_payment_received($order_id) {
    $order_info = fn_get_order_info($order_id);

    return !empty($order_info['payment_info']['addons.click_uz.payment_receiving_time']);
}

function fn_validate_click_request( $data ) {

    if( ! isset(
        $data['click_trans_id'],
        $data['service_id'],
        $data['merchant_trans_id'],
        $data['amount'],
        $data['action'],
        $data['sign_time']) ||
        $data['action'] == 1 && ! isset($data['merchant_prepare_id'])
    ) {

        Log::info('sign check ERROR!');

        return array(
            'error'      => CLICK_ERROR_IN_REQUEST,
            'error_note' => __( 'addons.click_uz.error_in_request' )
        );
    }

    $result['error'] = CLICK_SUCCESS;  // 0

    $result['error_note'] = __('addons.click_uz.success');

    $result['click_trans_id'] = $_POST['click_trans_id'];

    $result['merchant_trans_id'] = $_POST['merchant_trans_id'];

    if( $data['action'] == 0 ) {
        $result['merchant_prepare_id'] = $_POST['merchant_trans_id'];
    } else {
        $result['merchant_confirm_id'] = $_POST['merchant_trans_id'];
    }

    $mode = $data['action']==1 ? 'complete' : 'prepare';
    Log::info('mode: '.$mode);

    // получаем order по merchant_trans_id
    $order = fn_get_order_info($data['merchant_trans_id']);
    // Log::info($order);

    // попытка повторного подтверждения или отмены
    // логика, если несколько товаров в заказе, возможно этот блок не нужен, т.к. за раз покупается 1 товар с конкретным order_id
    if( $mode=='complete' && $data['merchant_prepare_id'] == $data['merchant_trans_id'] && $order['status']=='T' && $order['is_parent_order']=='Y') {

        if ($child_orders = db_get_hash_single_array(
            'SELECT order_id, status' .
            ' FROM ?:orders' .
            ' WHERE parent_order_id = ?i',
            ['order_id', 'status'],
            $order['order_id']
        )) {

            foreach ($child_orders as $id=>$status) {

                if($data['error']==-5017 && $status=='I'){
                    return array_merge($result, array(  // -9
                        'error' => CLICK_ERROR_TRANSACTION_CANCELLED,
                        'error_note' => __('addons.click_uz.error_transaction_cancelled')
                    ));
                }elseif( $data['error']<0 && $status == 'P' ) { // ранее оплаченый

                    return array_merge($result, array(  // -4
                        'error' => CLICK_ERROR_ALREADY_PAID,
                        'error_note' => __('addons.click_uz.error_already_paid')
                    ));

                } elseif ( ($data['error']<0 && $status == 'F') || ($data['error']==0 && $status=='I') ) { // ранее отмененный

                    return array_merge($result, array(  // -9
                        'error' => CLICK_ERROR_TRANSACTION_CANCELLED,
                        'error_note' => __('addons.click_uz.error_transaction_cancelled')
                    ));

                }elseif( $data['error']==0 && $status == 'P' ) { // ранее оплаченый
                    return array_merge($result, array(  // -4
                        'error' => CLICK_ERROR_ALREADY_PAID,
                        'error_note' => __('addons.click_uz.error_already_paid')
                    ));
                }
            }
        }

    }

    // получаем id платежной системы
    $processor_data = fn_get_processor_data($order['payment_id']);

    Log::info($processor_data);

    $signString = $data['click_trans_id'] .
                  $data['service_id'] .
                  $processor_data['processor_params']['secret_key'].
                  $data['merchant_trans_id'] .
                  ($data['action'] == 1 ? $data['merchant_prepare_id'] : '') .
                  $data['amount'] .
                  $data['action'] .
                  $data['sign_time'];

    $signString = md5( $signString );

    if ( $signString !== $data['sign_string'] ) {

        return array_merge($result, array(   // -1
            'error'      => CLICK_ERROR_SIGN_CHECK,
            'error_note' => __( 'addons.click_uz.error_sign_check' ),
            'info' => $signString .' = '. $data['sign_string']
        ));
    }
    if( abs($order['total'] - (float)$data['amount']) > 0.01 ) {
        return array_merge($result, array(  // -2
            'error'      => CLICK_ERROR_AMOUNT,
            'error_note' => __( 'addons.click_uz.error_amount' )
        ));
    }

    if( ! in_array($data['action'], array(0,1) ) ) {
        return array_merge($result, array(  // -3
            'error'      => CLICK_ERROR_ACTION_NOT_FOUND,
            'error_note' => __( 'addons.click_uz.error_action_not_found' )
        ));
    }
    $result['status'] = $order['status'];
    $result['order_status'] = $processor_data['processor_params']['paid_status'];

    //Log::info($order['status']);

    if ( $order['status'] == 'P') { // если режим не prepare то проверить
        return array_merge($result, array(  // -4
            'error'      => CLICK_ERROR_ALREADY_PAID,
            'error_note' => __( 'addons.click_uz.error_already_paid' )
        ));
    }

    if( ! $order ) {
        return array_merge($result, array( // -5
            'error'      => CLICK_ERROR_USER_NOT_EXIST,
            'error_note' => __( 'addons.click_uz.error_user_not_exist' )
        ));
    }

    if( $data['action'] == 1 && $data['merchant_prepare_id'] != $data['merchant_trans_id'] ) {
        return array_merge($result, array(  // -6
            'error'      => CLICK_ERROR_TRANSACTION_NOT_EXIST,
            'error_note' => __( 'addons.click_uz.error_transaction_not_exist' )
        ));
    }

    if( $data['error'] < 0 || $data['error'] == 0 && $order['status'] == 'I') {
        return array_merge($result, array(  // -9
            'error'      => CLICK_ERROR_TRANSACTION_CANCELLED,
            'error_note' => __( 'addons.click_uz.error_transaction_cancelled' )
        ));
    }

    return $result;
}

// удаляем траблу доставки при прохождением оплаты
// для функции fn.cart.php->fn_allow_place_order()
function fn_click_uz_allow_place_order_post(&$cart, $auth, $parent_order_id, $total, $result){
   // Log::info('click allow place order');
    unset($cart['shipping_failed']);
    unset($cart['company_shipping_failed']);

}
