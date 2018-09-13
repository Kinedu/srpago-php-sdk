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
 * Class Customer
 *
 * @package SrPago
 */
class Customer extends Base
{
    const ENDPOINT = '/customer';

    /**
     * @param array $parameters
     *
     * @return array
     */
    public function all($parameters = array())
    {
        return $this->httpClient()->get(static::ENDPOINT, $parameters);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function create($data)
    {
        return $this->httpClient()->post(static::ENDPOINT, $data);
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function find($token)
    {
        return $this->httpClient()->get(static::ENDPOINT.'/'.$token);
    }

    /**
     * @param string $token
     * @param array  $data
     *
     * @return array
     */
    public function update($token, $data)
    {
        return $this->httpClient()->put(static::ENDPOINT.'/'.$token, $data);
    }

    /**
     * @param string $token
     *
     * @return array
     */
    public function remove($token)
    {
        return $this->httpClient()->delete(static::ENDPOINT.'/'.$token);
    }
}
