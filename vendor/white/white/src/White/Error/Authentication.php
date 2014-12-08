<?php

/**
 * White API authentication error
 * 
 * @author Yazin Alirhayim <yazin@whitepayments.com>
 * @link https://whitepayments.com/docs/
 * @license http://opensource.org/licenses/MIT
 */

class White_Error_Authentication extends White_Error
{
  public static $CODE = 401;

  public function __construct($message)
  {
    parent::__construct($message, self::$CODE);
  }
}
