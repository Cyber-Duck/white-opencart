<?php

class White_CardExceptionsTest extends \PHPUnit_Framework_TestCase
{

  function setUp()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');
  }

  function testCardDeclined()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4000000000000002",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('card_declined', $e->getErrorCode());
    }
  }

  function testInvalidCard()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4141414141414141",
        "exp_month" => 12,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Test invalid card"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('invalid_number', $e->getErrorCode());
    }
  }

  function testInvalidCVC()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4000000000000127",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('invalid_cvc', $e->getErrorCode());
    }
  }

  function testExpiredCard()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4000000000000069",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('expired_card', $e->getErrorCode());
    }
  }

  function testProcessingError()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4000000000000119",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('processing_error', $e->getErrorCode());
    }
  }

  function testIncorrectNumber()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "1234123412341234",
        "exp_month" => 11,
        "exp_year" => 2014,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('invalid_number', $e->getErrorCode());
    }
  }

  function testInvalidYear()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 11,
        "exp_year" => 2100,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('invalid_expiry_year', $e->getErrorCode());
    }
  }

  function testInvalidMonth()
  {
    $data = array(
      "amount" => 10.500,
      "currency" => "bhd",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 15,
        "exp_year" => 2015,
        "cvc" => "123"
      ),
      "description" => "Charge for test@example.com"
    );

    try{
      $result = White_Charge::create($data);
    } catch (White_Error_Card $e) {
      $this->assertEquals('invalid_expiry_month', $e->getErrorCode());
    }
  }
}