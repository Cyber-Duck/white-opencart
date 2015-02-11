<?php


class WhiteTest extends \PHPUnit_Framework_TestCase
{
  function testApiKey()
  {
    $testKey = 'test_sec_k_25dd497d7e657bb761ad6';
    White::setApiKey($testKey);
    $this->assertEquals($testKey, White::getApiKey());
  }

  function testSimpleMethods()
  {
    $this->assertEquals('https://api.whitepayments.com/', White::getBaseURL());
  }

  function testEndPoints()
  {
    $this->assertEquals('https://api.whitepayments.com/charges/', White::getEndPoint('charge'));
    $this->assertEquals('https://api.whitepayments.com/charges/', White::getEndPoint('charge_list'));
  }
}