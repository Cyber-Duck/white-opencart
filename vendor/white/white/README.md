# White PHP

White makes accepting payments in the Middle East ridiculously easy. Sign up for an account at [whitepayments.com](http://whitepayments.com).

## Getting Started

Using White with your PHP project is simple. If you're using [Composer](https://getcomposer.org) (and really, who isn't these days amirite?), you just need to add one line to your `composer.json` file:

```json
{
    "require": {
        "white/white": "1.*"
    }
}
```

Now, running `php composer.phar install` will pull the library directly to your local `vendor` folder.

## Using White

You'll need an account with White if you don't already have one (grab one real quick at [whitepayments.com](http://whitepayments.com) and come back .. we'll wait).

Got an account? Great .. let's get busy.

### 1. Initializing White

To get started, you'll need to initialize White with your secret API key. Here's how that looks (we're using a test key, so no real money will be exchanging hands):

```php
require_once('vendor/autoload.php'); # At the top of your PHP file

# Initialize White object
White::setApiKey('sk_test_1234567890abcdefghijklmnopq');
```

That's it! You probably want to do something with the White object though -- it gets really bored when it doesn't have anything to do. 

Let's run a transaction, shall we.

### 2. Processing a transaction through White

Now, for the fun part. Here's all the code you need to process a transaction with White:

```php
White_Charge::create(array(
  "amount" => 10.500,
  "currency" => "bhd",
  "card" => array(
    "number" => "4242424242424242",
    "exp_month" => 11,
    "exp_year" => 2014,
    "cvv" => "123"
  ),
  "description" => "Charge for test@example.com"
));
```

This transaction should be successful since we used the `4242 4242 4242 4242` test credit card. For a complete list of test cards, and their expected output you can check out this link [here](https://whitepayments.com/docs/).

How can you tell that it was successful? Well, if no exception is raised then you're in the clear.

### 3. Handling Errors

Any errors that may occur during a transaction is raised as an Exception. Here's an example of how you can handle errors with White:

```php
try {
  // Use White's bindings...
} catch(White_Error_Card $e) {
  // Since it's a decline, White_Error_Card will be caught
  print('Status is:' . $e->getHttpStatus() . "\n");
  print('Code is:' . $e->getErrorCode() . "\n");
  print('Message is:' . $e->getMessage() . "\n");
} catch (White_Error_Parameters $e) {
  // Invalid parameters were supplied to White's API
} catch (White_Error $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
  // Something else happened, completely unrelated to White
}
```

## Testing White

It's probably a good idea to run the unit tests to make sure that everything is fine and dandy. That's also simple.. just run this command from the root of your project folder:

```bash
php vendor/bin/phpunit tests --bootstrap vendor/autoload.php
```

**Note:** you'll need to pull the development dependencies as well, using `composer update --dev` in order to run the test suites.

## Contributing

Read our [Contributing Guidelines](CONTRIBUTING.md) for details