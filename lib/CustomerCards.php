<?php

/**
 * 
 * Sr. Pago (https://srpago.com)
 * 
 * @link      https://api.srpago.com
 * @copyright Copyright (c) 2016 SR PAGO
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @package   SrPago
 */

namespace SrPago;

/**
 * Class CustomerCards
 *
 * @package SrPago
 */
class CustomerCards extends Base {

    const ENDPOINT = '/customer/%s/cards';

    /**
     * 
     * @param string $user
     * @return mixed
     */
    public function all($user) {

        $result = $this->httpClient()->get(sprintf(static::ENDPOINT, $user));

        return $result;
    }

    /**
     * 
     * @param string $user
     * @param string token
     * @return mixed
     */
    public function add($user, $token) {

        $result = $this->httpClient()->post(sprintf(static::ENDPOINT, $user), array('token' => $token));

        return $result;
    }

    /**
     * 
     * @param string $user
     * @param string token
     * @return mixed
     */
    public function remove($user, $token) {

        $result = $this->httpClient()->delete(sprintf(static::ENDPOINT, $user) . '/' . $token);

        return $result;
    }

    /**
     * 
     * @param string $user
     * @param string token
     * @return mixed
     */
    public function find($user, $token) {

        $result = $this->httpClient()->get(sprintf(static::ENDPOINT, $user) . '/' . $token);

        return $result;
    }

}
