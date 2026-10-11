# Splits & subaccounts

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Split pages

```php
$response = $paymish->splitPage()->create([
    'name' => 'Revenue Split',
    'splitType' => 'percentage',
]);

$response = $paymish->splitPage()->list(['page' => 1, 'limit' => 10]);
$response = $paymish->splitPage()->get(1);
$response = $paymish->splitPage()->update(1, [/* ... */]);
$response = $paymish->splitPage()->delete(1);

// Paymish API field name is `shere` (not `share`)
$response = $paymish->splitPage()->addSubaccount(1, [
    'shere' => 50,
    'sub_account_id' => 'ACCT_...',
]);

$response = $paymish->splitPage()->updateSubaccount(1, [/* ... */]);
$response = $paymish->splitPage()->deleteSubaccount(1);
```

## Subaccounts

```php
$response = $paymish->subaccount()->create([
    'business_name' => 'My Business',
    'account_number' => '1234567890',
    'percentage_charge' => 10,
    'currency' => 'NGN',
    'bank' => 999004,
    'account_name' => 'Account Name',
]);

$response = $paymish->subaccount()->list(['page' => 1, 'limit' => 10]);
$response = $paymish->subaccount()->get(1);
$response = $paymish->subaccount()->update(1, [/* ... */]);
$response = $paymish->subaccount()->delete(1);
```
