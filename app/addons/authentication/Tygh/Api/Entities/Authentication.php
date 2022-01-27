<?php


namespace Tygh\Api\Entities;

use Tygh\Api\AEntity;
use Tygh\Api\Response;
use Tygh\Registry;

class Authentication extends AEntity
{
    public function index($id = '', $params = array())
    {

        $pattern = "/^998\d{9}$/";
        if (isset($params['phone'])) {
            if (preg_match($pattern, $params['phone'])) {
                $code = rand(1111, 9999);
                fn_set_hook('send_sms', $params['phone'], $code);
//                $user = db_get_row('SELECT * FROM ?:users where phone = ?i', $params['phone']);
//                if ($user) {
//                    list($token, $expiry_time) = fn_get_user_auth_token($user['user_id']);
//                    return array(
//                        'status' => Response::STATUS_OK,
//                        'data' => [
//                            'status' => 1,
//                            'message' => 'exist',
//                            "user_id" => $user['user_id'],
//                            'token' => $token,
//                            'ttl' => $expiry_time - TIME,
//                        ]
//                    );
//                } else {
//                    $code = rand(1111, 9999);
//                    fn_set_hook('send_sms', $params['phone'], $code);
//                    return array(
//                        'status' => Response::STATUS_ACCEPTED,
//                        'data' => [
//                            'status' => 0,
//                            'message' => 'create',
//                            "hash_code" => md5($params['phone'] . $code . 'key')
//                        ]
//                    );
//                }
                return array(
                    'status' => Response::STATUS_OK,
                    'data' => [
                        'status' => 200,
                        'message' => 'send_sms',
                        "hash_code" => md5($params['phone'] . $code . 'key')
                    ]
                );
            } else {
                return array(
                    'status' => Response::STATUS_ACCEPTED,
                    'data' => [
                        'status' => 401,
                        'message' => 'wrong_format_number',
                        'phone' => $params['phone']
                    ]
                );
            }

        } else {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 400,
                    'message' => 'phone_number_empty',
                    'phone' => null
                ]
            );
        }

    }

    public function create($params)
    {
        $user = null;
        $pattern = "/^998\d{9}$/";
        if (isset($params['phone'])) {
            if (!preg_match($pattern, $params['phone']))
                return array(
                    'status' => Response::STATUS_ACCEPTED,
                    'data' => [
                        'status' => 401,
                        'message' => 'wrong_format_number',
                        'phone' => $params['phone']
                    ]
                );
        } else {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 400,
                    'message' => 'phone_number_empty',
                    'phone' => null
                ]
            );
        }

        if (!isset($params['code'])) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 402,
                    'message' => 'confirmation_number_empty',
                    'code' => null
                ]
            );
        } elseif (!isset($params['hash_code'])) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 403,
                    'message' => 'hash_code_empty',
                    'hash_code' => null
                ]
            );
        } elseif (md5($params['phone'] . $params['code'] . 'key') != $params['hash_code']) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 404,
                    'message' => 'wrong_hash_code',
                    'hash_code' => $params['hash_code']
                ]
            );
        } else {
            $user = db_get_row('SELECT * FROM ?:users WHERE phone = ?i', $params['phone']);
            if (!$user) {
                $user_id = create_user($params['phone']);
                list($token, $expiry_time) = fn_get_user_auth_token($user_id);
                return array(
                    'status' => Response::STATUS_CREATED,
                    'data' => [
                        'status' => 202,
                        'message' => 'new_user_created',
                        "user_id" => $user_id,
                    ]
                );
            } else {

                list($token, $expiry_time) = fn_get_user_auth_token($user['user_id']);
                if (empty($user['firstname']) && empty($user['lastname'])) {
                    return array(
                        'status' => Response::STATUS_ACCEPTED,
                        'data' => [
                            'status' => 204,
                            'message' => 'add_full_name',
                            "user_id" => $user['user_id'],

                        ]
                    );
                } else {
                    return array(
                        'status' => Response::STATUS_ACCEPTED,
                        'data' => [
                            'status' => 201,
                            'message' => 'user_exist',
                            "user_id" => $user['user_id'],
                            'token' => $token,
                            'ttl' => $expiry_time - TIME,
                        ]
                    );
                }
            }
        }
    }

    public function update($id = 0, $params = array())
    {

        if (!isset($params['full_name'])) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 405,
                    'message' => 'full_name_empty',
                    'phone' => null

                ]
            );
        } elseif (!isset($params['user_id'])) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 406,
                    'message' => 'user_id_empty',
                    'phone' => $params['phone']

                ]
            );
        } elseif (!isset($params['phone'])) {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 400,
                    'message' => 'phone_number_empty',
                    'phone' => null
                ]
            );
        } elseif (isset($params['phone'])) {
            $pattern = "/^998\d{9}$/";
            if (!preg_match($pattern, $params['phone'])) {
                return array(
                    'status' => Response::STATUS_ACCEPTED,
                    'data' => [
                        'status' => 401,
                        'message' => 'wrong_format_number',
                        'phone' => $params['phone']
                    ]
                );
            }
        }

        $user = db_get_row('SELECT * FROM ?:users WHERE phone = ?i', $params['phone']);
        if ($params['user_id'] == $user['user_id']) {
            $user_data['firstname'] = $params['full_name'];
            $user_data['user_login'] = "user_" . $params['user_id'];
            db_query('UPDATE ?:users SET ?u WHERE user_id = ?i', $user_data, $params['user_id']);

        } else {
            return array(
                'status' => Response::STATUS_ACCEPTED,
                'data' => [
                    'status' => 407,
                    'message' => 'wrong_user_id',
                    'phone' => $params['phone']

                ]
            );
        }


        list($token, $expiry_time) = fn_get_user_auth_token($user['user_id']);

        return array(
            'status' => Response::STATUS_ACCEPTED,
            'data' => [
                'status' => 203,
                'message' => 'user_update',
                "user_id" => $user['user_id'],
                'token' => $token,
                'ttl' => $expiry_time - TIME,
            ]
        );
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }


    public function privileges()
    {
        return array(
            'create' => 'create_authentication',
            'update' => 'update_authentication',
            'delete' => false,
            'index' => 'view_authentication'
        );
    }
}