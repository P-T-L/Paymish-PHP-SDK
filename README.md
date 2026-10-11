# Paymish PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bhekor/paymish-php.svg?style=flat-square)](https://packagist.org/packages/bhekor/paymish-php)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/bhekor/paymish-php/tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/bhekor/paymish-php/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/bhekor/paymish-php.svg?style=flat-square)](https://packagist.org/packages/bhekor/paymish-php)
[![License](https://img.shields.io/packagist/l/bhekor/paymish-php.svg?style=flat-square)](LICENSE.md)

Framework-agnostic PHP SDK for the [Paymish](https://paymish.com) payment gateway. Covers transactions, transfers, virtual accounts, subscriptions, products, customers, and more.

Official API docs: https://api.paymish.com/api/user-service/external/v1/docs/

For Laravel apps, see also [`bhekor/laravel-paymish`](https://github.com/bhekor/laravel-paymish).

## Requirements

- PHP 8.2+
- Guzzle 7+
- PSR-16 Simple Cache (optional, for token caching)

## Installation

```bash
composer require bhekor/paymish-php
```

## Quick start

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(
    publicKey: getenv('PAYMISH_PUBLIC_KEY') ?: null,
    secretKey: getenv('PAYMISH_SECRET_KEY') ?: null,
    // or: email: '...', password: '...',
    baseUrl: 'https://api.paymish.com',
    isLive: false,
    timeout: 30,
);

// Initialize (hosted / redirect flow)
$response = $paymish->transaction()->initialize([
    'email' => 'customer@email.com',
    'amount' => '10000',
    'currency' => 'NGN',
    'channels' => ['card', 'ussd', 'nqr', 'transfer'],
    'callback_url' => 'https://your-site.com/callback',
]);

// Verify after callback or webhook
$response = $paymish->transaction()->verify('transaction-reference');
// data.status: completed | failed | pending | reversed
```

The client auto-authenticates before API calls (in-memory bearer JWT; optional PSR-16 cache).

Amounts for initialize / DVA / transfers are in **NGN major units** (send `1100` for ₦1,100). OpenAPI may mention subunits; live Paymish treats the value as naira.

## Security

- Never hardcode live card numbers, CVVs, or BVNs in application code.
- Prefer `initialize()` + Paymish hosted checkout over raw `withCard()` when possible (PCI scope).
- Examples below use **sandbox/test placeholders only**.
- Always re-verify payments server-side (`transaction()->verify()`) and on webhooks — do not trust client redirects alone.

## Configuration

| Constructor arg | Description | Default |
|-----------------|-------------|---------|
| `publicKey` / `secretKey` | OpenAPI keys (preferred) | `null` |
| `email` / `password` | Alternate auth | `null` |
| `baseUrl` | API base URL | `https://api.paymish.com` |
| `timeout` | HTTP timeout (seconds) | `30` |
| `isLive` | Live mode flag | `false` |
| `tokenCacheSeconds` | Bearer TTL when using cache | `3500` |
| `cache` | `Psr\SimpleCache\CacheInterface` | `null` (in-memory only) |
| `endpoints` | Override endpoint map | bundled `Config/endpoints.php` |

Example with a PSR-16 cache:

```php
use Bhekor\Paymish\PaymishClient;
use Psr\SimpleCache\CacheInterface;

/** @var CacheInterface $cache */
$paymish = new PaymishClient(
    publicKey: getenv('PAYMISH_PUBLIC_KEY') ?: null,
    secretKey: getenv('PAYMISH_SECRET_KEY') ?: null,
    cache: $cache,
);
```

## Documentation

| Topic | Guide |
|-------|--------|
| Authentication | [docs/authentication.md](docs/authentication.md) |
| Transactions | [docs/transactions.md](docs/transactions.md) |
| Transfers & recipients | [docs/transfers.md](docs/transfers.md) |
| Virtual accounts | [docs/virtual-accounts.md](docs/virtual-accounts.md) |
| Subscriptions & plans | [docs/subscriptions-plans.md](docs/subscriptions-plans.md) |
| Products & payment pages | [docs/products-payment-pages.md](docs/products-payment-pages.md) |
| Customers & business | [docs/customers-business.md](docs/customers-business.md) |
| Splits & subaccounts | [docs/splits-subaccounts.md](docs/splits-subaccounts.md) |
| Disputes | [docs/disputes.md](docs/disputes.md) |
| Webhooks | [docs/webhooks.md](docs/webhooks.md) |
| Errors & responses | [docs/errors-responses.md](docs/errors-responses.md) |

## Usage overview

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(
    publicKey: '...',
    secretKey: '...',
);

$paymish->auth();
$paymish->transaction();
$paymish->transfer();
$paymish->recipient();
$paymish->dedicatedVirtualAccount();
$paymish->virtualAccount();
$paymish->subscription();
$paymish->plan();
$paymish->paymentPage();
$paymish->product();
$paymish->customer();
$paymish->business();
$paymish->splitPage();
$paymish->subaccount();
$paymish->dispute();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for recent changes.

## Contributing

Contributions are welcome — open a pull request or [issue](https://github.com/bhekor/paymish-php/issues).

## Credits

- [Ibidapo Adeolu (bhekor)](https://github.com/bhekor)

## License

The MIT License (MIT). Please see [LICENSE.md](LICENSE.md) for more information.
