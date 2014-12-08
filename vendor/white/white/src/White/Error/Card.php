<?php

/**
 * White API card error
 * 
 * @author Yazin Alirhayim <yazin@whitepayments.com>
 * @link https://whitepayments.com/docs/
 * @license http://opensource.org/licenses/MIT
 */

class White_Error_Card extends White_Error
{
  public static $CODE = 400;
  public static $TYPE = 'card_error';

  /**
  * Error Code
  * @var string
  */
  protected $error_code;

  /**
  * @param string $message a human readable message
  * @param string $error_code the error code
  */
  public function __construct($message, $error_code)
  {
    parent::__construct($message, self::$CODE);
    $this->error_code = $error_code;
  }

  /**
  * Get HTTP status code
  *
  * @return string
  */
  public function getErrorCode()
  {
    return $this->error_code;
  }
}
