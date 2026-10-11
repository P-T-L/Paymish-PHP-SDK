# Errors & responses

## ApiResponse

All API methods return an `ApiResponse`:

```php
$response = $paymish->transaction()->initialize([/* ... */]);

if ($response->successful()) {
    $data = $response->all();
    $transactionId = $response->get('transactionId');
    $nested = $response->get('data.status'); // dot notation supported
    $message = $response->message();
    $status = $response->getStatusCode();

    if ($response->has('data')) {
        $transactionData = $response->data();
    }

    $array = $response->toArray();
}
```

`ApiResponse` also implements `ArrayAccess` and `JsonSerializable`.

## Exceptions

| Exception | Typical cause |
|-----------|----------------|
| `AuthenticationException` | 401 / missing credentials |
| `ValidationException` | 400 with optional `getErrors()` |
| `PaymishException` | 404, 5xx, and other API errors |

```php
use Bhekor\Paymish\Exceptions\AuthenticationException;
use Bhekor\Paymish\Exceptions\ValidationException;
use Bhekor\Paymish\Exceptions\PaymishException;

try {
    $response = $paymish->transaction()->initialize([/* ... */]);
} catch (AuthenticationException $e) {
    // 401 / missing credentials
} catch (ValidationException $e) {
    $errors = $e->getErrors();
} catch (PaymishException $e) {
    echo $e->getMessage();
}
```
