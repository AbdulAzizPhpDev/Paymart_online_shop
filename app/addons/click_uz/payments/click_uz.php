<?php

/**
 * @var array $processor_data
 * @var array $order_info
 * @var string $mode
 */

use Tygh\Languages\Languages;
use Tygh\Log;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

$order_id = isset($_REQUEST['order_id'])
    ? $_REQUEST['order_id']
    : null;

Log::info('PAYMENT');

Log::info($order_info);
//$order_info = fn_get_order_info($_POST['merchant_trans_id']);
//Log::info($order_info);


Log::info('PAYMENT_NOTIFICATION: '. (int)defined('PAYMENT_NOTIFICATION'));
// Return from my.click.uz/services/pay
if (defined('PAYMENT_NOTIFICATION')) {

    $processor_data = array();
    if ( fn_check_payment_script('click_uz.php', $_POST['merchant_trans_id'], $processor_data)) {

        $result = array();

        Log::info('type: ' . $mode);

        if ($mode == 'prepare') {

            $result = fn_validate_click_request( $_POST );

        } elseif ($mode == 'complete') {

            $result = fn_validate_click_request( $_POST );

            $order_info = fn_get_order_info($_POST['merchant_trans_id']);

            $formatter = Tygh::$app['formatter'];

            fn_update_order_payment_info($order_info['order_id'], array(
                __('addons.click_uz.click_paydoc_id') => $_POST['click_paydoc_id'],
                __('addons.click_uz.payment_receiving_time') => $formatter->asDatetime(TIME)
            ));

            if( $result['error'] == 0 ) {
                $new_status = $processor_data['processor_params']['paid_status'] ? $processor_data['processor_params']['paid_status'] : 'P';
                fn_change_order_status($order_info['order_id'], $new_status);
            } elseif( $result['error'] == -9 ) {
                fn_change_order_status($order_info['order_id'], 'I');
            } elseif( $result['error'] != -4 ) {
                fn_change_order_status($order_info['order_id'], 'F');
            } elseif( $result['error'] < 0 ) {
                fn_change_order_status($order_info['order_id'], 'F');
            }
        }

        echo json_encode( $result );
    } else {
        echo json_encode( array(
            'error'      => CLICK_ERROR_USER_NOT_EXIST,
            'error_note' => __( 'addons.click_uz.error_transaction_not_exist' )
        ));
    }

} else {



    $click_url = "https://my.click.uz/services/pay/";

    $post_data = array(
        'merchant_id' => $processor_data['processor_params']['merchant_id'],
        'merchant_user_id' => $processor_data['processor_params']['merchant_user_id'],
        'service_id' => $processor_data['processor_params']['service_id'],
        'transaction_param' => $order_info['order_id'],
        'amount' => $order_info['total'],
        'return_url' => fn_url('checkout.complete&order_id=' . $order_info['order_id'] )
    );

    Log::info('сумма для click '.$order_info['total']);

    fn_change_order_status($order_info['order_id'], 'O');

    fn_create_payment_form($click_url, $post_data, 'CLICK Uzbekistan', false, 'get');
}
exit;
