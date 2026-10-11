# Transactions

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

## Initialize (hosted / redirect)

```php
$response = $paymish->transaction()->initialize([
    'email' => 'customer@email.com',
    'amount' => '10000',
    'currency' => 'NGN',
    'channels' => ['card', 'ussd', 'nqr', 'transfer'],
    'callback_url' => 'https://your-site.com/callback',
]);
```

## Initialize with Dynamic Virtual Account

```php
$response = $paymish->transaction()->initializeDva([
    'email' => 'customer@email.com',
    'amount' => '10000',
    'reference' => 'unique-reference',
]);
```

## Verify

```php
$response = $paymish->transaction()->verify('transaction-reference');
// data.status: completed | failed | pending | reversed
```

## Name enquiry

```php
$response = $paymish->transaction()->verifyAccount([
    'bankCode' => '058',
    'accountNumber' => '0123456789',
]);
```

## List & refund

```php
$response = $paymish->transaction()->list([
    'status' => 'completed',
    'page' => 1,
    'limit' => 20,
]);

$response = $paymish->transaction()->refund([
    'transactionRef' => 'TXN_...',
    'amount' => 100,
]);
```

## Channel helpers (sandbox/test only)

Prefer hosted `initialize()` in production to reduce PCI scope.

```php
$paymish->transaction()->withCard([/* customerId, amount, cardNumber, expiryYear, expiryMonth, cvv */]);
$paymish->transaction()->withUssd(['customerId' => 8, 'amount' => 100]);
$paymish->transaction()->withQr([/* customerId, amount, mch_no, sub_mch_no */]);
$paymish->transaction()->withBank([/* customerId, amount, AccountNumber, DestinationInstitutionCode */]);
$paymish->transaction()->withNdd([/* customerId, amount, ndd => [...] */]);

$paymish->transaction()->verifyUssd(['ussdTransactionId' => '...', 'isLive' => false]);
$paymish->transaction()->verifyBank([/* DestinationInstitutionCode, AccountNumber, isLive */]);
$paymish->transaction()->getBanks(false);
```

See the [OpenAPI docs](https://api.paymish.com/api/user-service/external/v1/docs/) for full payloads.
