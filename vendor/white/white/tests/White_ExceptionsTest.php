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
      "amount" => 1050,
      "currency" => "usd",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 11,
        "exp_year" => 2016,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }

  /**
  * @expectedException White_Error_Request
  */
  function testCardException()
  {
    White::setApiKey('test_sec_k_25dd497d7e657bb761ad6');

    $data = array(
      "amount" => 1050,
      "currency" => "usd",
      "card" => array(
        "number" => "4141414141414141",
        "exp_month" => 11,
        "exp_year" => 2016,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    White_Charge::create($data);
  }

  // This test should raise an exception but doesn't. Raised issue:
  // 
  // /**
  // * @expectedException White_Error_Request
  // */
  // function testParametersException()
  // {
  //   White::setApiKey('test_sec_k_25dd497d7e657bb761ad6');

  //   $data = array(
  //     "amount" => -1.30,
  //     "currency" => "usd",
  //     "card" => array(
  //       "number" => "4242424242424242",
  //       "exp_month" => 12,
  //       "exp_year" => 2016,
  //       "cvc" => "123"
  //     ),
  //     "description" => "Charge for test@example.com"
  //   );

  //   White_Charge::create($data);
  // }

  // We need to setup the card to raise a Processing error
  // /*
  //  * @expectedException White_Error_Processing
  //  */
  // function testApiException()
  // {
  //   White::setApiKey('test_sec_k_25dd497d7e657bb761ad6');

  //   $data = array(
  //     "amount" => 1050,
  //     "currency" => "usd",
  //     "card" => array(
  //       "number" => "3566002020360505",
  //       "exp_month" => 12,
  //       "exp_year" => 2016,
  //       "cvc" => "123"
  //     ),
  //     "description" => "Charge for test@example.com"
  //   );

  //   White_Charge::create($data);
  // }
}