<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

interface SerializerInterface
{
    /**
     * @param array<string, mixed> $context
     */
    public function serialize(mixed $data, array $context = []): string;

    /**
     * @template T of object
     *
     * @param class-string<T>      $type
     * @param array<string, mixed> $context
     *
     * @phpstan-return T
     */
    public function deserialize(string $data, string $type, array $context = []): object;
}
