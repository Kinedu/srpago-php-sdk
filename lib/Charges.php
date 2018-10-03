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
use SrPago\Util\Encryption;

/**
 * Class Charges
 *
 * @package SrPago
 */
class Charges extends Base
{
    const ENDPOINT = '/payment/card';

    /**
     * @param array $data
     */
    public function create($data)
    {
        $data = $this->mapToCardPayment($data);
        $params = Encryption::encryptParametersWithString(json_encode($data));

        if (isset($data['metadata'])) {
            $params['metadata'] = $data['metadata'];
        }

        $response = $this->httpClient()->post(static::ENDPOINT, $params);

        if (isset($response['recipe'])) {
            $response = $response['recipe'];
        } elseif (isset($response['token'])) {
            $response = array();
            $response['token'] = array(
                'transaction' => $response['token'],
            );
        }

        return $response;
    }

    /**
     * Format the charge request.
     *
     * @param array $parameters
     *
     * @return array
     */
    private function mapToCardPayment($parameters)
    {
        if (! isset($parameters['amount'])) {
            throw new SrPagoError('An amount is required');
        }

        if (! isset($parameters['source'])) {
            throw new SrPagoError('source is required and should be Dictionary');
        }

        $chargeRequest = $this->mapToSource($parameters);
        $chargeRequest['payment'] = $this->mapToPayment($parameters);
        $chargeRequest['total'] = $this->mapToPrice($parameters);

        return $chargeRequest;
    }

    /**
     * Format the payment information.
     *
     * @param array $parameters
     *
     * @return array
     */
    private function mapToPayment($parameters)
    {
        $payment = array();

        $payment['externa'] = array('transaction' => '');

        $payment['reference'] = array(
            'number' => isset($parameters['reference']) ? $parameters['reference'] : '',
            'description' => isset($parameters['description']) ? $parameters['description'] : '',
        );

        $payment['tip'] = array(
            'amount' => '0.00',
            'currency' => 'MXN'
        );

        $payment['total']= array(
            'amount' => isset($parameters['amount']) ? $parameters['amount'] : '0.0',
            'currency' => 'MXN'
        );

        $payment['origin'] = array(
            'device' => \SrPago\SrPago::getUserAgent(),
            'ip' => isset($parameters['ip']) ? $parameters['ip'] : null,
            'location' => array(
                'latitude' => isset($parameters['latitude']) ? $parameters['latitude'] : '0.00000',
                'longitude' => isset($parameters['longitude']) ? $parameters['longitude'] : '0.00000',
            )
        );

        return $payment;
    }

    /**
     * @return string
     */
    private function getClientIp()
    {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    /**
     * Format the charge request.
     *
     * @param array $parameters
     *
     * @throws \SrPago\SrPagoError
     *
     * @return array
     */
    private function mapToSource($parameters)
    {
        $chargeRequest = array();

        if (! isset($parameters['source'])) {
            throw new SrPagoError('Source is required');
        }

        if (is_string($parameters['source'])) {
            $chargeRequest['recurrent'] = $parameters['source'];
        } elseif (is_array($parameters['source'])) {
            $card = $this->mapToCard($parameters['source']);
            $ecommerce = $card;

            $chargeRequest['card'] = $card;
            $ecommerce['ip'] = isset($parameters['ip']) ? $parameters['ip'] : $this->getClientIp();
            $chargeRequest['ecommerce'] = $ecommerce;
        } else {
            throw new SrPagoError();
        }

        return $chargeRequest;
    }

    /**
     * Format the credit card information.
     *
     * @param array|null $source
     *
     * @return array
     */
    private function mapToCard($source)
    {
        $card = array(
            'cvv' => isset($source['cvv']) ? $source['cvv'] : '',
            'holder_name' => isset($source['holder_name']) ? $source['holder_name'] : '',
            'expiration' => isset($source['expiration']) ? $source['expiration'] : '',
            'number' => isset($source['number']) ? $source['number'] : '',
            'raw' => isset($source['number']) ? $source['number'] : '',
            'type' => isset($source['type']) ? $source['type'] : '',
        );

        return $card;
    }

    /**
     * Format the total price to be charged.
     *
     * @param array|null $parameters
     *
     * @return array
     */
    private function mapToPrice($parameters)
    {
        $total = array(
            'amount' => isset($parameters['amount']) ? $parameters['amount'] : '0',
            'currency' => 'MXN',
        );

        return $total;
    }

    /**
     * Fetch all operations performed on the account.
     *
     * @param array $parameters
     *
     * @return array
     */
    public function all($parameters = array())
    {
        return (new \SrPago\Operations())->all($parameters);
    }

    /**
     * Fetch the details for the given operation.
     *
     * @param string $transaction The operation ID.
     *
     * @return array
     */
    public function retreive($transaction)
    {
        return (new \SrPago\Operations())->retreive($transaction);
    }

    /**
     * Attempt to cancel the given operation.
     * NB: In the SrPago documentation, this is referred to as 'reversal'.
     *
     * @param string $transaction The operation ID.
     *
     * @return array
     */
    public function cancel($transaction)
    {
        return (new \SrPago\Operations())->cancel($transaction);
    }
}
