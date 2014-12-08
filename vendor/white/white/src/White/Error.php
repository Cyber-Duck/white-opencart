<?php

/**
 * Generic White error
 * 
 * @author Yazin Alirhayim <yazin@whitepayments.com>
 * @link https://whitepayments.com/docs/
 * @license http://opensource.org/licenses/MIT
 */

class White_Error extends \Exception
{

  /**
  * HTTP status code
  * @var int
  */
  protected $httpStatus;

  /**
  * @param string $message a human readable message
  * @param int $httpStatus the HTTP status code
  */
  public function __construct($message, $httpStatus)
  {
    parent::__construct($message);
    $this->httpStatus = $httpStatus;
  }

  /**
  * Get HTTP status code
  *
  * @return string
  */
  public function getHttpStatus()
  {
    return $this->httpStatus;
  }
}
