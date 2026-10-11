# Customers & business

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Customers

```php
$response = $paymish->customer()->create([
    'email' => 'john@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe',
    'phone_number' => '08012345678',
]);

$response = $paymish->customer()->list([
    'limit' => 10,
    'page' => 1,
    'search' => 'John',
]);

$response = $paymish->customer()->getById(1);
$response = $paymish->customer()->update([/* ... */]);
$response = $paymish->customer()->blacklist([
    'id' => 1,
    'isBlackListed' => true,
]);
```

## Business

```php
$response = $paymish->business()->changeMode(true); // live mode
$response = $paymish->business()->getDetails();
$response = $paymish->business()->list();

$response = $paymish->business()->create([
    'countryId' => 1,
    'businessName' => 'My Business',
    'businessCategory' => 'Retail',
    'businessDescription' => 'Description',
]);
```
