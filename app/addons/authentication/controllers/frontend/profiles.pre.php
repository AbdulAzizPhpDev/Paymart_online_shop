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

use Tygh\Registry;
use Tygh\Tools\Url;

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

/**
 * @var string $mode
 * @var string $action
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($mode == 'send_sms') {
        $data = [
            'phone' => $_REQUEST['phone']
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://dev.paymart.uz/api/v1/login/send-sms-code',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);

        $response_data = json_decode($response);
        curl_close($curl);
        $data = db_get_field('SELECT user_id FROM ?:users WHERE phone = ?i', $_REQUEST['phone']);
        if (empty($data)) {
            $user = create_user($_REQUEST['phone']);
            $user_info = [
                'phone' => $_REQUEST['phone'],
                'id' => $user,
                'hash' => $response_data->hash
            ];
            fn_set_session_data('user_info', $user_info);
        } else {
            $user_info = [
                'phone' => $_REQUEST['phone'],
                'id' => $data,
                'hash' => $response_data->hash
            ];
            fn_set_session_data('user_info', $user_info);
        }

        Registry::get('ajax')->assign('result', $response_data);
        exit();

    }


//
// Create/Update user
//

    if ($mode == 'update') {

        $is_update = !empty($auth['user_id']);


        if (!$is_update) {

            $is_valid_user_data = true;

            if (empty($_REQUEST['user_data']['phone'])) {

                fn_set_notification('W', __('warning'), __('error_validator_required', array('[field]' => __('phone'))));
                $is_valid_user_data = false;
            } else {

                $pattern = "/^\+998\d{9}$/";
                if (preg_match($pattern, $_REQUEST['user_data']['phone'])) {
                    fn_set_notification('W', __('warning'), __('error_validator_required', array('[field]' => __('phone'))));
                    $is_valid_user_data = false;

                }
            }


            if (empty($_REQUEST['user_data']['password1']) || empty($_REQUEST['user_data']['password2'])) {

                if (empty($_REQUEST['user_data']['password1'])) {
                    fn_set_notification('W', __('warning'), __('error_validator_required', array('[field]' => __('password'))));
                }

                if (empty($_REQUEST['user_data']['password2'])) {
                    fn_set_notification('W', __('warning'), __('error_validator_required', array('[field]' => __('confirm_password'))));
                }
                $is_valid_user_data = false;

            } elseif ($_REQUEST['user_data']['password1'] !== $_REQUEST['user_data']['password2']) {
                fn_set_notification('W', __('warning'), __('error_validator_password', array('[field2]' => __('password'), '[field]' => __('confirm_password'))));
                $is_valid_user_data = false;
            }

            if (!$is_valid_user_data) {
                $redirect_params = array();

                if (isset($_REQUEST['return_url'])) {
                    $redirect_params['return_url'] = $_REQUEST['return_url'];
                }
                return array(CONTROLLER_STATUS_REDIRECT, Url::buildUrn(array('profiles', 'add', $action), $redirect_params));
            }
        }


        fn_restore_processed_user_password($_REQUEST['user_data'], $_POST['user_data']);

        $user_data = (array)$_REQUEST['user_data'];

        if (empty($auth['user_id']) && !empty(Tygh::$app['session']['cart']['user_data'])) {

            $user_data += array_filter((array)Tygh::$app['session']['cart']['user_data']);

        }

        $res = fn_update_user($auth['user_id'], $user_data, $auth, !empty($_REQUEST['ship_to_another']), true);

//        fn_print_die($res);

        if ($res) {
            list($user_id, $profile_id) = $res;

            // Cleanup user info stored in cart
            if (!empty(Tygh::$app['session']['cart']) && !empty(Tygh::$app['session']['cart']['user_data'])) {
                Tygh::$app['session']['cart']['user_data'] = fn_array_merge(Tygh::$app['session']['cart']['user_data'], $_REQUEST['user_data']);
            }

            if (empty(Tygh::$app['session']['cart']['user_data']['profile_id'])) {
                Tygh::$app['session']['cart']['user_data']['profile_id'] = $profile_id;
            }

            // Delete anonymous authentication
            if ($cu_id = fn_get_session_data('cu_id') && !empty($auth['user_id'])) {
                fn_delete_session_data('cu_id');
            }

            Tygh::$app['session']->regenerateID();

        } else {
            fn_save_post_data('user_data');
            fn_delete_notification('changes_saved');
        }

        $redirect_params = array();

        if (!empty($user_id) && !$is_update) {
            fn_login_user($user_id);

            if (!empty($_REQUEST['return_url'])) {
                return array(CONTROLLER_STATUS_OK, $_REQUEST['return_url']);
            }

            $redirect_dispatch = array('profiles', 'success_add');
        } else {
            $redirect_dispatch = array('profiles', empty($user_id) ? 'add' : 'update', $action);

            if (Registry::get('settings.General.user_multiple_profiles') == 'Y' && isset($profile_id)) {
                $redirect_params['profile_id'] = $profile_id;
            }

            if (!empty($_REQUEST['return_url']) && $res) {
                return array(CONTROLLER_STATUS_OK, $_REQUEST['return_url']);
            }
        }

        $_REQUEST['return_url'] = Url::buildUrn($redirect_dispatch, $redirect_params);

        return array(CONTROLLER_STATUS_OK, $_REQUEST['return_url']);
    }

    if ($mode == 'send_confirmed_sms_post') {

        fn_set_session_data('user_info', $_REQUEST['user_data']);
//        return array(CONTROLLER_STATUS_REDIRECT, 'auth.login_form?return_url=' . urlencode(Registry::get('config.current_url')));
    }


}

if ($mode == 'confirm') {

    $data = [
        "phone" => $_REQUEST['phone'],
        "code" => $_REQUEST['code'],
    ];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dev.paymart.uz/api/v1/login/auth',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    Registry::get('ajax')->assign('result', json_decode($response));
    exit();

}

