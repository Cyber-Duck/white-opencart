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
  protected static $baseURL = 'https://api.whitepayments.com/';

  /**
  * API endpoints
  * @var array
  */
  protected static $endpoints = array(
    'charge'        => 'charges/',
    'charge_list'   => 'charges/',
    'customer'      => 'customers/',
    'customer_list' => 'customers/',
    'refund'        => 'refunds/'
  );

  /*
  * Path to the CA Certificates required when making CURL calls
  */
  public static function getCaPath() {
    return __DIR__ . '/data/ca-certificates.crt';
  }

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

  public static function handleErrors($result, $httpStatusCode)
  {
    switch($result['error']['type']) {
      case White_Error_Authentication::$TYPE:
        throw new White_Error_Authentication($result['error']['message'], $result['error']['code'], $httpStatusCode);
        break;

      case White_Error_Banking::$TYPE:
        throw new White_Error_Banking($result['error']['message'], $result['error']['code'], $httpStatusCode);
        break;

      case White_Error_Processing::$TYPE:
        throw new White_Error_Processing($result['error']['message'], $result['error']['code'], $httpStatusCode);
        break;

      case White_Error_Request::$TYPE:
        throw new White_Error_Request($result['error']['message'], $result['error']['code'], $httpStatusCode);
        break;
    }

    // None of the above? Throw a general White Error
    throw new White_Error($result['error']['message'], $result['error']['code'], $httpStatusCode);
  }
}
