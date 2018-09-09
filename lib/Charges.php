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

use SrPago\Error\SrPagoError;
use SrPago\Util\Encryption;

/**
 * Class Charges
 *
 * @package SrPago
 */
class Charges extends Base {

    const ENDPOINT = '/payment/card';
    /**
     *
     * @param array $data
     * @return mixed
     */
    public function create($_data) {

        $data = $this->mapToCardPayment($_data);
        $params = Encryption::encryptParametersWithString(json_encode($data));
        if(isset($_data['metadata'])){
          $params['metadata'] = $_data['metadata'];
        }

        $response = $this->httpClient()->post(static::ENDPOINT, $params);

          if(isset($response['recipe'])){
            $response = $response['recipe'];
          }else if(isset($response['token'])){
            $response = array();
            $response['token'] = array(
              'transaction' =>  $response['token']
            );
          }

        return $response;
    }


    private function mapToCardPayment($parameters)
		{
			if (!isset($parameters["amount"]))
			{
				throw new SrPagoError("amount is required ");
			}

      if (!isset($parameters["source"]))
			{

				throw new SrPagoError("source is required ad should be Dictionary");
			}


      $chargeRequest = $this->mapToSource($parameters);
      $chargeRequest['payment'] = $this->mapToPayment($parameters);
      $chargeRequest['total'] = $this->mapToPrice($parameters);

			return $chargeRequest;
		}




		private function MapToPayment($parameters)
		{
			$paymentRQ = array();

			$paymentRQ['externa'] = array('transaction'=>'');


			$paymentRQ['reference'] = array(
				'number' => isset($parameters["reference"]) ? ''. $parameters["reference"]: "",
				'description' => isset($parameters["description"]) ? ''. $parameters["description"]: "",
			);

			$paymentRQ['tip'] = array(
			     'amount'=> "0.00",
				   'currency'=> "MXN"
			);

			$paymentRQ['total']= array(
        'amount' => isset($parameters["amount"]) ? ''. $parameters["amount"]: "0.0",
				'currency'=> "MXN"
			);


			$paymentRQ['origin'] = array(
			     'device' => \SrPago\SrPago::getUserAgent(),
			     'ip' => isset($parameters["ip"]) ? ''. $parameters["ip"]: null,
      );

			$paymentRQ['origin']['location'] = array(
			     'latitude' => isset($parameters["latitude"]) ? ''. $parameters["latitude"]: "0.00000",
           'longitude' => isset($parameters["longitude"]) ? ''. $parameters["longitude"]: "0.00000",
      );



			return $paymentRQ;
		}

    function get_client_ip() {
      $ipaddress = '';
      if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
      else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
      else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
      else if(isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
      else if(isset($_SERVER['REMOTE_ADDR']))
          $ipaddress = $_SERVER['REMOTE_ADDR'];
      else
          $ipaddress = 'UNKNOWN';
      return $ipaddress;
  }



		private function mapToSource($parameters){
      $chargeRequest = array();

			if (!isset($parameters['source']))
			{
				throw new SrPagoException('Source is required');
			}


			if(is_string($parameters["source"]))
			{
				$chargeRequest['recurrent'] = ''. $parameters["source"];

			}
			else if (is_array($parameters["source"]))
			{
				$card = $this->mapToCard($parameters["source"]);
				$ecommerce = $card;

				$chargeRequest['card'] = $card;
        $ecommerce['ip'] = isset($parameters['ip'])?$parameters['ip']:$this->get_client_ip();
				$chargeRequest['ecommerce'] = $ecommerce;

			}
			else
			{
				throw new SrPagoException();
			}

      return $chargeRequest;

		}

		private function mapToCard($source)
		{
			$card = array();
			$card['cvv'] = isset($source["cvv"]) ? $source["cvv"]: "";
			$card['holder_name'] = isset($source["holder_name"]) ? $source["holder_name"]: "";
			$card['expiration'] = isset($source["expiration"]) ? $source["expiration"]: "";
			$card['number'] = isset($source["number"]) ? $source["number"]: "";
			$card['raw'] = isset($source["number"]) ? $source["number"]: "";
			$card['type'] = isset($source["type"]) ? $source["type"]: "";

			return $card;
		}


		private function mapToPrice($parameters)
		{
			$total = array(
			     'amount'=> isset($parameters["amount"]) ? $parameters["amount"]: "0",
			     'currency'=>'MXN'
         );

			return $total;
		}



    public function all($parameters = []) {
        return (new \SrPago\Operations())->all($parameters);
    }

    public function retreive($transaction) {
        return (new \SrPago\Operations())->retreive($transaction);
    }

    public function reversal($transaction) {
        return (new \SrPago\Operations())->reversal($transaction);
    }
}
