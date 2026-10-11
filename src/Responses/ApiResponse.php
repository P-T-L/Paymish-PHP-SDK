<?php

namespace Bhekor\Paymish\Responses;

use ArrayAccess;
use Bhekor\Paymish\Support\Arr;
use JsonSerializable;

class ApiResponse implements ArrayAccess, JsonSerializable
{
    protected int $statusCode;

    protected array $data;

    public function __construct(int $statusCode, array $data = [])
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function successful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function all(): array
    {
        return $this->data;
    }

    /**
     * Get a specific value from the response (supports dot notation).
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->data, $key, $default);
    }

    public function data(mixed $default = null): mixed
    {
        return $this->get('data', $default);
    }

    public function message(): ?string
    {
        $message = $this->get('message');

        return is_string($message) ? $message : null;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function jsonSerialize(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function toJson(): string
    {
        return json_encode($this->data);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
