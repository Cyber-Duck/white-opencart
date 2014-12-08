<?php

/**
 * Class to hold White API settings
 * 
 * @author Yazin <yazin@whitepayments.com>
 * @link https://whitepayments.com/docs/
 * @license http://opensource.org/licenses/MIT
 */

class White
{

  /**
  * Current API key
  * @var string
  */
  protected static $apiKey;

  /**
  * API Server URL
  * @var string
  */
  protected static $baseURL = 'https://api.whitepayments.com';

  /**
  * API endpoints
  * @var array
  */
  protected static $endpoints = array(
    'charge'        => '/v1/charges',
    'charge_list'   => '/v1/charges',
    'customer'      => '/v1/customers',
    'customer_list' => '/v1/customers'
  );

  /**
  * sets API Key
  * 
  * @param string $apiKey API key
  */
  public static function setApiKey($apiKey)
  {
    self::$apiKey = $apiKey;
  }

  /**
  * returns current set API Key
  * 
  * @return string ApiKey
  */
  public static function getApiKey()
  {
    return self::$apiKey;
  }

  /**
  * returns current set API Base URL
  * 
  * @return string BaseURL
  */
  public static function getBaseURL()
  {
    return self::$baseURL;
  }

  /**
  * returns full endpoint URI
  * 
  * @return string endpoint URI
  */
  public static function getEndPoint($name)
  {
    return self::$baseURL . self::$endpoints[$name];
  }

  public static function handleErrors($result, $code)
  {   
      if($code == White_Error_Card::$CODE && $result['error']['type'] == White_Error_Card::$TYPE) {
        throw new White_Error_Card($result['error']['message'], $result['error']['code']);
      }

      if($code == White_Error_Parameters::$CODE) {
        throw new White_Error_Parameters($result['error']['message'], $code);
      }
      
      if($code == White_Error_Authentication::$CODE) {
        throw new White_Error_Authentication($result['error']['message']);
      }
      
      if($code >=500 && $code <600) { //Generic API error
        throw new White_Error_Api($result['error']['message'], $code);
      }

      throw new White_Error($result['error']['message'], $code);
  }
}
