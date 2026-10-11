<?php

namespace Bhekor\Paymish\Api;

use Bhekor\Paymish\PaymishClient;
use Bhekor\Paymish\Responses\ApiResponse;
use Bhekor\Paymish\Support\Arr;

class AuthApi
{
    protected PaymishClient $client;

    public function __construct(PaymishClient $client)
    {
        $this->client = $client;
    }

    /**
     * Generate authentication token.
     *
     * Accepts either OpenAPI shape (public_key, secret_key) or email/password.
     *
     * @param  array<string, mixed>  $credentials
     */
    public function generateToken(array $credentials): ApiResponse
    {
        $endpoint = $this->client->getEndpoint('auth', 'generate_token');
        // Token endpoint must not recurse into auto-auth.
        $response = $this->client->post($endpoint, $credentials, [], false);

        $payload = $response->toArray();
        $token = $response->get('token')
            ?? $response->get('access_token')
            ?? Arr::get($payload, 'data.token')
            ?? Arr::get($payload, 'data.access_token');

        if (is_string($token) && $token !== '') {
            $this->client->setBearerToken($token);
        }

        return $response;
    }
}
