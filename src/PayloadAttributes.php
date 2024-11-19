<?php

declare(strict_types=1);

namespace TTBooking\UniQuery;

use Exception;

/**
 * @template TResult of ResultInterface
 */
trait PayloadAttributes
{
    /**
     * @throws Exception
     */
    public function getEndpoint(): string
    {
        return attribute($this->getPayload(), Attributes\Endpoint::class)?->endpoint
            ?? throw new Exception('Endpoint attribute not defined.');
    }

    /**
     * @throws Exception
     */
    public function getMethod(): string
    {
        return attribute($this->getPayload(), Attributes\Method::class)?->method
            ?? throw new Exception('Method attribute not defined.');
    }

    /**
     * @return array<string, string>
     *
     * @throws Exception
     */
    public function getHeaders(): array
    {
        return attribute($this->getPayload(), Attributes\Headers::class)?->headers
            ?? throw new Exception('Headers attribute not defined.');
    }

    /**
     * @throws Exception
     */
    public function getResultType(): string
    {
        /** @var class-string<TResult> */
        return attribute($this->getPayload(), Attributes\ResultType::class)?->type
            ?? throw new Exception('ResultType attribute not defined.');
    }
}
