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
 * Class Base
 *
 * @package SrPago
 */
class Auth extends Base
{
    const ENDPOINT = '/auth/login/application';

    /**
     * @param string $applicationBundle
     *
     * @return array
     */
    public function loginApplication($applicationBundle = '')
    {
        $parameters = array('application_bundle' => $applicationBundle);
        $result = $this->httpClient()->post(static::ENDPOINT, $parameters);

        if (is_array($result) && isset($result['token'])) {
            SrPago::$connection = $result['token'];
        }

        return $result;
    }
}
