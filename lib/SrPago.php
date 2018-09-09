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
/**
 * Class SrPago
 *
 * @package SrPago
 */
class SrPago {

  const SRPAGO_RSA_PUBLIC_KEY = '-----BEGIN PUBLIC KEY-----
MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAv0utLFjwHQk+1aLjxl9t
Ojvt/qFD1HfMFzjYa4d3iFKrQtvxaWM/B/6ltPn6+Pez+dOd59zFmzNHg33h8S0p
aZ6wmNv3mwp4hCJttGzFvl2hhw8Z+OU9KwGSXgQ+5FNyRyDLp0qt75ayvV0vV8oX
0Pgubd/NTHzRKk0ubXO8WVWkNhMdsv0HGrhIMDXAWLAQBzDewmICVH9MIJzjoZym
R7AuNpefD4hoVK8cBMjZ0xRKSPyd3zI6uJyERcR3+N9nxvg4guShP27cnD9qpLt4
L6YtU0BU+husFXoHL6Y2CsxyzxT9mtorAGe5oRiTC7Z/S9u7pxGN4iozgmAei0MZ
VbKows/qa9/q0PPzbF/PHSZKou1DJvsJ2PKY3ZPYAT7/u4x8NRiJ/6cssuzsIPUd
Q9HBzA1ZBMHkpOmkipu1G7ks/GwTfQJkHPW5xHu1EOYvgv/PHr3BJnCMNYKFvf5c
4Qd0COnnU3jDel1OKl7lUzr+ioqUedX393D/fszdK4hjvtUjo6ThTRNm3y4avY/r
m+oLu8sZWpyBm4PfN2xGOnFco9SiyCT03XOEuOXokid6BDMi0aue9LKJaQR+KGVc
/H2p2d2Yu4GdgXS1vq1syaf7V0QPOmamTOyJRZ45UoLfBRB8nYBGDo0mPR7GIon6
M8SmGGsTo3V0L+Ni9bNJHa8CAwEAAQ==
-----END PUBLIC KEY-----';

    public static $apiKey;
    public static $apiSecret;
    public static $apiBase = 'https://api.srpago.com/';
    public static $apiBaseSandbox = 'https://sandbox-api.srpago.com/';
    public static $apiVersion = 'v1';
    public static $liveMode = false;
    public static $connection = null;

    const VERSION = '1.0.0';

    public static function getApiBase() {
        $url = static::$apiBase;
        if (static::$liveMode === false) {
            $url = static::$apiBaseSandbox;
        }
        return $url;
    }

    public static function setLiveMode($liveMode) {
        static::$liveMode = $liveMode;
    }

    /**
     * @return string The API key used for requests.
     */
    public static function getApiKey() {
        return self::$apiKey;
    }

    /**
     * Sets the API key to be used for requests.
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey) {
        self::$apiKey = $apiKey;
    }

    /**
     * @return string connection for requests.
     */
    public static function getConnection() {
        return self::$connection;
    }

    /**
     * @return string The API key used for requests.
     */
    public static function getApiSecret() {
        return self::$apiSecret;
    }

    /**
     * Sets the API secret to be used for requests.
     *
     * @param string $apiSecret
     */
    public static function setApiSecret($apiSecret) {
        self::$apiSecret = $apiSecret;
    }

    /**
     * @return string The API version used for requests. null if we're using the
     *    latest version.
     */
    public static function getApiVersion() {
        return self::$apiVersion;
    }

    /**
     * @param string $apiVersion The API version to use for requests.
     */
    public static function setApiVersion($apiVersion) {
        self::$apiVersion = $apiVersion;
    }

    /**
     *
     * @return string user agent information
     */
    public static function getUserAgent() {
        return json_encode(array('php_version' => phpversion(), 'name' => php_uname(), 'language' => 'PHP',
                        'sdk_version'=>static::VERSION, 'api_version'=>static::$apiVersion
                      ));
    }


    public static function Charges(){
      return new \SrPago\Charges();
    }

    public static function Customer(){
      return new \SrPago\Customer();
    }

}
