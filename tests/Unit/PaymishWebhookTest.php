<?php

namespace Bhekor\Paymish\Tests\Unit;

use Bhekor\Paymish\PaymishWebhook;
use PHPUnit\Framework\TestCase;

class PaymishWebhookTest extends TestCase
{
    public function test_empty_secret_is_noop(): void
    {
        $this->assertTrue(PaymishWebhook::valid('{"a":1}', null, null));
        $this->assertTrue(PaymishWebhook::valid('{"a":1}', null, ''));
    }

    public function test_valid_signature_passes(): void
    {
        $body = '{"event":"charge.success"}';
        $secret = 'whsec_test';
        $signature = hash_hmac('sha512', $body, $secret);

        $this->assertTrue(PaymishWebhook::valid($body, $signature, $secret));
        $this->assertTrue(PaymishWebhook::valid($body, strtoupper($signature), $secret));
    }

    public function test_invalid_or_missing_signature_fails(): void
    {
        $body = '{"event":"charge.success"}';
        $secret = 'whsec_test';

        $this->assertFalse(PaymishWebhook::valid($body, null, $secret));
        $this->assertFalse(PaymishWebhook::valid($body, '', $secret));
        $this->assertFalse(PaymishWebhook::valid($body, 'deadbeef', $secret));
    }
}
