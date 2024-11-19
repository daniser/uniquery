<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

interface ResultInterface
{
    /**
     * @param array<string, mixed> $context
     *
     * @return $this
     */
    public function withContext(array $context): static;

    /**
     * @return array<string, mixed>
     */
    public function getContext(): array;

    /**
     * @return $this
     */
    public function withPayload(object $payload): static;

    public function getPayload(): object;
}
