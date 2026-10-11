<?php

namespace Bhekor\Paymish\Tests\Unit;

use Bhekor\Paymish\Api\AuthApi;
use Bhekor\Paymish\Api\TransactionApi;
use Bhekor\Paymish\Exceptions\AuthenticationException;
use Bhekor\Paymish\PaymishClient;
use PHPUnit\Framework\TestCase;

class PaymishClientTest extends TestCase
{
    protected PaymishClient $client;

    protected function setUp(): void
    {
        $this->client = new PaymishClient(
            'test-api-key',
            'https://api.paymish.com',
            30,
            false
        );
    }

    public function test_it_can_be_instantiated(): void
    {
        $this->assertInstanceOf(PaymishClient::class, $this->client);
    }

    public function test_it_loads_default_endpoints(): void
    {
        $endpoints = $this->client->getEndpoints();

        $this->assertArrayHasKey('auth', $endpoints);
        $this->assertArrayHasKey('transaction', $endpoints);
        $this->assertNotEmpty($this->client->getEndpoint('auth', 'generate_token'));
    }

    public function test_it_returns_auth_api_instance(): void
    {
        $this->assertInstanceOf(AuthApi::class, $this->client->auth());
    }

    public function test_it_returns_transaction_api_instance(): void
    {
        $this->assertInstanceOf(TransactionApi::class, $this->client->transaction());
    }

    public function test_it_can_set_bearer_token(): void
    {
        $this->client->setBearerToken('test-token');
        $this->assertEquals('test-token', $this->client->getBearerToken());
    }

    public function test_it_can_check_live_mode(): void
    {
        $this->assertFalse($this->client->isLive());

        $liveClient = new PaymishClient('test-key', 'https://api.paymish.com', 30, true);
        $this->assertTrue($liveClient->isLive());
    }

    public function test_auth_credentials_prefer_keys(): void
    {
        $client = new PaymishClient(
            null,
            'https://api.paymish.com',
            30,
            false,
            null,
            'pk_test',
            'sk_test',
            'user@example.com',
            'password',
        );

        $this->assertSame([
            'public_key' => 'pk_test',
            'secret_key' => 'sk_test',
        ], $client->authCredentials());
    }

    public function test_ensure_authenticated_requires_credentials(): void
    {
        $this->expectException(AuthenticationException::class);
        $this->client->ensureAuthenticated();
    }

    public function test_build_endpoint_replaces_placeholders(): void
    {
        $endpoint = $this->client->buildEndpoint('/verify/{reference}', ['reference' => 'TXN_1']);
        $this->assertSame('/verify/TXN_1', $endpoint);
    }

    public function test_it_loads_bearer_token_from_psr16_cache(): void
    {
        $publicKey = 'pk_test';
        $secretKey = 'sk_test';
        $baseUrl = 'https://api.paymish.com';
        $cacheKey = 'paymish.bearer.'.md5($baseUrl.'|'.json_encode([
            'public_key' => $publicKey,
            'secret_key' => $secretKey,
        ]));

        $cache = new ArrayCache;
        $cache->set($cacheKey, 'cached-bearer-token');

        $client = new PaymishClient(
            null,
            $baseUrl,
            30,
            false,
            null,
            $publicKey,
            $secretKey,
            null,
            null,
            3500,
            $cache,
        );

        $client->ensureAuthenticated();

        $this->assertSame('cached-bearer-token', $client->getBearerToken());
    }
}
