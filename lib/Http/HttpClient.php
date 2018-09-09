<?php
/**
 *
 * Sr. Pago (https://srpago.com)
 *
 * @link      https://api.srpago.com
 * @copyright Copyright (c) 2016 SR PAGO
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 * @package   SrPago\Http
 */

namespace SrPago\Http;

use RestClient;
use SrPago\Error\SrPagoError;
use SrPago\SrPago;

/**
 * Class HttpClient
 *
 * @package SrPago\Http
 */
class HttpClient {

    /**
     *
     * @var RestClient
     */
    private $client;
    /**
     *
     * @param type $connectionToken
     * @return RestClient
     */
    public function __construct() {
        $options = array(
            'headers' => array(
                'Content-Type' => ' application/json',
                'X-User-Agent' => SrPago::getUserAgent(),
            ),
            'user_agent' => 'SrPago/RestClient/'.SrPago::getApiVersion(),
            'base_url' => SrPago::getApiBase() . SrPago::getApiVersion(),
        );

        $connectionToken = SrPago::getConnection();

        $key = SrPago::getApiKey() ;
        if(empty($key)){
          throw new SrPagoError("Key value is empty ");
        }

        $authorization = ' Basic ' . base64_encode(SrPago::getApiKey() . ':' . SrPago::getApiSecret());
        if ($connectionToken !== null) {
            $authorization = ' Bearer ' . $connectionToken;
        }


        $options['headers']['Authorization'] = $authorization;

        $this->client = new RestClient($options);
    }

    /**
     *
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return array
     */
    public function post($url = '', $parameters = [], $headers = []) {
        $parametersJson = json_encode($parameters);

        $client = $this->client->post($url, $parametersJson, $headers);



        return $this->parse($client);
    }

     /**
     *
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return array
     */
    public function get($url = '', $parameters = [], $headers = []) {

        $client = $this->client->get($url, $parameters, $headers);

        return $this->parse($client);
    }

     /**
     *
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return array
     */
    public function delete($url = '', $parameters = [], $headers = []) {

        $client = $this->client->delete($url, $parameters, $headers);


        return $this->parse($client);
    }

    /**
     *
     * @param client $client
     * @param string $classMap
     * @return mixed
     * @throws SrPagoError
     */
    public function parse($client, $classMap = null) {
        $httpCode = isset($client->info) && isset($client->info->http_code) ? $client->info->http_code : 0;
        $response = json_decode($client->response, true);


        if ($response !== null && is_array($response)) {
            if (isset($response['success']) && $response['success'] == true) {
                return $this->mapToResource(isset($response['result']) ? $response['result'] :
                                        (isset($response['connection']) ? $response['connection'] : null), $classMap);
            }
        }

        if (!isset($response['error'])) {
            $response['error'] = array('code' => 'CommunicationException', 'message' => 'Hubo un problema al establecer la conexión con Sr. Pago');
        }

        $error = new \SrPago\Error\SrPagoError($response['error']['code'], $httpCode);
        $error->setError($response['error']);
        throw $error;
    }

    /**
     *
     * @param mixed $result
     * @param string $classMap
     * @return mixed
     */
    public function mapToResource($result, $classMap = null) {
        return $result;
    }

}
