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
 * Class Operations
 *
 * @package SrPago
 */
class Operations extends Base
{
    const ENDPOINT = '/operations';

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
     * @param string $transaction
     *
     * @return array
     */
    public function retreive($transaction)
    {
        return $this->httpClient()->get(static::ENDPOINT.'/'.$transaction);
    }

    /**
     * @param string $transaction
     *
     * @return array
     */
    public function cancel($transaction)
    {
        return $this->httpClient()->get(static::ENDPOINT.'/apply-reversal/'.$transaction);
    }
}
