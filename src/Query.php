<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

/**
 * @template TResult of ResultInterface
 *
 * @implements QueryInterface<TResult>
 */
class Query implements QueryInterface
{
    /** @use PayloadAttributes<TResult> */
    use PayloadAttributes;

    protected string $baseUri;

    /** @var array<string, mixed> */
    protected array $context = [];

    protected object $payload;

    public function withBaseUri(string $baseUri): static
    {
        $this->baseUri ??= $baseUri;

        return $this;
    }

    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    public function withContext(array $context): static
    {
        $this->context = $context + $this->context;

        return $this;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    public function withPayload(object $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }
}
