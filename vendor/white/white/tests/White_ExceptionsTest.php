<?php

class White_ExceptionsTest extends \PHPUnit_Framework_TestCase
{

  /**
  * @expectedException White_Error_Authentication
  */
  function testListAuthenticationException()
  {
    White::setApiKey('invalid_token');
    White_Charge::all();
  }

  /**
  * @expectedException White_Error_Authentication
  */
  function testAuthenticationException()
  {
    White::setApiKey('invalid_token');

    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }

  /**
  * @expectedException White_Error_Card
  */
  function testCardException()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');

    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4141414141414141",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }

  /**
  * @expectedException White_Error_Parameters
  */
  function testParametersException()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');

    $data = array(
      "amount" => -1.30,
      "currency" => "bhd",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 12,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }

  /**
  * @expectedException White_Error_Api
  */
  function testApiException()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');

    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "3566002020360505",
        "exp_month" => 12,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }
}