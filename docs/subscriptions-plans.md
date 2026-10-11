# Subscriptions & plans

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Plans

```php
$response = $paymish->plan()->create([
    'planName' => 'Premium Plan',
    'planAmount' => '50.00',
    'interval' => 'Monthly',
    'planDescription' => 'Premium subscription plan',
]);

$response = $paymish->plan()->list(['status' => 'Active', 'page' => 1, 'limit' => 10]);
$response = $paymish->plan()->getDetails(1);
$response = $paymish->plan()->updateDetails([/* ... */]);
$response = $paymish->plan()->delete(['id' => 1]);
```

## Subscriptions

```php
$response = $paymish->subscription()->create([
    'planId' => 49,
    'customerId' => 'CUST789',
    'amount' => 29.99,
    'interval' => 'monthly',
    'status' => 'active',
]);

$response = $paymish->subscription()->list(['status' => 'active', 'page' => 1, 'limit' => 10]);
$response = $paymish->subscription()->get(1);
$response = $paymish->subscription()->update(1, [/* ... */]);
$response = $paymish->subscription()->delete(1);
```
