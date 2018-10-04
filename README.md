# VerveMail

A PHP package for working w/ the VerveMail API.

Note that this API is exactly the same as BlueHornet, only with a different endpoint.

## Install

Normal install via Composer.

## Usage

Call the ``run()`` method and pass the api key, the api secret, the method name, and an array of arguments:

```php
use Travis\VerveMail;

$key = 'yourapikey';
$secret = 'yourapisecret';

$response = VerveMail::run($key, $secret, 'legacy.retrieve_active', [
	'bounce_status' => 'valid',
	'max' => 100,
	'offset' => 0
]);
```

This will return the first 100 emails in your list.  See the [API Guide](http://www.bluehornet.com/api/guide/) for additional methods.