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

use SrPago\Error\SrPagoError;

/**
 * Class OxxoPayment
 *
 * @package SrPago
 */
class OxxoPayment extends Base
{
    const ENDPOINT = '/payment/convenience-store';

    /**
     * @param  array  $data
     *
     * @return array
     */
    public function createReference($data)
    {
        if (! isset($data['amount'])) {
            throw new SrPagoError('An amount is required');
        } elseif (! isset($data['description'])) {
            throw new SrPagoError('A description is required');
        }

        $params = [
            'payment' => [
                'reference' => [
                    'description' => $data['description'],
                ],
            ],
            'total' => $data['amount'],
            'store' => 'oxxo',
        ];

        return $this->httpClient()->post(static::ENDPOINT, $params);
    }
}
