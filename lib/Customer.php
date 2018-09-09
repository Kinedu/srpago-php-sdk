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

use SrPago\Base;

/**
 * 
 */
class Customer extends Base {

    const ENDPOINT = '/customer';

    /**
     * 
     * @param array $parameters
     * @return mixed
     */
    public function all($parameters = []) {
        
        $result = $this->httpClient()->get(static::ENDPOINT, $parameters);
        
        return $result;
    }

    /**
     * 
     * @param array $data
     * @return mixed
     */
    public function create($data) {

        $result = $this->httpClient()->post(static::ENDPOINT, $data);

        return $result;
    }

     /**
     * 
     * @param string $token
     * @return mixed
     */
    public function find($token) {

        $result = $this->httpClient()->get(static::ENDPOINT . '/' . $token);

        return $result;
    }

    /**
     * 
     * @param string $token
     * @return mixed
     */
    public function remove($token) {

        $result = $this->httpClient()->delete(static::ENDPOINT . '/' . $token);

        return $result;
    }

}
