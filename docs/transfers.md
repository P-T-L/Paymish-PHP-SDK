# Transfers & recipients

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Transfers

```php
$response = $paymish->transfer()->getAllBanks();

$response = $paymish->transfer()->resolveAccount([
    'bankCode' => '058',
    'accountNumber' => '0123456789',
]);

$response = $paymish->transfer()->createSingle([
    'amount' => 1000,
    'bankCode' => '999998',
    'bankName' => 'Zenith Bank',
    'accountNumber' => '0051762787',
    'accountName' => 'Test Account',
    'emailAddress' => 'email@example.com',
    'transferNote' => 'Payment for invoice #1234',
    'transferReference' => 'INV1234TRANS5678',
]);

$response = $paymish->transfer()->getList([
    'status' => 'Successful',
    'page' => 1,
    'limit' => 10,
]);

$response = $paymish->transfer()->getBalance();
$response = $paymish->transfer()->getDetails('TRF_...');
$response = $paymish->transfer()->verifyTransfer('TRF_...'); // prefers transfer code
$response = $paymish->transfer()->submitBulk([/* bulk payload */]);
```

## Recipients

```php
$response = $paymish->recipient()->list(['limit' => 10, 'page' => 1]);
$response = $paymish->recipient()->getDetails('RCP_...');
$response = $paymish->recipient()->delete('RCP_...');
$response = $paymish->recipient()->blacklist([
    'recipientId' => '...',
    'isBlackListed' => true,
]);
```
