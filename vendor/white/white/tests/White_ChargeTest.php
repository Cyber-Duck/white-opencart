<?php

class White_ChargeTest extends \PHPUnit_Framework_TestCase
{

  function setUp()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');
  }

  function testList()
  {
    $result = White_Charge::all();
    //No assertion. If there is an error, an exception is thrown. Otherwise it was ok.
  }

  function testCreateSuccess()
  {
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

    $result = White_Charge::create($data);

    $expected = array(
      "tag" => "ch_3c513b0dfdc110b11b4091e2cbf6dc23",
      "livemode" => true,
      "amount" => "0.1",
      "is_captured" => true,
      "currency" => "bhd",
      "is_paid" => null,
      "is_refunded" => null, 
      "description" => null,
      "failure_code" => null,
      "failure_message" => null,
      "created_at" => "2014-08-14T16:20:53.451+03:00"
    );

    $this->assertEquals(array_keys($expected), array_keys($result));
    $this->assertNull($result['failure_code']);
  }
}