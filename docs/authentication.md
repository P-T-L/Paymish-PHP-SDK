# Authentication

The SDK obtains a bearer JWT from Paymish and attaches it to subsequent requests.

## Credentials

Prefer OpenAPI public/secret keys. Email/password also works.

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(
    publicKey: getenv('PAYMISH_PUBLIC_KEY') ?: null,
    secretKey: getenv('PAYMISH_SECRET_KEY') ?: null,
);

// Or:
$paymish = new PaymishClient(
    email: getenv('PAYMISH_EMAIL') ?: null,
    password: getenv('PAYMISH_PASSWORD') ?: null,
);
```

When both key pairs and email/password are provided, **keys win**.

## Automatic auth

`PaymishClient` calls `ensureAuthenticated()` before authenticated API methods. You usually do not need to generate a token manually.

## Manual token generation

```php
$response = $paymish->auth()->generateToken([
    'public_key' => '...',
    'secret_key' => '...',
]);
// or: ['email' => '...', 'password' => '...']

$token = $paymish->getBearerToken();
```

You can also set a token yourself:

```php
$paymish->setBearerToken('eyJ...');
```

## Token caching

Without a cache, the bearer token is kept in memory for the lifetime of the client instance.

Pass a `Psr\SimpleCache\CacheInterface` to persist tokens across requests (e.g. Redis, APCu, filesystem):

```php
$paymish = new PaymishClient(
    publicKey: '...',
    secretKey: '...',
    tokenCacheSeconds: 3500,
    cache: $cache,
);
```

On HTTP 401, the client clears the cached token, re-authenticates once, and retries the request.
