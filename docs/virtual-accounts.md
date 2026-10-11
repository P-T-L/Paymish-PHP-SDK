# Virtual accounts

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Dedicated virtual accounts

```php
$response = $paymish->dedicatedVirtualAccount()->create([
    'customerId' => 'cust_...',
    'firstName' => 'John',
    'lastName' => 'Doe',
    'email' => 'customer@email.com',
    'phoneNumber' => '08012345678',
    'bvn' => '22222222226', // test placeholder
    'dob' => '1990-01-15',
    'address' => '123 Main Street, Lagos',
    'gender' => 'Male',
]);
```

Never hardcode live BVNs in application code.

## Virtual accounts

```php
$response = $paymish->virtualAccount()->create([/* ... */]);
$response = $paymish->virtualAccount()->list(['page' => 1, 'limit' => 20]);
$response = $paymish->virtualAccount()->get($id);
$response = $paymish->virtualAccount()->update($id, [/* ... */]);
```

For one-off collection via DVA, see also `transaction()->initializeDva()` in [transactions.md](transactions.md).
