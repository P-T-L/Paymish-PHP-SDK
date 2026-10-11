<?php

namespace Bhekor\Paymish;

/**
 * Optional webhook signature helper.
 *
 * Paymish OpenAPI does not document a webhook HMAC scheme. When a secret is
 * provided, this helper can require HMAC-SHA512 hex of the raw body (Paystack-style).
 */
class PaymishWebhook
{
    /**
     * Validate an optional HMAC-SHA512 webhook signature.
     *
     * When `$secret` is empty, signature check is a no-op (returns true).
     * Callers must still re-verify payments via the API.
     */
    public static function valid(string $rawBody, ?string $signatureHeader, ?string $secret = null): bool
    {
        $secret = is_string($secret) ? $secret : '';
        if ($secret === '') {
            return true;
        }

        if (! is_string($signatureHeader) || trim($signatureHeader) === '') {
            return false;
        }

        $computed = strtoupper(hash_hmac('sha512', $rawBody, $secret));

        return hash_equals($computed, strtoupper(trim($signatureHeader)));
    }
}
