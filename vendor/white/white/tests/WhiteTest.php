<?php


class WhiteTest extends \PHPUnit_Framework_TestCase
{
  function testApiKey()
  {
    $testKey = 'sk_test_1234567890abcdefghijklmnopq';
    White::setApiKey($testKey);
    $this->assertEquals($testKey, White::getApiKey());
  }

  function testSimpleMethods()
  {
    $this->assertEquals('https://api.whitepayments.com', White::getBaseURL());
  }

  function testEndPoints()
  {
    $this->assertEquals('https://api.whitepayments.com/v1/charges', White::getEndPoint('charge'));
    $this->assertEquals('https://api.whitepayments.com/v1/charges', White::getEndPoint('charge_list'));
  }
}