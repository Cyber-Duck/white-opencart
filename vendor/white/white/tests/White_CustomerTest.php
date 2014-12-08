<?php

class White_CustomerTest extends \PHPUnit_Framework_TestCase
{

  function setUp()
  {
    White::setApiKey('sk_test_1234567890abcdefghijklmnopq');

    // Data for a successful customer
    $this->success_data = array(
      "description" => "Test Customer",
      "card" => array(
        "number" => "4242424242424242",
        "exp_month" => 11,
        "exp_year" => 2015,
        "cvc" => "123"
      )
    );
  }

  function testList()
  {
    $result = White_Customer::all();
    //No assertion. If there is an error, an exception is thrown. Otherwise it was ok.
  }

  function testCreateSuccess()
  {
    $result = White_Customer::create($this->success_data);

    $expected = array(
      "tag" => "cus_9042e13a6f1c82c50ef179afbece5a9f",
      "email" => null,
      "livemode" => false,
      "account_balance" => null,
      "currency" => null,
      "description" => "My first customer",
      "created_at" => "2014-10-26T19:27:47.000+03:00"
    );

    $this->assertEquals(array_keys($expected), array_keys($result));
  }

  function testRetrieveCustomerId()
  {
    $result = White_Customer::create($this->success_data);
    $this->assertArrayHasKey('tag', $result);
  }

  // TODO: These tests are really shallow .. beef them up!
}