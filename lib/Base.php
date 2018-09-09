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

use SrPago\Http\HttpClient;


/**
 * Class Base
 *
 * @package SrPago
 */
abstract class Base {

    /**
     * 
     * @param type $connectionToken
     * @return HttpClient
     */
    protected function httpClient() {
        return new HttpClient();
    }

}
