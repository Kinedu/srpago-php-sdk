<?php

/**
 * Sr. Pago (https://srpago.com)
 *
 * @link      https://api.srpago.com
 *
 * @copyright Copyright (c) 2016 SR PAGO
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 *
 * @package   SrPago\Error
 */

namespace SrPago\Error;

use Exception;

/**
 * Class SrPagoError
 *
 * @package SrPago\Error
 */
class SrPagoError extends Exception
{
    /**
     * @var array
     */
    private $error;

    /**
     * @var int
     */
    private $error_code;

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    /**
     * @param array $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->error_code = $errorCode;
    }
}
