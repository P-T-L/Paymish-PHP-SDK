<?php

namespace Bhekor\Paymish\Tests\Unit;

use Bhekor\Paymish\Support\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    public function test_it_gets_top_level_keys(): void
    {
        $data = ['message' => 'ok', 'count' => 2];

        $this->assertSame('ok', Arr::get($data, 'message'));
        $this->assertSame(2, Arr::get($data, 'count'));
    }

    public function test_it_supports_dot_notation(): void
    {
        $data = [
            'data' => [
                'token' => 'abc',
                'nested' => ['status' => 'completed'],
            ],
        ];

        $this->assertSame('abc', Arr::get($data, 'data.token'));
        $this->assertSame('completed', Arr::get($data, 'data.nested.status'));
    }

    public function test_it_returns_default_for_missing_keys(): void
    {
        $this->assertNull(Arr::get([], 'missing'));
        $this->assertSame('fallback', Arr::get(['a' => 1], 'b', 'fallback'));
        $this->assertSame('fallback', Arr::get(['a' => ['b' => 1]], 'a.c', 'fallback'));
    }
}
