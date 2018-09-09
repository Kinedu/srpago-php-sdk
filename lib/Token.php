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

use SrPago\Util\Encryption;
/**
 * Class Token
 *
 * @package SrPago
 */
class Token extends Base {

    const ENDPOINT = '/token';

    /**
     * 
     * @param array $data
     * @return mixed
     */
    public function create($data) {

        $params = Encryption::encryptParametersWithString(json_encode($data));
        $result = $this->httpClient()->post(static::ENDPOINT, $params);

        return $result;
    }

}
