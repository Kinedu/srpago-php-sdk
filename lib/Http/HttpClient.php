<?php

/**
 * Sr. Pago (https://srpago.com)
 *
 * @link      https://api.srpago.com
 *
 * @copyright Copyright (c) 2016 SR PAGO
 * @license   http://opensource.org/licenses/BSD-2-Clause BSD-2-Clause
 *
 * @package   SrPago\Http
 */

namespace SrPago\Http;

use RestClient;
use SrPago\SrPago;
use SrPago\Error\SrPagoError;

/**
 * Class HttpClient
 *
 * @package SrPago\Http
 */
class HttpClient
{
    /** @var RestClient */
    private $client;

    public function __construct()
    {
        $options = array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'X-User-Agent' => SrPago::getUserAgent(),
            ),
            'user_agent' => 'SrPago/RestClient/'.SrPago::getApiVersion(),
            'base_url' => SrPago::getApiBase().SrPago::getApiVersion(),
        );

        $connectionToken = SrPago::getConnection();
        $key = SrPago::getApiKey();

        if (empty($key)) {
            throw new SrPagoError('Key value is empty');
        }

        $authorization = 'Basic '.base64_encode(SrPago::getApiKey().':'.SrPago::getApiSecret());

        if (null !== $connectionToken) {
            $authorization = 'Bearer '.$connectionToken;
        }

        $options['headers']['Authorization'] = $authorization;

        $this->client = new RestClient($options);
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     *
     * @return array
     */
    public function post($url = '', $parameters = array(), $headers = array())
    {
        $parametersJson = json_encode($parameters);

        $client = $this->client->post($url, $parametersJson, $headers);

        return $this->parse($client);
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     *
     * @return array
     */
    public function get($url = '', $parameters = array(), $headers = array())
    {
        $client = $this->client->get($url, $parameters, $headers);

        return $this->parse($client);
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     *
     * @return array
     */
    public function delete($url = '', $parameters = array(), $headers = array())
    {
        $client = $this->client->delete($url, $parameters, $headers);

        return $this->parse($client);
    }

    /**
     * @param RestClient $client
     * @param string|null $classMap
     *
     * @throws \SrPago\Error\SrPagoError
     */
    public function parse($client, $classMap = null)
    {
        $httpCode = isset($client->info) && isset($client->info->http_code)
            ? $client->info->http_code
            : 0;
        $response = json_decode($client->response, true);

        if (null !== $response && is_array($response)) {
            if (isset($response['success']) && true == $response['success']) {
                return $this->mapToResource(
                    isset($response['result'])
                        ? $response['result']
                        : (isset($response['connection'])
                        ? $response['connection']
                        : null),
                    $classMap
                );
            }
        }

        if (! isset($response['error'])) {
            $response['error'] = array(
                'code' => 'CommunicationException',
                'message' => 'Hubo un problema al establecer la conexión con Sr. Pago',
            );
        }

        $error = new SrPagoError($response['error']['code'], $httpCode);
        $error->setError($response['error']);
        throw $error;
    }

    /**
     * @param string|null $result
     * @param string|null $classMap
     */
    public function mapToResource($result, $classMap = null)
    {
        return $result;
    }
}
