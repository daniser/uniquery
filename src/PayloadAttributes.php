<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Exception;

/**
 * @template TResult of ResultInterface
 */
trait PayloadAttributes
{
    public function getEndpoint(): string
    {
        return attribute($this->getPayload(), Attributes\Endpoint::class)->endpoint ?? '';
    }

    public function getMethod(): string
    {
        return attribute($this->getPayload(), Attributes\Method::class)->method ?? 'POST';
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return attribute($this->getPayload(), Attributes\Headers::class)->headers ?? [];
    }

    /**
     * @throws Exception
     */
    public function getResultType(): string
    {
        /** @var class-string<TResult> */
        return attribute($this->getPayload(), Attributes\ResultType::class)->type
            ?? throw new Exception('ResultType attribute not defined.');
    }
}
