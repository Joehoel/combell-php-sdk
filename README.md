# Combell API SDK for PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joehoel/combell-php-sdk.svg?style=flat-square)](https://packagist.org/packages/joehoel/combell-php-sdk)
[![Tests](https://img.shields.io/github/actions/workflow/status/joehoel/combell-php-sdk/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/joehoel/combell-php-sdk/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/joehoel/combell-php-sdk.svg?style=flat-square)](https://packagist.org/packages/joehoel/combell-php-sdk)

Unofficial PHP SDK for the Combell v2 API, built on Saloon v3. It handles HMAC authentication and exposes typed resources and DTOs for a clean developer experience.

## Installation

You can install the package via composer:

```bash
composer require joehoel/combell-php-sdk
```

## Usage

Basic setup:

```php
use Joehoel\Combell\Combell;

$sdk = new Combell($_ENV['COMBELL_API_KEY'], $_ENV['COMBELL_API_SECRET']);
```

List accounts (returns DTOs):

```php
use Joehoel\Combell\Dto\Account;

$response = $sdk->accounts()->getAccounts();
/** @var Account[] $accounts */
$accounts = $response->dto();

foreach ($accounts as $account) {
    echo $account->identifier.PHP_EOL;
}
```

Get a single account:

```php
use Joehoel\Combell\Dto\AccountDetail;

$response = $sdk->accounts()->getAccount(123);
/** @var AccountDetail $account */
$account = $response->dto();
```

List DNS records for a domain:

```php
use Joehoel\Combell\Dto\DnsRecord;

$response = $sdk->dnsRecords()->getRecords('example.com');
/** @var DnsRecord[] $records */
$records = $response->dto();
```

Create a DNS record (send a request with JSON body):

```php
use Joehoel\Combell\Requests\DnsRecords\CreateRecord;

// For JSON bodies, instantiate the request and merge the payload
$request = new CreateRecord('example.com');
$request->body()->merge([
    'type' => 'A',
    'name' => '@',
    'content' => '1.2.3.4',
    'ttl' => 3600,
]);

$response = $sdk->send($request);
// $response->status() === 201 on success
```

Notes:

- Responses map to DTOs when available via `$response->dto()`.
- Non-2xx responses throw exceptions by default (Saloon’s `AlwaysThrowOnErrors`).
- Authentication is automatic via HMAC — provide your API key and secret to `Combell`.

## Testing

```bash
composer test
```

With coverage:

```bash
composer test-coverage
```

Format code:

```bash
composer format
```

## Mocking in tests

You can use a local `MockClient` to test your integration without hitting the network.

```php
use Joehoel\Combell\Combell;
use Joehoel\Combell\Requests\Accounts\GetAccounts;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$mock = new MockClient([
    GetAccounts::class => MockResponse::make('[]', 200),
]);

$sdk = Combell::fake($mock, 'key', 'secret');
$response = $sdk->accounts()->getAccounts();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Pull requests are welcome. Please include tests for new or changed behavior and run:

```bash
composer format && composer test
```

## Acknowledgements

This SDK is inspired by and informed by the resources in <https://github.com/combell/combell-api>. Thank you to the Combell team for building and maintaining such a solid platform and for sharing their work publicly.

## Security

If you discover a security vulnerability, please email the maintainer at `joel@kuijper.fyi` rather than opening a public issue.

## Credits

- [Joël Kuijper](https://github.com/Joehoel)
- [All Contributors](https://github.com/joehoel/combell-php-sdk/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
