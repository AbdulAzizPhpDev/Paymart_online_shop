<?php

/**
 * @var array $processor_data
 * @var array $order_info
 * @var string $mode
 */

use Tygh\Languages\Languages;
use Tygh\Log;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

Log::info('PAYMENT APELSIN');


$order_id = isset($_REQUEST['order_id'])
    ? $_REQUEST['order_id']
    : null;


Log::info('mode: ' . $mode);

Log::info('REQUEST');
Log::info( $_REQUEST);
//Log::info('processor data');
//Log::info( $processor_data);
Log::info('order_info');
Log::info($order_info);



if (defined('PAYMENT_NOTIFICATION')) { // если приходит ответ от платежки

    Log::info('apelsin обработка данных от APELSIN');

    $processor_data = array();

    $post_data = json_decode(file_get_contents("php://input"),true);
    $order_id = $post_data['order_id'];
    Log::info('payment post_data');
    Log::info($post_data);


    if ( apelsin_check_user() &&  fn_check_payment_script('apelsin.php', $order_id, $processor_data)) {


        $result = ['status'=>false];

        if ($mode == 'complete') {

            if(isset($post_data['order_id'])) {

                if( $order_info = fn_get_order_info($post_data['order_id']) ) { // //$_POST['merchant_trans_id']);

                    $result = fn_validate_apelsin_request($order_info, $post_data);

                    $formatter = Tygh::$app['formatter'];

                    fn_update_order_payment_info($order_info['order_id'], [
                        'transactionId' => $post_data['transactionId'],
                        'order_id' => $post_data['order_id'],
                        'payment_receiving_time' => $formatter->asDatetime(TIME)
                    ]);

                    if ($result['error'] == 0) {
                        Log::info('apelsin check payment OK');

                        $new_status = $processor_data['processor_params']['paid_status'] ? $processor_data['processor_params']['paid_status'] : 'P';
                        fn_change_order_status($order_info['order_id'], $new_status);
                        $result = ['status' => true];
                        $res['order_status'] = $new_status;
                        fn_finish_payment($order_info['order_id'],  $res /*, 'transaction_id'=>$post_data['transactionId']*/ );

                        Log::info('complete request from Apelsin');
                        //Log::info($post_data);

                        $user_id  = $order_info['user_id'];

                        if($user_id>0) {

                            $product_ids = [];
                            // id товаров в корзине
                            foreach ($order_info['products'] as $item) {
                                $product_ids[] = $item['product_id'];
                            }

                            if(count($product_ids)>0) {
                                Log::info('clear cart');
                                //Log::info("DELETE FROM _user_session_products WHERE user_id={$user_id} AND product_id IN (". implode(',',$product_ids) . ')');
                                // очистка корзины
                                db_query(
                                    'DELETE FROM ?:user_session_products WHERE user_id=?i AND product_id IN (?n)', $user_id, $product_ids
                                );
                            }

                        }

                    } elseif($order_info['status']!='P' && $order_info['status']!='C') {
                        fn_change_order_status($order_info['order_id'], 'I');
                        $result = ['status' => false];
                    }else{
                        $result = ['status' => false];
                    }



                }else{ // заказ не найден
                    $result = ['status' => false,'info'=>APELSIN_ERROR_ORDER_NOT_FOUND];
                }

            }

        }

        echo json_encode( $result );

    } else {

        Log::info('ERROR apelsin check payment');

        echo json_encode( array(
            'error'      => CLICK_ERROR_USER_NOT_EXIST,
            'error_note' => __( 'addons.apelsin.error_transaction_not_exist' )
        ));
    }

} else { // отправка на платежный сервис
    Log::info('apelsin отправка данных post_data');


    $url = "https://payment.apelsin.uz/";

    $post_data = array(
        'cash' => $processor_data['processor_params']['cash'],
        'order_id' => $order_info['order_id'],
        'amount' => $order_info['total']*100, // в тийинах
        //'redirectUrl' => fn_url('dispatch=payment_notification.complete&payment=apelsin' )
        'redirectUrl' => fn_url('checkout.complete&order_id=' . $order_info['order_id'] )
    );

    Log::info($post_data);

    fn_change_order_status($order_info['order_id'], 'O');

    fn_create_payment_form($url, $post_data, 'Apelsin Uzbekistan', false, 'get');
}
exit;
