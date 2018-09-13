<?php

/**
 * Sr. Pago (https://srpago.com)
 *
 * @link      https://api.srpago.com
 *
 * @copyright Copyright (c) 2016 SR PAGO
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 *
 * @package   SrPago
 */

namespace SrPago;

/**
 * Class CustomerCards
 *
 * @package SrPago
 */
class CustomerCards extends Base
{
    const ENDPOINT = '/customer/%s/cards';

    /**
     * @param string $user
     *
     * @return array
     */
    public function all($user)
    {
        return $this->httpClient()->get(sprintf(static::ENDPOINT, $user));
    }

    /**
     * @param string $user
     * @param string token
     *
     * @return array
     */
    public function add($user, $token)
    {
        return $this->httpClient()->post(sprintf(static::ENDPOINT, $user), array('token' => $token));
    }

    /**
     * @param string $user
     * @param string token
     *
     * @return array
     */
    public function remove($user, $token)
    {
        return $this->httpClient()->delete(sprintf(static::ENDPOINT, $user).'/'.$token);
    }

    /**
     * @param string $user
     * @param string token
     *
     * @return array
     */
    public function find($user, $token)
    {
        return $this->httpClient()->get(sprintf(static::ENDPOINT, $user).'/'.$token);
    }
}
