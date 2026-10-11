# Disputes

```php
use Bhekor\Paymish\PaymishClient;

$paymish = new PaymishClient(publicKey: '...', secretKey: '...');
```

```php
$response = $paymish->dispute()->create([
    'image' => '/path/to/evidence.jpg',
    'transactionRef' => 'TXN_...',
    'disputeReason' => 'Product not received',
    'disputeDescription' => 'Detailed description of the dispute',
]);

$response = $paymish->dispute()->list(['limit' => 10, 'page' => 1]);
$response = $paymish->dispute()->getDetails('TXN_...');
$response = $paymish->dispute()->update([/* ... */]);
```
