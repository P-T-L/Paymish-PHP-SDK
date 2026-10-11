# Webhooks

Paymish OpenAPI does not document a webhook HMAC scheme. This SDK includes an optional Paystack-style helper (HMAC-SHA512 hex of the raw body).

If `$secret` is empty or omitted, `PaymishWebhook::valid()` returns `true` (no-op) — you **must** still verify the payment via the API.

```php
use Bhekor\Paymish\PaymishClient;
use Bhekor\Paymish\PaymishWebhook;

$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_PAYMISH_SIGNATURE'] ?? null;
$secret = getenv('PAYMISH_WEBHOOK_SECRET') ?: '';

if (! PaymishWebhook::valid($rawBody, $signature, $secret)) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid webhook signature']);
    exit;
}

$payload = json_decode($rawBody, true) ?? [];
$reference = $payload['data']['reference'] ?? $payload['reference'] ?? null;

if ($reference) {
    $paymish = new PaymishClient(
        publicKey: getenv('PAYMISH_PUBLIC_KEY') ?: null,
        secretKey: getenv('PAYMISH_SECRET_KEY') ?: null,
    );

    $verified = $paymish->transaction()->verify($reference);
    // fulfill order when $verified->successful() and status is completed
}

header('Content-Type: application/json');
echo json_encode(['received' => true]);
```

Always treat webhooks as untrusted until `transaction()->verify()` confirms the payment.
